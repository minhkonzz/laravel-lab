<?php 

namespace App\Traits;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Database\Eloquent\Model;

trait Crudable
{
    public function getAll(array $filterConditions = []): Collection
    {
        return $this->model->all();
    }

    /**
     * Get paginated data
     *
     * @param  int $countPerPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
    **/
    public function getAllPaginated(int $countPerPage = 2): LengthAwarePaginator
    {
        return $this->model->paginate($countPerPage);
    }

    public function getPaginated(SupportCollection $collection, string $path, array $query, int $perPage = 2): LengthAwarePaginator
    {
        $currentPage = request('page', 1);
        $totalItems = $collection->count();
        $start = ($currentPage * $perPage) - $perPage;
        $itemsForCurrentPage = $collection->slice($start, $perPage);
        
        $paginator = new LengthAwarePaginator(
            $itemsForCurrentPage,
            $totalItems,
            $perPage,
            $currentPage,
            ['path' => $path, 'query' => $query]
        );

        return $paginator;
    }

    /**
     * Create model with data
     *
     * @param array $data
     * @return Model|null
    **/
    public function create(array $data): ?Model
    {
        return $this->model->create($data);
    }

    /**
     * Update model with data

     * @param Model|mixin $keyOrModel
     * @param array $data
     * @return Model|null
    **/
    public function update($keyOrModel, array $data): ?Model
    {
        $model = $this->resolveModel($keyOrModel);
        return $model->update($data) ? $model : null; 
    }

    public function updateOrCreate(array $data): ?Model
    {
        return $this->model->updateOrCreate($data);
    }

    /**
     * Delete model
     * 
     * @param Model|mixin $keyOrModel
     * @return bool
    **/
    public function delete($keyOrModel): bool
    {
        $model = $this->resolveModel($keyOrModel);
        return $model->delete();
    }

    protected function getQuery(): Builder
    {
        return $this->model->query();
    }
}