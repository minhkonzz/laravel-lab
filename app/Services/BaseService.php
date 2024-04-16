<?php 

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class BaseService
{
    protected $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    public function getAll(): Collection
    {
        return $this->repository->getAll();
    }

    public function getById(string $id): ?Model
    {
        return $this->repository->getById($id);
    }

    public function create(array $data): Model
    {
        return $this->repository->create($data);
    }

    public function update(array $data, string $id): bool
    {
        return $this->repository->update($data, $id);
    }

    public function delete(string $id): bool
    {
        return $this->repository->delete($id);
    }
}