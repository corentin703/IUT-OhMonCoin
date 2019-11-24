<?php

namespace App\Http\Controllers;

use App\Picture;
use App\Repositories\AdvertRepository;
use App\Repositories\PictureRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

class PictureController extends Controller
{
    private $advertRepository;
    private $pictureRepository;

    public function __construct(AdvertRepository $advertRepository, PictureRepository $pictureRepository)
    {
        $this->advertRepository = $advertRepository;
        $this->pictureRepository = $pictureRepository;
    }

//    /**
//     * Display a listing of the resource.
//     *
//     * @return \Illuminate\Http\Response
//     */
//    public function index()
//    {
//        //
//    }
//
//    /**
//     * Show the form for creating a new resource.
//     *
//     * @return \Illuminate\Http\Response
//     */
//    public function create()
//    {
//        //
//    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $advert = $this->advertRepository->find($request->input('advert_id'));

        if (Gate::allows('picture-create', $advert))
        {
            $data = $request->all();

            if ($request->hasFile('pictures'))
                $data['pictures'] = $request->file('pictures');

            $data['advert'] = $advert;

            $this->pictureRepository->create($data);
        }
        else
            abort(403);

        return Redirect::back();
    }

//    /**
//     * Display the specified resource.
//     *
//     * @param  \App\Picture  $picture
//     * @return \Illuminate\Http\Response
//     */
//    public function show(Picture $picture)
//    {
//        //
//    }

//    /**
//     * Show the form for editing the specified resource.
//     *
//     * @param  \App\Picture  $picture
//     * @return \Illuminate\Http\Response
//     */
//    public function edit(Picture $picture)
//    {
//        //
//    }

//    /**
//     * Update the specified resource in storage.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @param  \App\Picture  $picture
//     * @return \Illuminate\Http\Response
//     */
//    public function update(Request $request, Picture $picture)
//    {
//        //
//    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Picture  $picture
     * @return \Illuminate\Http\Response
     */
    public function destroy(Picture $picture)
    {
        if (Gate::allows('picture-update', $picture))
        {
            $this->pictureRepository->delete($picture);
        }
        else
            abort(403);
    }
}
