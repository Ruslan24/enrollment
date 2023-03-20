<?php

namespace App\Http\Controllers\Api\Enrollment;

use App\Http\Controllers\Api\Controller;
use App\Services\Enrollments\Contracts\EnrollmentServiceInterface;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    /**
     * Update enrollment.
     *
     * @param Request $request
     * @param EnrollmentServiceInterface $enrollmentService
     * @return JsonResponse
     */
    public function __invoke(Request $request, EnrollmentServiceInterface $enrollmentService)
    {
        $content = json_decode($request->getContent());

        $data = [
            'course_id' => (int)$content->course_id,
            'user_id' => (int)$content->user_id,
            'status' => (int)$content->status,
            'updated_at' => Carbon::now(),
        ];

        $status = $enrollmentService->update((int)$content->id, $data);

        return response()->json($status);
    }
}
