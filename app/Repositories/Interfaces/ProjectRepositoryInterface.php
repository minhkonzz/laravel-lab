<?php 

namespace App\Repositories\Interfaces;

use App\Models\Project;

interface ProjectRepositoryInterface
{
    public function createProject(array $data): Project;
    public function updateProject(Project $project, array $data): Project;
}