<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PromotionController extends Controller
{
    /**
     * Instance of Promotion
     *
     * @var Promotion
     */
    protected $promotion = null;

    public function __construct(Promotion $promotion) {
        $this->promotion = $promotion;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $promotion = $this->promotion->orderBy('id')
                    ->get();

        $response = [
            'success'   => true,
            'promotion' => []
        ];

        if($promotion->isEmpty()) {
            $response['message']   = 'There are no promotions yet!';
            return response()->json($response, 404);
        }

        $response['promotion'] = $promotion;

        return response()->json($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return response()->json([], 501);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        echo "<pre>";
        print_r($request->validate($this->promotion->rules(), $this->promotion->feedback()));
        echo "</pre>";
        exit;


        $receivedValues = $request->all();

        $return = [
            'success' => true
        ];

        if(!empty($checkRequiredValues)) {
            $return['success'] = false;
            $return['message'] = 'Any or more values are missing';
            $return['values'] = $checkRequiredValues;

            return response()->json($return, 400);
        }

        $promotion = $this->promotion->create($request);
        $return['promotion'] = $promotion;

        return response()->json($return, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int      $id
     * @return Response
     */
    public function show($id)
    {
        $promotion = $this->promotion->find($id);

        $response = [
            'success'   => true,
            'promotion' => null
        ];

        if(is_null($promotion)) return $response;

        $response['promotion'] = $promotion->getAttributes();

        return $response;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit()
    {
        return response()->json([], 501);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int      $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $promotion = $this->promotion->find($id);

        $oldPromotionData = $promotion->getAttributes();

        $requestData = $request->all();

        $response = [
            'success' => true,
            'message' => 'Nothing to update'
        ];

        if(!$this->haveChanges($requestData, $oldPromotionData)) return $response;

        $promotion->update($requestData);
        $newPromotionData = $promotion->getAttributes();

        // in future, when promotion are updated, are necessary check if have products linked in promotion and insert into queue to update the price if have change in any of price fields

        $response['message'] = 'Updated';
        $response['newData'] = $newPromotionData;
        $response['oldData'] = $oldPromotionData;

        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int      $id
     * @return Response
     */
    public function destroy($id)
    {
        $promotion = $this->promotion->find($id);

        (is_null($promotion)) ? $success = false : $success = $promotion->delete();

        return ['success' => $success];
    }
}
