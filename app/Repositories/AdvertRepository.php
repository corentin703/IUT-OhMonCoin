<?php


namespace App\Repositories;


use App\Advert;
use App\Http\Traits\UploadTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class AdvertRepository extends Repository
{
    use UploadTrait;

    public function __construct(Advert $model)
    {
        parent::__construct($model);
    }

    public function create(array $data): ?Model
    {
        $validation = Validator::make($data, [
            'title' => ['required', 'min:8'],
            'content' => ['required', 'min:20'],
//            'pictures' => ['array'];
            'pictures.*' => ['image', 'mimes:jpeg,bmp,png', 'size:5000'],
        ])->validate();

        dump($data);
        dump($validation);
        dd("OK");

        return $this->model->create($data);
    }
}
