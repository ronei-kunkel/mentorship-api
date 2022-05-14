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

    public function __construct(Brand $brand) {
        $this->brand = $brand;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $brand = $this->brand->orderBy('id')
                    ->get();

        $response = [
            'success' => true,
            'brand'   => []
        ];

        if(is_null($brand)) return $response;

        $response['brand'] = $brand;

        return $response;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return __METHOD__;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $brand = $this->brand->create($request->all());

        return $brand;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $brand = $this->brand->find($id);
        
        $response = [
            'success' => true,
            'brand'   => null
        ];
        
        if(is_null($brand)) return $response;

        $response['brand'] = $brand->getAttributes();

        return $response;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return Response
     */
    public function edit(Brand $brand)
    {
        return __METHOD__;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $brand = $this->brand->find($id);

        $oldBrandData = $brand->getAttributes();

        $requestData = $request->all();

        $response = [
            'success' => true,
            'message' => 'Nothing to update'
        ];

        if(
            $oldBrandData['name']            === $requestData['name']
            and $oldBrandData['description'] === $requestData['description']
        ) {
            return $response;
        }

        $brand->update($requestData);
        $newBrandData = $brand->getAttributes();
        $response = [
            'success' => true,
            'message' => 'Updated',
            'newBrandData' => $newBrandData,
            'oldBrandData' => $oldBrandData
        ];

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

        (is_null($brand)) ? $success = false : $success = $brand->delete();

        return ['success' => $success];
    }

    /**
     * Check if data of objects are equal
     *
     * @param Object $new
     * @param Object $old
     * @return bool
     */
    public function dataObjectsAreEquals(Object $new, Object $old)
    {
        $equal = true;
        foreach($old as $index => $dataOld) {
            if($dataOld === $new[$index]) continue;
            $equal = false;
        };
        return $equal;
    }
}
