<?php


namespace App\Repositories;


use App\Advert;
use App\Category;
use App\Picture;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdvertRepository extends Repository
{
    public function __construct(Advert $model)
    {
        parent::__construct($model);
    }

    public function create(array $data): ?Model
    {
        $validation = Validator::make($data, [
            'title' => ['required', 'min:8'],
            'category' => ['required', 'min:8'],
            'content' => ['required', 'min:20'],
            'pictures.*' => ['image', 'mimes:jpeg,bmp,png', 'max:5000'],
        ])->validate();

        DB::beginTransaction();

        $validation['date'] = Carbon::today();
        $validation['user'] = Auth::user();
        $validation['category'] = Category::find('1');

        $advert = $this->model->create($validation);

        if (isset($validation['pictures']))
        {
            $images = $validation['pictures'];

            $id = DB::table('pictures')->orderBy('id', 'desc')->get('id')->first();

            if ($id == null)
                $id = 1;
            else
                $id = $id->id;

            foreach ($images as $image)
            {
                $image = $image->storeAs('images', $id . $image->getExtension(), 'public');

//                dd($image);

                Picture::create([
                    'link' => $image,
                    'advert' => $advert,
                ]);

                $id++;
            }
        }

        DB::commit();

        return $advert;
    }
}
