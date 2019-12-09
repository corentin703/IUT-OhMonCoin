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

    public function create(array $data, $blockDBControl = false): ?array
    {
        $mustCommit = false;

        if (count($data['pictures']) > 1 && !$blockDBControl)
        {
            $mustCommit = true;
            DB::beginTransaction();
        }

        $pictures = [];

        foreach ($data['pictures'] as $picture)
        {
            $pictureData = [
                'advert' => $data['advert'],
                'link' => $picture->storeAs('pictures', $this->getLastId() . $picture->getExtension(), 'public'),
            ];

            $pictures[] = $this->model->create($pictureData);
        }

        if ($mustCommit)
            DB::commit();

        return $pictures;
    }

    private function getLastId() : int
    {
        $id = DB::table('pictures')->orderBy('id', 'desc')->get('id')->first();

        if ($id == null)
            return 1;

        return $id->id + 1;
    }
}
