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
        return __METHOD__;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store()
    {
        return __METHOD__;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return Response
     */
    public function show(Promotion $promotion)
    {
        return __METHOD__;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return Response
     */
    public function edit(Promotion $promotion)
    {
        return __METHOD__;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Promotion  $promotion
     * @return Response
     */
    public function update(Request $request, Promotion $promotion)
    {
        return __METHOD__;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return Response
     */
    public function destroy(Promotion $promotion)
    {
        return __METHOD__;
    }

    /**
     * Check if data of arrays are equal
     *
     * @param array $new
     * @param array $old
     * @return bool
     */
    public function haveChanges($new, $old)
    {
        $haveChanges = false;
        foreach($new as $index => $dataNew) {
            if($dataNew === $old[$index]) continue;
            $haveChanges = true;
        }
        return $haveChanges;
    }
}
