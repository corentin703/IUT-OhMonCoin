<?php


namespace App\Repositories;


use App\Picture;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PictureRepository extends Repository
{
    public function __construct(Picture $model)
    {
        parent::__construct($model);
    }

    public function create(array $datas): ?array
    {
        DB::beginTransaction();

        $pictures = [];

        foreach ($datas['pictures'] as $picture)
        {
            $data = [
                'advert' => $datas['advert'],
                'link' => $picture->storeAs('picture', $this->getLastId() . $picture->getExtension(), 'public'),
            ];

            $pictures[] = $this->model->create($data);
        }

        DB::commit();

        return $pictures;
    }

    private function getLastId() : int
    {
        $id = DB::table('pictures')->orderBy('id', 'desc')->get('id')->first();

        if ($id == null)
            return 1;

        return $id->id;
    }
}
