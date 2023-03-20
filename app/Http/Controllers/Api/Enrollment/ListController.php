<?php

namespace App\Http\Controllers\Api\Enrollment;

use App\Http\Controllers\Api\Controller;
use App\Services\Enrollments\Contracts\EnrollmentServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListController extends Controller
{
    /**
     * List enrollments.
     *
     * @param Request $request
     * @param EnrollmentServiceInterface $enrollmentService
     * @return JsonResponse
     */
    public function __invoke(Request $request, EnrollmentServiceInterface $enrollmentService)
    {
        $filters = [
            'course_name' => $request->input('course_name'),
            'user_name' => $request->input('user_name'),
            'status' => $request->input('status'),
        ];

        $sortBy = $request->input('sort_by');
        $sortOrder = $request->input('sort_order', 'asc');

        $enrollments = $enrollmentService->search($filters, $sortBy, $sortOrder);

        return response()->json($enrollments);
    }
}
