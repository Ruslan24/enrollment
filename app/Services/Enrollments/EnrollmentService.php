<?php

namespace App\Services\Enrollments;

use App\Models\Enrollment;
use App\Services\BaseService;
use App\Services\Enrollments\Contracts\EnrollmentRepositoryInterface;
use App\Services\Enrollments\Contracts\EnrollmentServiceInterface;
use Exception;
use Illuminate\Database\DatabaseManager;
use Illuminate\Log\Logger;
use Throwable;

class EnrollmentService extends BaseService implements EnrollmentServiceInterface
{
    /**
     * @param DatabaseManager $databaseManager
     * @param EnrollmentRepositoryInterface $enrollmentRepository
     * @param Logger $logger
     */
    public function __construct(
        DatabaseManager      $databaseManager,
        Logger               $logger,
        EnrollmentRepositoryInterface $enrollmentRepository
    )
    {
        parent::__construct($databaseManager, $logger, $enrollmentRepository);
    }

    /**
     * Search enrollments by filters
     *
     * @param $filters
     * @param $sortBy
     * @param $sortOrder
     * @return mixed
     */
    public function search($filters = [], $sortBy = 'status', $sortOrder = 'asc'): mixed
    {
        $query = Enrollment::select([
            'enrollments.id as id',
            'enrollments.status as status',
            'enrollments.created_at as created_at',
            'enrollments.updated_at as updated_at',
            'courses.title as courseTitle',
            'courses.id as courseId',
            'users.id as userId',
            'users.name as userName',
        ]);
        $query->join('courses', 'enrollments.course_id', '=', 'courses.id');
        $query->join('users', 'enrollments.user_id', '=', 'users.id');
        if (!empty($filters['course_name'])) {
            $query->whereHas('course', function ($query) use ($filters) {
                $query->where('title', 'LIKE', '%' . $filters['course_name'] . '%');
            });
        }

        if (!empty($filters['user_name'])) {
            $query->whereHas('user', function ($query) use ($filters) {
                $query->where('name', 'LIKE', '%' . $filters['user_name'] . '%')
                    ->orWhere('email', 'LIKE', '%' . $filters['user_name'] . '%');
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if ($sortBy == 'course_title') {
            $query->orderBy('courseTitle', $sortOrder);
        } else {
            $query->orderBy($sortBy ?? 'status', $sortOrder);
        }

        return $query->paginate(20);
    }

    /**
     * Create enrollment.
     *
     * @param array $data
     * @return bool
     * @throws Exception|Throwable
     */
    public function store(array $data): bool
    {
        try {
            $result = $this->repository->updateOrCreate($data);
        } catch (Exception $e) {
            $this->logger->error('Enrollment was not created.' . $e->getMessage());

            return $this->rollback($e, 'An error occurred while storing an Enrollment.');
        }

        return !!$result;
    }

    /**
     * Update enrollment.
     *
     * @param int $id
     * @param array $data
     * @return bool
     * @throws Throwable
     */
    public function update(int $id, array $data): bool
    {
        try {
            $result = $this->repository->update($data, $id);
        } catch (Exception $e) {
            $this->logger->error('Enrollment was not created.' . $e->getMessage());

            return $this->rollback($e, 'An error occurred while storing an Enrollment.');
        }

        return !!$result;
    }
}
