<?php


namespace App\Repositories;


use App\Message;


class MessageRepository extends Repository
{
    private $advertRepository;
    private $userRepository;

    public function __construct(Message $model, AdvertRepository $advertRepository, UserRepository $userRepository)
    {
        parent::__construct($model);

        $this->advertRepository = $advertRepository;
        $this->userRepository = $userRepository;
    }

    public function getByAdvertAndUser($advert, $user)
    {
        if (gettype($advert) === "integer")
            $advert = $this->advertRepository->find($advert);

        if (gettype($user) === "integer")
            $user = $this->userRepository->find($user);

        return $this->model::where('advert_id', $advert->id)->where('sender_id', $user->id)->orWhere('receiver_id', $user->id)->orderBy('created_at')->get();
    }
}
