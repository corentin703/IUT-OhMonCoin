<?php

namespace App\Http\Controllers;

use App\Advert;
use App\Category;
use App\Repositories\AdvertFollowRepository;
use App\Repositories\AdvertRepository;
use App\Repositories\MessageRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $advertRepository;
    private $advertFollowRepository;

    public function __construct(AdvertRepository $advertRepository, AdvertFollowRepository $advertFollowRepository)
    {
        $this->advertRepository = $advertRepository;
        $this->advertFollowRepository = $advertFollowRepository;
    }

    /**
     * Display a listing of the resource by Category.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Request $request, Category $category)
    {
        $this->authorize('view-any', Advert::class);

        $string = $request->input('search');

        if ($string)
        {
            return view('adverts.search', [
                'adverts' => $this->advertRepository->search($request->input('string'), $category),
                'stringSearched' => $string,
                'categorySearched' => $category,
            ]);
        }

        return view('adverts.index', [
            'title' => "Annonces de catégorie " . $category->name,
            'adverts' => $category->adverts->reverse(),
            'isCurrentUserPage' => false,
        ]);
    }

}
