<?php

namespace App\Http\Controllers;

use App\Advert;
use App\Repositories\AdvertRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

class AdvertController extends Controller
{
    private $advertRepository;

    public function __construct(AdvertRepository $advertRepository)
    {
        $this->advertRepository = $advertRepository;
    }

//    /**
//     * Display a listing of the resource.
//     *
//     * @return \Illuminate\Http\Response
//     */
//    public function index()
//    {
//        return Response::json($this->advertRepository->all(), 201);
//    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (Gate::allows('advert-create')) {
            $data = $request->all();

            if ($request->hasFile('pictures'))
                $data['pictures'] = $request->file('pictures');

            $this->advertRepository->create($data);

            return Redirect::route('dashboard');
        }
        else
            abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Advert  $advert
     * @return \Illuminate\Http\Response
     */
    public function show(Advert $advert)
    {
        return view('advert.show', [
            'advert' => $advert,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Advert  $advert
     * @return \Illuminate\Http\Response
     */
    public function edit(Advert $advert)
    {
        if (Gate::allows('advert-update', $advert))
        {
            return view('advert.edit', [
                'advert' => $advert,
            ]);
        }
        else
            abort(403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Advert  $advert
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Advert $advert)
    {
        if (Gate::allows('advert-update', $advert))
        {
            $data = $request->all();

            if ($request->hasFile('pictures'))
                $data['pictures'] = $request->file('pictures');

            $this->advertRepository->update($data, $advert);

            return Redirect::back();
        }
        else
            abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Advert  $advert
     * @return \Illuminate\Http\Response
     */
    public function destroy(Advert $advert)
    {
        if (Gate::allows('advert-update', $advert))
        {
            $this->advertRepository->delete($advert);

            return Redirect::route('dashboard');
        }
        else
            abort(403);
    }
}
