<?php 

namespace App\Repositories\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    /**
     * Get filtered collection
     *
     * @param array $search
     * @return Collection
    **/
    public function getAll(array $filterCondictions = []): Collection;

    /**
     * Get paginated data
     *
     * @param  int $countPerPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
    **/
    public function getAllPaginated(int $countPerPage = 2): LengthAwarePaginator;

    /**
     * Create model with data
     *
     * @param array $data
     * @return Model|null
    **/
    public function create(array $data): ?Model;

    /**
     * Update model with data
     *
     * @param Model|mixin $keyOrModel
     * @param array $data
     * @return Model|null
    **/
    public function update($keyOrModel, array $data): ?Model;

    /**
     * Delete model
     *
     * @param Model|mixin $keyOrModel
     * @return bool
    **/
    public function delete($keyOrModel): bool;
}