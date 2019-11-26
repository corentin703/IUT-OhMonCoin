<?php

namespace App\Http\Controllers;

use App\Advert;
use App\Repositories\AdvertFollowRepository;
use App\Repositories\AdvertRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

class AdvertController extends Controller
{
    private $advertRepository;
    private $advertFollowRepository;

    public function __construct(AdvertRepository $advertRepository, AdvertFollowRepository $advertFollowRepository)
    {
        $this->advertRepository = $advertRepository;
        $this->advertFollowRepository = $advertFollowRepository;

        $this->authorizeResource(Advert::class, 'advert');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user = null)
    {
        if ($user)
        {
            return view('advert.index', [
                'title' => "Annonces de " . $user->name,
                'adverts' => $this->advertRepository->getByUser($user),
                'canCreate' => (Auth::id() === $user->id),
            ]);
        }

        return view('advert.index', [
            'title' => "Annonces actuelles",
            'adverts' => $this->advertRepository->all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
//        if (Gate::allows('advert-create')) {
        $data = $request->all();

        if ($request->hasFile('pictures'))
            $data['pictures'] = $request->file('pictures');

        $this->advertRepository->create($data);

        return Redirect::route('home');
//        }
//        else
//            return abort(403);
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
//        if (Gate::allows('advert-update', $advert))
//        {
        return view('advert.edit', [
            'advert' => $advert,
            'pictures' => $advert->pictures,
        ]);
//        }
//        else
//            return abort(403);
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
//        if (Gate::allows('advert-update', $advert))
//        {
        $data = $request->all();

        if ($request->hasFile('pictures'))
            $data['pictures'] = $request->file('pictures');

        $this->advertRepository->update($data, $advert);

        return Redirect::back();
//        }
//        else
//            return abort(403);
    }

    /**
     * Follow the specified resource in storage.
     *
     * @param  \App\Advert  $advert
     * @return \Illuminate\Http\JsonResponse
     */
    public function follow(Advert $advert)
    {
//        if (Gate::allows('advert-follow', $advert))
//        {
        $this->authorize('follow', Advert::class);

        $advertFollow = $this->advertFollowRepository->getByUserAndModel(Auth::user(), $advert);

        if ($advertFollow)
        {
            $this->advertFollowRepository->delete($advertFollow);

            return Response::json(['follow' => false], 200);
        }
        else
        {
            $this->advertFollowRepository->create([
                'advert' => $advert,
                'user' => Auth::user(),
            ]);

            return Response::json(['follow' => true], 200);
        }
//
//        }
//        else
//            return abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Advert  $advert
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Advert $advert)
    {
//        if (Gate::allows('advert-update', $advert))
//        {
        $this->advertRepository->delete($advert);

        return Redirect::route('home');
//        }
//        else
//            return abort(403);
    }
}
