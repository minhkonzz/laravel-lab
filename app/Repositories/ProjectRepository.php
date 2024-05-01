<?php 

namespace App\Repositories;

use App\Repositories\Interfaces\ProjectRepositoryInterface;
use App\Models\Project;

class ProjectRepository extends BaseRepository implements ProjectRepositoryInterface
{
    function __construct (Project $project)
    {
        parent::__construct($project);
    }

    public function createProject(array $data): Project
    {
        $project = $this->model->make([
            'code'         =>  strip_tags($data['code']),
            'name'         =>  strip_tags($data['name']),
            'description'  =>  strip_tags($data['description'])
        ]);
        
        if (isset($data['company_id']) && !empty($data['company_id']))
        {
            $project->company()->associate($data['company_id']);
        }

        $personIds = $data['person_ids'];
        $project->save();
        $project->persons()->sync($personIds);

        return $project;
    }

    public function updateProject(Project $project, array $data): Project
    {
        $project->update([
            'code'        => strip_tags($data['code']),
            'name'        => strip_tags($data['name']),
            'description' => strip_tags($data['description'])
        ]);
        
        if (isset($data['company_id']) && !empty($data['company_id']))
        {
            $project->company()->associate($data['company_id']);
        }

        $personIds = $data['person_ids'];
        $project->persons()->sync($personIds);
        $project->save();

        return $project;
    }
}