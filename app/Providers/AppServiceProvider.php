<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\Interfaces\UserServiceInterface;
use App\Services\Interfaces\CountryServiceInterface;
use App\Services\Interfaces\CompanyServiceInterface;
use App\Services\Interfaces\DepartmentServiceInterface;
use App\Services\Interfaces\PersonServiceInterface;
use App\Services\Interfaces\RoleServiceInterface;
use App\Services\Interfaces\ProjectServiceInterface;
use App\Services\Interfaces\TaskServiceInterface;

use App\Services\CountryService;
use App\Services\UserService;
use App\Services\CompanyService;
use App\Services\DepartmentService;
use App\Services\PersonService;
use App\Services\RoleService;
use App\Services\ProjectService;
use App\Services\TaskService;

use App\Repositories\Interfaces\CountryRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use App\Repositories\Interfaces\PersonRepositoryInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use App\Repositories\Interfaces\TaskRepositoryInterface;

use App\Repositories\UserRepository;
use App\Repositories\CountryRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\PersonRepository;
use App\Repositories\RoleRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\TaskRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // foreach 
        // ([
        //     App\Services\Interfaces\CountryServiceInterface::class => App\Services\CountryService::class,
        //     App\Repositories\Interfaces\CountryRepositoryInterface::class => App\Repositories\CountryRepository::class,
        //     App\Services\Interfaces\CompanyServiceInterface::class => App\Services\CompanyService::class,
        //     App\Repositories\Interfaces\CompanyRepositoryInterface::class => App\Repositories\CompanyRepository::class,
        //     App\Services\Interfaces\DepartmentServiceInterface::class => App\Services\DepartmentService::class,
        //     App\Repositories\Interfaces\DepartmentRepositoryInterface::class => App\Repositories\DepartmentRepository::class,
        //     App\Services\Interfaces\PersonServiceInterface::class => App\Services\PersonService::class,
        //     App\Repositories\Interfaces\PersonRepositoryInterface::class => App\Repositories\PersonRepository::class,
        //     App\Services\Interfaces\RoleServiceInterface::class => App\Services\RoleService::class,
        //     App\Repositories\Interfaces\RoleRepositoryInterface::class => App\Repositories\RoleRepository::class,
        //     App\Services\Interfaces\UserServiceInterface::class => App\Services\UserService::class,
        //     App\Repositories\Interfaces\UserRepositoryInterface::class => App\Repositories\UserRepository::class,
        //     App\Services\Interfaces\ProjectServiceInterface::class => App\Services\ProjectService::class,
        //     App\Repositories\Interfaces\ProjectRepositoryInterface::class => App\Repositories\ProjectRepository::class,
        //     App\Services\Interfaces\TaskServiceInterface::class => App\Services\TaskService::class,
        //     App\Repositories\Interfaces\TaskRepositoryInterface::class => App\Repositories\TaskRepository::class
        // ] 
        // as $interface => $class)
        // {
        //     $this->app->bind($interface, $class);
        // }

        foreach 
        ([
            CountryServiceInterface::class       => CountryService::class,
            CountryRepositoryInterface::class    => CountryRepository::class,
            CompanyServiceInterface::class       => CompanyService::class,
            CompanyRepositoryInterface::class    => CompanyRepository::class,
            DepartmentServiceInterface::class    => DepartmentService::class,
            DepartmentRepositoryInterface::class => DepartmentRepository::class,
            PersonServiceInterface::class        => PersonService::class,
            PersonRepositoryInterface::class     => PersonRepository::class,
            RoleServiceInterface::class          => RoleService::class,
            RoleRepositoryInterface::class       => RoleRepository::class,
            UserServiceInterface::class          => UserService::class,
            UserRepositoryInterface::class       => UserRepository::class,
            ProjectServiceInterface::class       => ProjectService::class,
            ProjectRepositoryInterface::class    => ProjectRepository::class,
            TaskServiceInterface::class          => TaskService::class,
            TaskRepositoryInterface::class       => TaskRepository::class
        ] 
        as $interface => $class)
        {
            $this->app->singleton($interface, $class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
