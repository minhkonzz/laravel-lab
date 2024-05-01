<?php 

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Crudable;
use App\Repositories\Interfaces\BaseRepositoryInterface;
use App\Exceptions\RepositoryException;

abstract class BaseRepository implements BaseRepositoryInterface
{
    use Crudable;

    protected $model;

    function __construct (Model $model) 
    {
        $this->model = $model;
    }

    public function resolveModel($keyOrModel): Model
    {
        if ($keyOrModel instanceof Model)
        {
            if ($keyOrModel::class !== $this->getModelClass()) 
            {
                throw new RepositoryException('Model class is not match repository model class');
            }   
            return $keyOrModel;
        }
        return $this->model->find($keyOrModel);
    }


    /**
     * Get model class
     *
     * @return string
    **/
    public function getModelClass(): string
    {
        return $this->model::class;
    }

    // protected $model;

    // function __construct(Model $model)
    // {
    //     $this->model = $model;
    // }

    // public function getAll(): Collection
    // {
    //     return $this->model->all();
    // }

    // public function getById(int $id): ?Model
    // {
    //     return $this->model->find($id);
    // }

    // public function create(array $data): ?Model
    // {
    //     return $this->model->create($data);
    // }

    // public function update(array $data, Model $model): ?Model
    // {
    //     $model->update($data);
    //     return $model;
    // }

    // public function delete(Model $model): bool
    // {
    //     return $model->delete();
    // }   
}