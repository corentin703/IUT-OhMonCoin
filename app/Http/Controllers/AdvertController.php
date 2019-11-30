<?php

namespace App\Http\Controllers;

use App\Advert;
use App\Category;
use App\Repositories\AdvertFollowRepository;
use App\Repositories\AdvertRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    public function index()
    {
        return view('advert.index', [
            'title' => "Annonces actuelles",
            'adverts' => $this->advertRepository->all()->reverse(),
        ]);
    }

    /**
     * Display a listing of the resource by Category.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function indexByCategory(Category $category)
    {
        $this->authorize('view-any', Advert::class);

        return view('advert.index', [
            'title' => "Annonces de catégorie " . $category->name,
            'adverts' => $this->advertRepository->getByCategory($category)->reverse(),
            'canCreate' => false,
        ]);
    }

    /**
     * Display a listing of the resource by User.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function indexByUser(User $user)
    {
        $this->authorize('view-any', Advert::class);

        return view('advert.index', [
            'title' => "Annonces de " . $user->name,
            'adverts' => $this->advertRepository->getByUser($user)->reverse(),
            'canCreate' => (Auth::id() === $user->id),
        ]);
    }

    public function indexByFollow()
    {
//        $this->authorize('viewFollow', User::class);

        return view('advert.index', [
            'title' => "Annonces que vous suivez",
            'adverts' => $this->advertFollowRepository->getAdvertByUser(Auth::user()),
            'canCreate' => false,
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
        $data = $request->all();

        if ($request->hasFile('pictures'))
            $data['pictures'] = $request->file('pictures');

        $this->advertRepository->create($data);

        return Redirect::route('home');
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
        return Response::view('advert.edit', [
            'advert' => $advert,
            'pictures' => $advert->pictures,
        ]);
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
        $data = $request->all();

        if ($request->hasFile('pictures'))
            $data['pictures'] = $request->file('pictures');

        $this->advertRepository->update($data, $advert);

        return Redirect::back();
    }

    /**
     * Follow the specified resource in storage.
     *
     * @param \App\Advert $advert
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function follow(Advert $advert)
    {
        $this->authorize('follow', $advert);

        $advertFollow = $this->advertFollowRepository->getByUserAndModel(Auth::user(), $advert);

        if ($advertFollow)
        {
            $this->advertFollowRepository->delete($advertFollow);
        }
        else
        {
            $this->advertFollowRepository->create([
                'advert' => $advert,
                'user' => Auth::user(),
            ]);
        }

        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Advert  $advert
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Advert $advert)
    {
        $this->advertRepository->delete($advert);

        return Redirect::route('home');
    }
}
