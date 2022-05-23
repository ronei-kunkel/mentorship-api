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
            'success' => true,
            'promotion'   => []
        ];

        if(is_null($promotion)) return $response;

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
        return __METHOD__.' - Not Implemented!';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $promotion = $this->promotion->create($request->all());

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
     * @param  \App\Models\Promotion  $promotion
     * @return Response
     */
    public function edit(Promotion $promotion)
    {
        return __METHOD__.' - Not Implemented!';
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
