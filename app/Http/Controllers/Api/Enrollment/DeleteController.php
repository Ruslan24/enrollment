<?php

namespace App\Http\Controllers\Api\Enrollment;

use App\Http\Controllers\Api\Controller;
use App\Services\Enrollments\Contracts\EnrollmentServiceInterface;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    /**
     * Delete enrollment.
     *
     * @param Request $request
     * @param EnrollmentServiceInterface $enrollmentService
     * @return JsonResponse
     */
    public function __invoke(Request $request, EnrollmentServiceInterface $enrollmentService)
    {
        $data = [
            'course_id' => (int)$request->input('course_id'),
            'user_id' => (int)$request->input('user_name'),
            'status' => (int)$request->input('status'),
            'created_at' => Carbon::now(),
        ];

        $status = $enrollmentService->store($data);

        return response()->json($status);
    }
}
