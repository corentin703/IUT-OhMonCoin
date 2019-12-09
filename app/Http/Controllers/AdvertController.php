<?php

namespace App\Http\Controllers;

use App\Advert;
use App\Category;
use App\Http\Requests\AdvertUpdateRequest;
use App\Repositories\AdvertFollowRepository;
use App\Repositories\AdvertRepository;
use App\Repositories\MessageRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

class AdvertController extends Controller
{
    private $advertRepository;
    private $advertFollowRepository;
    private $messageRepository;

    public function __construct(AdvertRepository $advertRepository, AdvertFollowRepository $advertFollowRepository, MessageRepository $messageRepository)
    {
        $this->advertRepository = $advertRepository;
        $this->advertFollowRepository = $advertFollowRepository;
        $this->messageRepository = $messageRepository;

        $this->authorizeResource(Advert::class, 'advert');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $string = $request->input('string');
        $category = $request->input('category');
        $followed = ($request->input('followed') == "true");
        $user = $request->input('user');

        if ($category || $string || $followed || $user)
        {
            if ($followed)
                $title = "Les annonces que vous suivez";
            elseif ($user == Auth::id())
                $title = "Les annonces que vous avez posté";
            else
                $title = "Résultat de la recherche";


            return view('adverts.index', [
                'title' => $title,
                'adverts' => $this->advertRepository->search([
                    'category' => $category,
                    'string' => $string,
                    'followed' => $followed,
                    'user' => $user,
                ]),
                'stringSearched' => $string,
                'categorySearched' => $category,
                'searched' => true,
                'isCurrentUserPage' => ($user == Auth::id()),
            ]);
        }

        return view('adverts.index', [
            'title' => "Annonces actuelles",
            'adverts' => $this->advertRepository->all()->reverse(),
        ]);
    }

    /**
     * Display a listing of the resources which have been trashed.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexTrashed()
    {
        return view('adverts.restore', [
            'adverts' => $this->advertRepository->getTrashedByUser(Auth::user())->reverse(),
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Advert $advert)
    {
        if (Auth::check())
        {
            if ($advert->user->id === Auth::id())
                $messages = $advert->messages;
            else
                $messages = $this->messageRepository->getByAdvertAndUser($advert, Auth::id());
        }
        else
            $messages = [];

        return view('adverts.show', [
            'advert' => $advert,
            'conversations' => $messages,
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
        return Response::view('adverts.edit', [
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
    public function update(AdvertUpdateRequest $request, Advert $advert)
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
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function follow(Advert $advert)
    {
        $this->authorize('follow', $advert);

        $advertFollow = $this->advertFollowRepository->getByUserAndModel(Auth::user(), $advert);

        if ($advertFollow)
            $this->advertFollowRepository->delete($advertFollow);
        else
        {
            $this->advertFollowRepository->create([
                'advert' => $advert,
                'user' => Auth::user(),
            ]);
        }

        return Response::json(['success' => true], 200);
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

    /**
     * Remove permanently the specified resource from storage.
     *
     * @param \App\Advert $advert
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete($advert)
    {
        $this->advertRepository->forceDelete($this->advertRepository->findTrashed($advert));

        return Redirect::route('home');
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param int $advert
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function restore($advert)
    {
        $advert = $this->advertRepository->findTrashed($advert);

        $this->authorize('restore', $advert);

        $this->advertRepository->restore($advert);

        return Redirect::back();
    }
}
