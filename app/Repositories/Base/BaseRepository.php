<?php

namespace App\Repositories\Base;

//use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Collection;
//use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\Builder;

abstract class BaseRepository implements RepositoryInterface
{
    protected mixed $_model;

    /**
     * RepositoryEloquent constructor.
     *
     */
    public function __construct()
    {
        $this->setModel();
    }

    /**
     * @return mixed
     */
    abstract public function getModel(): mixed;

    /**
     */
    public function setModel()
    {
//        $this->_model = app()->make($this->getModel());
        $model = $this->getModel();
        $this->_model = new $model;
    }

    /**
     * @param string|array $select
     * @return mixed
     */
    public function select(string|array $select = '*'): mixed
    {
        return $this->_model::select($select);
    }

    /**
     * @param  array  $maps
     * @param  array  $attributes
     *
     * @return mixed
     */
    public function firstOrCreate(array $maps, array $attributes): mixed
    {
        return $this->_model::firstOrCreate($maps, $attributes);
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->_model::all();
    }

    /**
     * @param  array  $maps
     * @param  array  $attributes
     *
     * @return mixed
     */
    public function updateOrCreate(array $maps, array $attributes): mixed
    {
        return $this->_model::updateOrCreate($maps, $attributes);
    }

    /**
     * @param $condition
     *
     * @return mixed
     */
    public function findByCondition($condition): mixed
    {
        return $this->_model::where($condition)->first();
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function findOrFail(int $id): mixed
    {
        return $this->_model::findOrFail($id);
    }

    /**
     * @param  array $attributes
     */
    public function create(array $attributes): mixed
    {
        return $this->_model::create($attributes);
    }

    /**
     * @param  array  $attributes
     *
     * @return bool
     */
    public function insert(array $attributes): bool
    {
        return $this->_model::insert($attributes);
    }

    /**
     * @param  array  $attributes
     *
     * @return int
     */
    public function insertGetId(array $attributes): int
    {
        return $this->_model::insertGetId($attributes);
    }

    /**
     * @param  array  $ids
     * @param  array  $attributes
     *
     * @return int
     */
    public function updateInIds(array $ids, array $attributes): int
    {
        return $this->_model::whereIn('id', $ids)->update($attributes);
    }

    /**
     * @param  array  $ids
     *
     * @return int
     */
    public function deleteInIds(array $ids): int
    {
        return $this->_model::whereIn('id', $ids)->delete();
    }

    /**
     * @param int $id
     * @param  array  $attributes
     *
     * @return mixed
     */
    public function update(int $id, array $attributes): mixed
    {
        $result = $this->find($id);
        if ($result) {
            $result->update($attributes);

            return $result;
        }

        return false;
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function find(int $id): mixed
    {
        return $this->_model::find($id);
    }

    /**
     * @return mixed
     */
    public function first(): mixed
    {
        return $this->_model::first();
    }

    /**
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id): bool
    {
        $result = $this->find($id);
        if ($result) {
            return $result->delete();
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function truncate(): mixed
    {
        return $this->_model->truncate();
    }

    /**
     * Retrieve all data of repository, simple paginated
     *
     * @param int|null $limit
     * @param array $columns
     *
     * @return mixed
     */
    public function simplePaginate(int $limit = null, array $columns = ['*']): mixed
    {
        return $this->paginate($limit, $columns, "simplePaginate");
    }

    /**
     * @param int|null $limit
     * @param array $columns
     * @param string $method
     *
     * @return mixed
     */
    public function paginate(int $limit = null, array $columns = ['*'], string $method = "paginate"): mixed
    {
        $limit = is_null($limit) ? config('repository.pagination.limit', 15) : $limit;
        $results = $this->_model::{$method}($limit, $columns);

        return $results->appends(app('request')->query());
    }

    public function selectByIds(array $ids): Collection
    {
        return $this->_model::whereIn('id', $ids)->get();
    }

    /**
     * @param $id
     * @param array $changes
     * @return mixed
     */
    public function duplicate($id, array $changes = []): mixed
    {
        $record = $this->find($id);

        $newRecord = $record->replicate($changes);

        foreach ($changes as $key => $value) {
            $newRecord->$key = $value;
        }

        $newRecord->save();

        return $newRecord;
    }
}
