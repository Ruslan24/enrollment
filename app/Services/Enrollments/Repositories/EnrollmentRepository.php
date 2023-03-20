<?php

namespace App\Services\Enrollments\Repositories;

use App\Models\Enrollment;
use App\Repositories\Repository;
use App\Services\Enrollments\Contracts\EnrollmentRepositoryInterface;

class EnrollmentRepository extends Repository implements EnrollmentRepositoryInterface
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Enrollment::class;
    }
}
