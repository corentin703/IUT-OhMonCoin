<?php

namespace App\Http\Controllers\API;

use App\Advert;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdvertCreateRequest;
use App\Http\Requests\AdvertUpdateRequest;
use App\Http\Resources\AdvertResource;
use App\Repositories\AdvertRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AdvertController extends Controller
{
    private $advertRepository;

    public function __construct(AdvertRepository $advertRepository)
    {
        $this->advertRepository = $advertRepository;

        $this->authorizeResource(Advert::class, 'advert');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return AdvertResource::collection($this->advertRepository->all());
    }

//    /**
//     * Store a newly created resource in storage.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @return \Illuminate\Http\Response
//     */
//    public function store(AdvertCreateRequest $request)
//    {
//        //
//    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Advert  $advert
     * @return AdvertResource
     */
    public function show(Advert $advert)
    {
        return AdvertResource::make($advert);
    }

    /**
     * Search a resource in storage from given string.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function search(Request $request)
    {
        $string = $request->input('search');
        $category = $request->input('category');

        $result = $this->advertRepository->search($string, $category);

        if ($result === null)
            return Response::json('No data found', 404);

        return AdvertResource::collection($this->advertRepository->search($string, $category));
    }

//    /**
//     * Update the specified resource in storage.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @param  \App\Advert  $advert
//     * @return \Illuminate\Http\Response
//     */
//    public function update(AdvertUpdateRequest $request, Advert $advert)
//    {
//        //
//    }

//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  \App\Advert  $advert
//     * @return \Illuminate\Http\JsonResponse
//     */
//    public function destroy(Advert $advert)
//    {
//        $advert->delete();
//
//        return Response::json('success', 200);
//    }
}
