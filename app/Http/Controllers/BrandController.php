<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BrandController extends Controller
{
    /**
     * Instance of Brand
     *
     * @var Brand
     */
    protected $brand = null;

    public function __construct(Brand $brand)
    {
        $this->brand = $brand;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $brand = $this->brand->orderBy('name')
            ->get();

        $response = [
            'success' => true,
            'brand'   => []
        ];

        if ($brand->isEmpty()) {
            $response['message'] = 'There are no data of brand yet';
            return response()->json($response, 404);
        }

        $response['brand'] = $brand;

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
        $request->validate($this->brand->rules(), $this->brand->feedback());

        $receivedValues = $request->all();

        $requiredValues = ['name', 'description'];

        $return = [
            'success' => true
        ];

        $checkRequiredValues = $this->checkRequiredValues($requiredValues, $receivedValues);

        if (!empty($checkRequiredValues)) {
            $return['success'] = false;
            $return['message'] = 'Any or more values are missing';
            $return['values'] = $checkRequiredValues;

            return response()->json($return, 400);
        }

        $brand = $this->brand->create($receivedValues);
        $return['brand'] = $brand;

        return response()->json($return, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $response = [
            'success' => true,
            'brand'   => null
        ];

        if(!is_numeric($id) or !isset($id)) {
            $response['success'] = false;
            $response['message'] = 'id of brand is required';
            return $response;
        }

        $brand = $this->brand->find($id);

        if (is_null($brand)) return $response;

        $response['brand'] = $brand->getAttributes();

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
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $response = [
            'success' => true,
            'message' => 'Nothing to update'
        ];

        if(!isset($id) or !is_numeric($id)) {
            $response['success'] = false;
            $response['message'] = 'id of brand is required in endpoint. <br> E.g.: /api/brand/1';
            return $response;
        }

        $request->validate($this->brand->rules(), $this->brand->feedback());

        $brand = $this->brand->find($id);

        $oldBrandData = $brand->getAttributes();

        $requestData = $request->all();


        if (!$this->haveChanges($requestData, $oldBrandData)) return $response;

        $brand->update($requestData);
        $newBrandData = $brand->getAttributes();

        $response['message'] = 'Updated';
        $response['newData'] = $newBrandData;
        $response['oldData'] = $oldBrandData;

        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $brand = $this->brand->find($id);

        $response = [
            'success' => true,
            'message' => 'Deleted'
        ];

        if (is_null($brand)) {
            $response['success'] = false;
            $response['message'] = 'This Brand doesnt exist';
            return $response;
        }

        $brand->delete();

        return $response;
    }
}
