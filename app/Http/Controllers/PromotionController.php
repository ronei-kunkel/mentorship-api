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
        $promomotion = $this->promomotion->orderBy('id')
                    ->get();

        $response = [
            'success' => true,
            'promomotion'   => []
        ];

        if(is_null($promomotion)) return $response;

        $response['promomotion'] = $promomotion;

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
        $promomotion = $this->promotion->create($request->all());

        return $promomotion;
    }

    /**
     * Display the specified resource.
     *
     * @param  int      $id
     * @return Response
     */
    public function show($id)
    {
        $promomotion = $this->promotion->find($id);

        $response = [
            'success'   => true,
            'promotion' => null
        ];

        if(is_null($promomotion)) return $response;

        $response['promotion'] = $promomotion->getAttributes();

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
        $promomotion = $this->promotion->find($id);

        $oldPromotionData = $promomotion->getAttributes();

        $requestData = $request->all();

        $response = [
            'success' => true,
            'message' => 'Nothing to update'
        ];

        if(!$this->haveChanges($requestData, $oldPromotionData)) return $response;

        $promomotion->update($requestData);
        $newPromotionData = $promomotion->getAttributes();

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
        $promomotion = $this->promotion->find($id);

        (is_null($promomotion)) ? $success = false : $success = $promomotion->delete();

        return ['success' => $success];
    }
}
