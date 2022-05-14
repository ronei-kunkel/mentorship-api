<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    /**
     * Instance of Category
     *
     * @var Category
     */
    protected $category = null;

    public function __construct(Category $category) {
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $category = $this->category->orderBy('id')
                    ->get();

        $response = [
            'success' => true,
            'category'   => []
        ];

        if(is_null($category)) return $response;

        $response['category'] = $category;

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
        $category = $this->category->create($request->all());

        return $category;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $category
     * @return Response
     */
    public function show($id)
    {
        $category = $this->category->find($id);

        $response = [
            'success'  => true,
            'category' => null
        ];

        if(is_null($category)) return $response;

        $response['category'] = $category->getAttributes();

        return $response;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return Response
     */
    public function edit(Category $category)
    {
        return __METHOD__;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $category = $this->category->find($id);

        $oldCategoryData = $category->getAttributes();

        $requestData = $request->all();

        $requestData['level'] = (int) $requestData['level'];

        if($requestData['parent']) $requestData['parent'] = (int) $requestData['parent'];

        $response = [
            'success' => true,
            'message' => 'Nothing to update'
        ];

        if(
            $oldCategoryData['name']       === $requestData['name']
            and $oldCategoryData['parent'] === $requestData['parent']
            and $oldCategoryData['level']  === $requestData['level']
        ) {
            return $response;
        }

        $category->update($requestData);
        $newCategoryData = $category->getAttributes();
        $response = [
            'success'         => true,
            'message'         => 'Updated',
            'newCategoryData' => $newCategoryData,
            'oldCategoryData' => $oldCategoryData
        ];

        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return Response
     */
    public function destroy($id)
    {
        $category = $this->category->find($id);

        (is_null($category)) ? $success = false : $success = $category->delete();

        return ['success' => $success];
    }
}
