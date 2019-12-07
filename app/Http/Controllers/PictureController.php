<?php

namespace App\Http\Controllers;

use App\Http\Requests\PictureCreateRequest;
use App\Picture;
use App\Repositories\AdvertRepository;
use App\Repositories\PictureRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

class PictureController extends Controller
{
    private $advertRepository;
    private $pictureRepository;

    public function __construct(AdvertRepository $advertRepository, PictureRepository $pictureRepository)
    {
        $this->advertRepository = $advertRepository;
        $this->pictureRepository = $pictureRepository;

//        Authorized by FormRequests
//        $this->authorizeResource(Picture::class, 'picture');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(PictureCreateRequest $request)
    {
        $advert = $this->advertRepository->find($request->input('advert'));

        $data = $request->all();

        if ($request->hasFile('pictures'))
            $data['pictures'] = $request->file('pictures');

        $data['advert'] = $advert;

        $this->pictureRepository->create($data);

        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Picture $picture
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Picture $picture)
    {
        $this->authorize('delete', $picture);

        $this->pictureRepository->delete($picture);

        return Response::json(['success' => true], 200);
    }
}
