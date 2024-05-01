<?php 

namespace App\Services\Interfaces;

use App\Models\Project;

interface ProjectServiceInterface
{
    public function storeProject(array $requestData): Project;
    public function updateProject(Project $project, array $requestData): Project;
}