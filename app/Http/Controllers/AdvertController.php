<?php

namespace App\Http\Controllers;

use App\Advert;
use App\Repositories\AdvertRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AdvertController extends Controller
{
    private $advertRepository;

    public function __construct(AdvertRepository $advertRepository)
    {
        $this->advertRepository = $advertRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Response::json($this->advertRepository->all(), 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        if ($request->hasFile('pictures'))
            $data['pictures'] = $request->file('pictures');

        $advert = $this->advertRepository->create($data);

        return Response::json($advert, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Advert  $advert
     * @return \Illuminate\Http\Response
     */
    public function show(Advert $advert)
    {
        return $this->advertRepository->show($advert);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Advert  $advert
     * @return \Illuminate\Http\Response
     */
    public function edit(Advert $advert)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Advert  $advert
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Advert $advert)
    {
        $advert = $this->advertRepository->update($request->all(), $advert);

        return $advert;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Advert  $advert
     * @return \Illuminate\Http\Response
     */
    public function destroy(Advert $advert)
    {
        $this->advertRepository->delete($advert);

        return Response::json(null, 201);
    }
}
