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

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $category = $this->category->orderBy('level')
            ->orderBy('parent')
            ->orderBy('id')
            ->get();

        $response = [
            'success' => true,
            'category'   => []
        ];

        if ($category->isEmpty()) {
            $response['message'] = 'There are no data of category yet';
            return response()->json($response, 404);
        }

        $response['category'] = $category;

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
        $receivedValues = $request->validate($this->category->rules(), $this->category->feedback());

        $this->validateHierarchy($receivedValues);

        $category = $this->category->create($receivedValues);

        $return = [
            'message'  => 'Category successfully created.',
            'category' => $category
        ];

        return response()->json($return, 201);
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

        if (is_null($category)) return $response;

        $response['category'] = $category->getAttributes();

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
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $category = $this->category->find($id);

        $oldCategoryData = $category->getAttributes();

        $requestData = $request->all();

        $requestData['level'] = (int) $requestData['level'];

        if ($requestData['parent']) $requestData['parent'] = (int) $requestData['parent'];

        $response = [
            'success' => true,
            'message' => 'Nothing to update'
        ];

        if (!$this->haveChanges($requestData, $oldCategoryData)) return $response;

        $category->update($requestData);
        $newCategoryData = $category->getAttributes();

        $response['message'] = 'Updated';
        $response['newData'] = $newCategoryData;
        $response['oldData'] = $oldCategoryData;

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


    private function validateHierarchy($receivedValues)
    {
        if (isset($receivedValues['parent']) and !is_null($receivedValues['parent'])) {
            $parentCategory = $this->category->find($receivedValues['parent']);

            // check if exists parent category 
            if (is_null($parentCategory)) return response()->json(
                [
                    'message' => 'The parent category you entered doesn\'t yet exist.',
                    'errors'  => [
                        'parent' => [
                            'The parent category doesn\'t exist'
                        ]
                    ]
                ],
                406
            );

            // check if the level of parent is equal to category
            if ($parentCategory['level'] == $receivedValues['level']) return response()->json(
                [
                    'message' => 'The level of category and parent can\'t be equals. The category level must be greater than parent category level.',
                    'errors'  => [
                        'level' => [
                            'The value are equal to parent category level'
                        ]
                    ]
                ],
                409
            );
        }
    }
}
