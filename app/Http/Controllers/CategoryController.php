<?php

namespace App\Http\Controllers;

use App\Advert;
use App\Category;
use App\Http\Requests\CategoryDeleteRequest;
use App\Http\Requests\CategoryEditRequest;
use App\Repositories\AdvertFollowRepository;
use App\Repositories\AdvertRepository;
use App\Repositories\CategoryRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{
    private $advertRepository;
    private $advertFollowRepository;
    private $categoryRepository;

    public function __construct(AdvertRepository $advertRepository, AdvertFollowRepository $advertFollowRepository, CategoryRepository $categoryRepository)
    {
        $this->advertRepository = $advertRepository;
        $this->advertFollowRepository = $advertFollowRepository;
        $this->categoryRepository = $categoryRepository;

        $this->authorizeResource(Category::class, 'category');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('categories.index', [
            'categories' => $this->categoryRepository->all(),
        ]);
    }

    /**
     * Display a listing of the resources which have been trashed.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexTrashed()
    {
        $this->authorize('viewTrashed', Category::class);

        return view('categories.restore', [
            'categories' => $this->categoryRepository->getTrashed(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryEditRequest $request)
    {
        $this->categoryRepository->create($request->all());

        return Redirect::back();
    }

    /**
     * Display a listing of Adverts by Category.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Request $request, Category $category)
    {
        $this->authorize('view-any', Advert::class);

        $string = $request->input('string');
        $followed = ($request->input('followed') == "true");
        $user = $request->input('user');

        if ($string != null || $followed != null || $user != null)
        {
            $adverts = $this->advertRepository->search([
                'currentCategory' => $category->id,
                'string' => $string,
                'followed' => $followed,
                'user' => $user,
            ]);
        }
        else
            $adverts = $category->adverts->reverse();

        return view('adverts.index', [
            'title' => "Annonces de catégorie " . $category->name,
            'adverts' => $adverts,
            'stringSearched' => $string,
            'categorySearched' => $category,
            'isCurrentUserPage' => false,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Category $category)
    {
        return view('categories.edit', [
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CategoryEditRequest $request, Category $category)
    {
        $this->categoryRepository->update($request->all(), $category);

        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(CategoryDeleteRequest $request, Category $category)
    {
        $this->categoryRepository->delete($category);

        return Redirect::route('categories.index');
    }

    public function restore($category)
    {
        $this->authorize('restore', Category::class);

        $category = $this->categoryRepository->findTrashed($category);

        $this->categoryRepository->restore($category);

        return Redirect::route('categories.show', $category->id);
    }
}
