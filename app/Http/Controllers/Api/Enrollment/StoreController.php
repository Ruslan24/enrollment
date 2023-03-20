<?php

namespace App\Http\Controllers\Api\Enrollment;

use App\Http\Controllers\Api\Controller;
use App\Services\Enrollments\Contracts\EnrollmentServiceInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class StoreController extends Controller
{
    /**
     * Create enrollment.
     *
     * @param Request $request
     * @param EnrollmentServiceInterface $enrollmentService
     * @return JsonResponse
     * @throws Exception|Throwable
     */
    public function __invoke(Request $request, EnrollmentServiceInterface $enrollmentService)
    {
        $content = json_decode($request->getContent());

        $data = [
            'course_id' => (int)$content->course_id,
            'user_id' => (int)$content->user_id,
            'status' => (int)$content->status,
            'created_at' => Carbon::now(),
        ];

        $status = $enrollmentService->store($data);

        return response()->json($status);
    }
}
