<?php

namespace App\Providers;

use App\Services\Enrollments\Contracts\EnrollmentServiceInterface;
use App\Services\Enrollments\Contracts\EnrollmentRepositoryInterface;
use App\Services\Enrollments\EnrollmentService;
use App\Services\Enrollments\Repositories\EnrollmentRepository;
use Illuminate\Support\ServiceProvider;

class EnrollmentServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind( EnrollmentServiceInterface::class, EnrollmentService::class,);
        $this->app->bind( EnrollmentRepositoryInterface::class, EnrollmentRepository::class,);
    }

}
