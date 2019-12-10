<?php


namespace App\Repositories;


use App\Advert;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

abstract class Repository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function create(array $data)
    {
        // Transaction manage ensures that Observers actions are well executed in the same query that model creation
        DB::beginTransaction();

        $element = $this->model->create($data);

        DB::commit();

        return $element;
    }

    public function update(array $data, $element)
    {
        DB::beginTransaction();

        $element = $this->getModelInstance($element)->update($data);

        DB::commit();

        return $element;
    }

    public function delete($element)
    {
        DB::beginTransaction();

        $element = $this->getModelInstance($element)->delete();

        DB::commit();

        return $element;
    }

    public function forceDelete($element)
    {
        DB::beginTransaction();

        $element = $this->getModelInstance($element)->forceDelete();

        DB::commit();

        return $element;
    }

    public function restore($element)
    {
        DB::beginTransaction();

        $element = $this->getModelInstance($element)->restore();

        DB::commit();

        return $element;
    }

    public function find($element) : ?Model
    {
        return $this->getModelInstance($element);
    }

    public function findTrashed(int $element) :?Model
    {
        $element = $this->model->onlyTrashed()->where('id', $element)->get()->first();

        if (is_null($element))
            abort(404);

        return $element;
    }

    public function show($element) : ?Model
    {
        return $this->getModelInstance($element);
    }

    protected function getModelInstance($element)
    {
        if (!($element instanceof Model))
            $element = $this->model->findOrFail($element);

        return $element;
    }
}
