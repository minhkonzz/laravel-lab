<?php 

namespace App\Repositories;

use App\Models\Project;

class ProjectRepository extends BaseRepository
{
    function __construct (Project $project)
    {
        parent::__construct($project);
    }
}