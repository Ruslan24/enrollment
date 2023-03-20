<?php

namespace App\Services\Enrollments\Contracts;

use App\Models\Enrollment;

/**
 * Interface FaqService
 * @package App\Services\Faq\Contracts
 */
interface EnrollmentServiceInterface
{
    /**
     * Store faq data.
     *
     * @param array $data
     * @return Enrollment|bool
     */
    public function store(array $data): Enrollment|bool;

    /**
     * Update faq data.
     *
     * @param int $id
     * @param array $data
     * @return Enrollment|bool
     */
    public function update(int $id, array $data): Enrollment|bool;
}
