<?php 

namespace App\Services;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use App\Services\Interfaces\ProjectServiceInterface;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use App\Models\Project;

class ProjectService extends BaseService implements ProjectServiceInterface
{
    function __construct () 
    {
        parent::__construct();
    }

    public function storeProject(array $requestData): Project
    {
        $validator = Validator::make($requestData, [
            'code'        => 'required|string|max:255|unique:projects',
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'company'     => 'required|string'
        ]);

        if ($validator->fails())
        {
            throw new ValidationException($validator);
        }

        $validated = $validator->validated();
        $company_id = intval(base64_decode($requestData['company']));

        if ($company_id)
        {
            $validated['company_id'] = $company_id;
        }

        $validated['person_ids'] = $requestData['person_ids'];
        return $this->repository->createProject($validated);
    }

    public function updateProject(Project $project, array $requestData): Project
    {
        $validator = Validator::make($requestData, [
            'code'        => 'required|string|max:255',
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'company'     => 'required|string'
        ]);

        if ($validator->fails())
        {
            throw new ValidationException($validator);
        }

        $validated = $validator->validated();
        $company_id = intval(base64_decode($requestData['company_id']));

        if ($company_id)
        {
            $validated['company_id'] = $company_id;
        }

        $validated['person_ids'] = $requestData['person_ids'];
        return $this->repository->updateProject($project, $validated);
    }

    protected function getRepositoryClass(): string
    {
        return ProjectRepositoryInterface::class;
    }
}