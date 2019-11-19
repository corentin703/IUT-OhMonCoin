<?php

namespace App\Http\Controllers;

use App\Repositories\AdvertRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $advertRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AdvertRepository $advertRepository)
    {
//        $this->middleware('auth');
        $this->advertRepository = $advertRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('welcome', [
            'adverts' => $this->advertRepository->all(),
        ]);
    }
}
