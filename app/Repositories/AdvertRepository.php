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
    private $categoryRepository;
    private $pictureRepository;

    public function __construct(Advert $model, CategoryRepository $categoryRepository, PictureRepository $pictureRepository)
    {
        parent::__construct($model);
        $this->categoryRepository = $categoryRepository;
        $this->pictureRepository = $pictureRepository;
    }

    public function search($data = [])
    {
        if (!isset($data['string']))
            $data['string'] = "";

        if (isset($data['category']) && $data['category'] != 0)
        {
            $category = $this->categoryRepository->find($data['category']);
            $adverts = $this->model::where('title', 'LIKE', '%' . $data['string'] . '%')->where('category_id', $category->id)->get();
        }
        else
            $adverts = $this->model::where('title', 'LIKE', '%' . $data['string'] . '%')->get();

        if (count($adverts) == 0)
            return null;

        return $adverts;
    }

    public function create(array $data): ?Model
    {
        DB::beginTransaction();

        $data['date'] = Carbon::today();
        $data['user'] = Auth::user();
        $data['category'] = $this->categoryRepository->find($data['category']);

        $advert = $this->model->create($data);

        if (isset($data['pictures']))
        {
            $this->pictureRepository->create([
                'advert' => $advert,
                'pictures' => $data['pictures'],
            ], true);
        }

        DB::commit();

        return $advert;
    }

    public function update(array $data, $advert): ?Model
    {
        $data['date'] = Carbon::today();
        $data['user'] = Auth::user();
        $data['category'] = $this->categoryRepository->find($data['category']);

        $advert->update($data);

        return $advert;
    }

    public function getTrashedByUser(User $user)
    {
        return $this->model->onlyTrashed()->where('user_id', $user->id)->get();
    }
}
