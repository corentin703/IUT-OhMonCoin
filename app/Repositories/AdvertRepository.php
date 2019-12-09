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
    private $userRepository;

    public function __construct(Advert $model, CategoryRepository $categoryRepository, PictureRepository $pictureRepository, UserRepository $userRepository)
    {
        parent::__construct($model);
        $this->categoryRepository = $categoryRepository;
        $this->pictureRepository = $pictureRepository;
        $this->userRepository = $userRepository;
    }

    public function search($data = [])
    {
//        dd($data);

        if (isset($data['followed']) && $data['followed'] === true && !isset($data['user']))
            $adverts = Auth::user()->followed();
        else
            $adverts = $this->model::query();

        if (isset($data['string']))
        {
            $adverts = $adverts->where('title', 'LIKE', '%' . $data['string'] . '%');
        }

        if (isset($data['category']))
        {
            if (is_numeric($data['category']))
                $category = $this->categoryRepository->find($data['category']);
            else
            {
                $category = $this->categoryRepository->getCategoryByName($data['category']);

                if ($category === null)
                    return [];

                $category = $category->first();
            }

            $adverts = $adverts->where('category_id', $category->id);
        }

        if (isset($data['user']))
        {
            if (is_numeric($data['user']))
                $user = $this->userRepository->find($data['user']);
            else
            {
                $user = $this->userRepository->getUserByName($data['user']);

                if ($user === null)
                    return [];

                $user = $user->first();
            }

            $adverts = $adverts->where('user_id', $user->id);
        }

        $adverts = $adverts->get();

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
