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

    public function search($string, $category = null)
    {
        if ($category == 0 || $category === null)
            $adverts = $this->model::where('title', 'LIKE', '%' . $string . '%')->get();
        else
        {
            $category = $this->categoryRepository->find($category);
            $adverts = $this->model::where('title', 'LIKE', '%' . $string . '%')->where('category_id', $category->id)->get();
        }

        if (count($adverts) == 0)
            return null;

        return $adverts;
    }

    public function create(array $data): ?Model
    {
        $validation = Validator::make($data, [
            'title' => ['required', 'min:8'],
            'category' => ['required', 'exists:categories,id'],
            'content' => ['required', 'min:20'],
            'pictures.*' => ['image', 'mimes:jpeg,bmp,png', 'max:5000'],
        ])->validate();

        DB::beginTransaction();

        $validation['date'] = Carbon::today();
        $validation['user'] = Auth::user();
        $validation['category'] = $this->categoryRepository->find($validation['category']);

        $advert = $this->model->create($validation);

        if (isset($validation['pictures']))
        {
            $this->pictureRepository->create([
                'advert' => $advert,
                'pictures' => $validation['pictures'],
            ], true);
        }

        DB::commit();

        return $advert;
    }

    public function update(array $data, $advert): ?Model
    {
        $validation = Validator::make($data, [
            'title' => ['required', 'min:8'],
            'category' => ['required', 'exists:categories,id'],
            'content' => ['required', 'min:20'],
            'pictures.*' => ['image', 'mimes:jpeg,bmp,png', 'max:5000'],
        ])->validate();

        $validation['date'] = Carbon::today();
        $validation['user'] = Auth::user();
        $validation['category'] = $this->categoryRepository->find($validation['category']);

        $advert->update($validation);

        return $advert;
    }

    public function getByUser(User $user)
    {
        return $this->model->all()->where('user', $user);
    }

    public function getByCategory(Category $category)
    {
        return $this->model->all()->where('category', $category);
    }

    public function getTrashedByUser(User $user)
    {
        return $this->model->onlyTrashed()->where('user_id', $user->id)->get();
    }
}
