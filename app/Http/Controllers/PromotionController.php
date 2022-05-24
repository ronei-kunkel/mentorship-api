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
            'success'   => true
        ];

        if($promotion->isEmpty()) {
            $response['message']   = 'There are no promotions yet!';
            return response()->json($response, 404);
        }

        $response['promotion'] = $promotion;

        return $response;
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
        $request = $request->all();

        $requiredFields = ['name', 'start_date', 'end_date', 'value_type', 'status', 'frequency', 'price_field', 'change'];

        $return = [
            'success' => false,
            'message' => ''
        ];

        foreach($requiredFields as $field) {
            if (!isset($request["$field"])) {
                $return['message'] .= "The field '$field' is required! ";
            }
        }

        if($return['message']) return $return;

        $request['value'] = (float) $request['value'];

        echo "<pre>";
        var_dump($request);
        echo "</pre>";
        exit;

        if(!date_format($request['start_date'], 'YYYY-mm-dd')) {
            $return['message'] = 'Value to field \'start_date\' needs to match the pattern \'YYYY-mm-dd hh:mm:ss\'';
            return $return;
        }

        if(!date_format($request['end_date'], 'YYYY-mm-dd')) {
            $return['message'] = 'Value to field \'end_date\' needs to match the pattern \'YYYY-mm-dd hh:mm:ss\'';
            return $return;
        }

        if(!in_array($request['status'], ['active', 'inactive'])){
            $return['message'] = 'Value to field \'status\' needs to be \'active\' or \'inactive\'';
            return $return;
        }

        if(!in_array($request['frequency'], ['single', 'weekly', 'monthly', 'annual'])){
            $return['message'] = 'Value to field \'frequency\' needs to be \'single\' or \'weekly\' or \'monthly\' or \'annual\'';
            return $return;
        }

        if(!in_array($request['price_field'], ['price', 'promotional_price'])){
            $return['message'] = 'Value to field \'price_field\' needs to be \'price\' or \'promotional_price\'';
            return $return;
        }





        // if(!number_format((str) $request['value'], 2,'.','')){
        //     $return['message'] = 'Value to field \'price_field\' needs to be \'price\' or \'promotional_price\'';
        //     return $return;
        // }

        $promotion = $this->promotion->create($request);

        return $promotion;
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
