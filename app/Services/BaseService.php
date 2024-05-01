<?php 

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Services\Interfaces\BaseServiceInterface;

abstract class BaseService implements BaseServiceInterface
{
    protected $repository;

    function __construct()
    {
        $this->repository = app($this->getRepositoryClass());
    }

    public function getAll(array $filterConditions = []): Collection
    {
        return $this->repository->getAll($filterConditions);
    }

    public function getAllPaginated(int $countPerPage = 2): LengthAwarePaginator
    {
        return $this->repository->getAllPaginated($countPerPage);
    }

    public function store(array $data): ?Model
    {
        return $this->repository->create($data);
    }

    public function update($keyOrModel, array $data): ?Model
    {
        return $this->repository->update($keyOrModel, $data);
    }

    public function delete($keyOrModel): bool
    {
        return $this->repository->delete($keyOrModel);
    }

    abstract protected function getRepositoryClass(): string;

    // function __construct($repository)
    // {
    //     $this->repository = $repository;
    // }

    // public function getAll(): Collection
    // {
    //     return $this->repository->getAll();
    // }

    // public function getById(int $id): ?Model
    // {
    //     return $this->repository->getById($id);
    // }

    // public function create(array $data): ?Model
    // {
    //     return $this->repository->create($data);
    // }

    // public function update(array $data, Model $model): ?Model
    // {
    //     return $this->repository->update($data, $model);
    // }

    // public function delete(Model $model): bool
    // {
    //     return $this->repository->delete($model);
    // }
}