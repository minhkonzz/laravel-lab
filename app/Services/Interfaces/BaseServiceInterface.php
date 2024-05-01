<?php

namespace App\Services\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseServiceInterface
{
    public function getAll(array $filterConditions = []): Collection;
    public function getAllPaginated(int $countPerPage = 2): LengthAwarePaginator;
    public function store(array $data): ?Model;
    public function update($keyOrModel, array $data): ?Model;
    public function delete($keyOrModel): bool;
}