<?php

namespace App\Http\Controllers;

use App\Advert;
use App\Repositories\AdvertRepository;
use App\Repositories\MessageRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class MessageController extends Controller
{
    private $advertRepository;
    private $messageRepository;
    private $userRepository;

    public function __construct(AdvertRepository $advertRepository, MessageRepository $messageRepository, UserRepository $userRepository)
    {
        $this->advertRepository = $advertRepository;
        $this->messageRepository = $messageRepository;
        $this->userRepository = $userRepository;
    }

    public function create(Request $request, Advert $advert)
    {
        $data = [
            'advert' => $advert,
            'receiver' => $this->userRepository->find($request->input('receiver')),
            'sender' => Auth::user(),
            'content' => $request->input('content')
        ];

        $this->messageRepository->create($data);

        return Redirect::back();
    }
}
