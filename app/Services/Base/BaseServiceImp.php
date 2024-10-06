<?php

namespace App\Services\Base;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Throwable;
use Illuminate\Support\Arr;

abstract class BaseServiceImp implements BaseServiceInterface
{
    protected $repository;

    /**
     * @inheritDoc
     */
    public function searchAndFilter(?string $keyword, ?array $columnsSearch, ?array $filters, ?int $page, ?int $limit): mixed
    {
        $companyId = auth()->user()->company_id;
        try {
            return $this->repository->select()
                ->when($companyId !== null || $companyId !== '', function ($query) use ($companyId) {
                    if ($companyId) {
                        return $query->where(function ($query) use ($companyId) {
                            $query->orWhere('company_id', $companyId)
                                ->orWhereNull('company_id')
                                ->orWhere('company_id', 0);
                        });
                    } else {
                        return $query->whereNull('company_id')->orWhere('company_id', 0);
                    }
                })
                ->when($keyword, function ($query) use ($keyword, $columnsSearch) {
                    return $query->where(function ($query) use ($keyword, $columnsSearch) {
                        foreach ($columnsSearch as $column) {
                            $query->orWhere($column, 'LIKE', '%' . $keyword . '%');
                        }
                    });
                })
                ->when($filters && Arr::isAssoc($filters), function ($query) use ($filters) {
                    return $query->where(function ($query) use ($filters) {
                        foreach ($filters as $key => $value) {
                            if ($value == 'true' || $value == 'false') {
                                $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);
                            }
                            $query->where($key, $value);
                        }
                    });
                })
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->paginate($limit);
        } catch (Throwable $e) {
            logger()->error("{$e->getMessage()} {$e->getTraceAsString()}");
            return false;
        }
    }

    /**
     *
     * @param string $select
     *
     * @return Builder | boolean
     */
    public function select(string $select = '*')
    {
        try {
            return $this->repository->select($select);
        } catch (Throwable $e) {
            logger()->error("{$e->getMessage()} {$e->getTraceAsString()}");

            return false;
        }
    }

    /**
     *
     * @param array $maps
     * @param array $attributes
     *
     * @return mixed
     */
    public function firstOrCreate(array $maps, array $attributes = [])
    {
        try {
            return $this->repository->firstOrCreate($maps, $attributes);
        } catch (Throwable $e) {
            logger()->error("{$e->getMessage()} {$e->getTraceAsString()}");

            return false;
        }
    }

    /**
     * @return Collection | boolean
     */
    public function getAll()
    {
        try {
            return $this->repository->getAll();
        } catch (Throwable $e) {
            logger()->error("{$e->getMessage()} {$e->getTraceAsString()}");

            return false;
        }
    }

    /**
     * @param array $maps
     * @param array $attributes
     *
     * @return mixed
     */
    public function updateOrCreate(array $maps, array $attributes)
    {
        try {
            return $this->repository->updateOrCreate($maps, $attributes);
        } catch (Throwable $e) {
            logger()->error("{$e->getMessage()} {$e->getTraceAsString()}");

            return false;
        }
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function find(int $id)
    {
        try {
            return $this->repository->find($id);
        } catch (Throwable $e) {
            logger()->error("{$e->getMessage()} {$e->getTraceAsString()}");

            return false;
        }
    }

    public function first()
    {
        try {
            return $this->repository->first();
        } catch (Throwable $e) {
            logger()->error("{$e->getMessage()} {$e->getTraceAsString()}");

            return false;
        }
    }

    /**
     * @param $condition
     *
     * @return Builder|false
     */
    public function findByCondition($condition)
    {
        try {
            return $this->repository->findByCondition($condition);
        } catch (Throwable $e) {
            logger()->error("{$e->getMessage()} {$e->getTraceAsString()}");
            return false;
        }
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function findOrFail(int $id)
    {
        try {
            return $this->repository->findOrFail($id);
        } catch (Throwable $e) {
            logger()->error("{$e->getMessage()} {$e->getTraceAsString()}");
            return false;
        }
    }

    /**
     * @param array $attributes
     *
     * @return false|Model
     */
    public function create(array $attributes)
    {
        try {
            return $this->repository->create($attributes);
        } catch (Throwable $e) {
            logger()->error("{$e->getMessage()} {$e->getTraceAsString()}");
            return false;
        }
    }

    /**
     * @param array $attributes
     * @return array|Collection
     */
    public function createMany(array $attributes)
    {
        try {
            $instances = collect();
            foreach ($attributes as $attribute) {
                $data = $this->repository->create($attribute);
                $instances->push($data);
            }

            return $instances;
        } catch (Throwable $e) {
            logger()->error("{$e->getMessage()} {$e->getTraceAsString()}");
            return [];
        }
    }

    /**
     * @param array $attributes
     *
     * @return bool
     */
    public function insert(array $attributes): bool
    {
        try {
            return $this->repository->insert($attributes);
        } catch (Throwable $e) {
            logger()->error("{$e->getMessage()} {$e->getTraceAsString()}");
            return false;
        }
    }

    /**
     * @param array $attributes
     *
     * @return int
     */
    public function insertGetId(array $attributes): int
    {
        try {
            return $this->repository->insertGetId($attributes);
        } catch (Throwable $e) {
            logger()->error("{$e->getMessage()} {$e->getTraceAsString()}");
            return false;
        }
    }

    /**
     * @param array $ids
     * @param array $attributes
     *
     * @return int
     */
    public function updateInIds(array $ids, array $attributes): int
    {
        try {
            return $this->repository->updateInIds($ids, $attributes);
        } catch (Throwable $e) {
            logger()->error("{$e->getMessage()} {$e->getTraceAsString()}");
            return false;
        }
    }

    /**
     *
     * @param array $ids
     *
     * @return int
     */
    public function deleteInIds(array $ids): int
    {
        try {
            return $this->repository->deleteInIds($ids);
        } catch (Throwable $e) {
            logger()->error("{$e->getMessage()} {$e->getTraceAsString()}");
            return false;
        }
    }

    /**
     * @param int $id
     * @param array $attributes
     *
     * @return mixed
     */
    public function update(int $id, array $attributes)
    {
        try {
            return $this->repository->update($id, $attributes);
        } catch (Throwable $e) {
            logger()->error("{$e->getMessage()} {$e->getTraceAsString()}");
            return false;
        }
    }

    /**
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id): bool
    {
        try {
            return $this->repository->delete($id);
        } catch (Throwable $e) {
            logger()->error("{$e->getMessage()} {$e->getTraceAsString()}");
            return false;
        }
    }

    /**
     * Retrieve all data of repository, simple paginated
     *
     * @param int|null $limit
     * @param array $columns
     *
     * @return mixed
     */
    public function simplePaginate(int $limit = null, array $columns = ['*'])
    {
        try {
            return $this->paginate($limit, $columns, 'simplePaginate');
        } catch (Throwable $e) {
            logger()->error("{$e->getMessage()} {$e->getTraceAsString()}");
            return false;
        }
    }

    /**
     * @param int|null $limit
     * @param array $columns
     * @param string $method
     *
     * @return mixed
     */
    public function paginate(int $limit = null, array $columns = ['*'], string $method = 'paginate')
    {
        try {
            return $this->repository->paginate($limit, $columns, $method);
        } catch (Throwable $e) {
            logger()->error("{$e->getMessage()} {$e->getTraceAsString()}");
            return false;
        }
    }

    /**
     * @param string|null $keywordSearch
     * @param array|null $columnsSearch
     * @return mixed
     */
    public function searchByColumn(?string $keywordSearch, ?array $columnsSearch): mixed
    {
        $companyId = auth()->user()->company_id;

        return $this->select()
            ->when($keywordSearch, function ($query) use ($keywordSearch, $columnsSearch) {
                return $query->where(function ($query) use ($keywordSearch, $columnsSearch) {
                    foreach ($columnsSearch as $column) {
                        $query->orWhere($column, 'LIKE', '%' . $keywordSearch . '%');
                    }
                });
            })
            ->when($companyId !== null || $companyId !== '', function ($query) use ($companyId) {
                if ($companyId) {
                    return $query->where(function ($query) use ($companyId) {
                        $query->orWhere('company_id', $companyId)
                            ->orWhereNull('company_id')
                            ->orWhere('company_id', 0);
                    });
                } else {
                    return $query->whereNull('company_id')->orWhere('company_id', 0);
                }
            })
            ->where('status', true)
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->get();
    }
}
