<?php

namespace App\Http\Controllers;

use App\Advert;
use App\Category;
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
            'isCurrentUserPage' => false,
        ]);
    }

    /**
     * Display a listing of the resource by User.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexByUser(User $user)
    {
        $this->authorize('view-any', Advert::class);

        return view('advert.index', [
            'title' => "Annonces de " . $user->name,
            'adverts' => $this->advertRepository->getByUser($user)->reverse(),
            'isCurrentUserPage' => (Auth::id() === $user->id),
        ]);
    }

    public function indexByFollow()
    {
        return view('advert.index', [
            'title' => "Annonces que vous suivez",
            'adverts' => $this->advertFollowRepository->getFollowedByUser(Auth::user())->reverse(),
            'isCurrentUserPage' => false,
        ]);
    }

    public function indexTrashed()
    {
        return view('advert.restore', [
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
     * Search a resource in storage from given string.
     *
     * @param  string $string
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request, $string = null)
    {
        if ($string === null)
            $string = $request->input('search');

        $category = $request->input('category');

        return view('advert.search', [
            'adverts' => $this->advertRepository->search($string, $category),
            'stringSearched' => $string,
            'categorySearched' => $category,
        ]);
    }

    /**
     * Search a resource in storage from given string.
     *
     * @param  string $string
     * @return \Illuminate\Http\Response
     */
    public function searchByCategory($category, $string)
    {
        return view('advert.search', [
            'adverts' => $this->advertRepository->search($string, $category),
            'stringSearched' => $string,
            'categorySearched' => $category,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Advert  $advert
     * @return \Illuminate\Http\Response
     */
    public function show(Advert $advert)
    {
//        return Response::json($advert->pictures);

        if ($advert->user->id === Auth::id())
            $messages = $advert->messages;
        else
            $messages = $this->messageRepository->getByAdvertAndUser($advert, Auth::id());

        $messages = $advert->messages; // !!!

        return view('advert.show', [
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
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function follow(Request $request, Advert $advert)
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
     * Restore the specified resource from storage.
     *
     * @param int $advert
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(int $advert)
    {
        $advert = $this->advertRepository->findTrashed($advert);

        $this->authorize('restore', $advert);

        $this->advertRepository->restore($advert);

        return Redirect::back();
    }
}
