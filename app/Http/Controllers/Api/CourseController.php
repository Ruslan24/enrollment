<?php

namespace App\Http\Controllers\Api;

use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * List enrollments.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        $courseName = trim($request->input('course_name'));
        $courses = Course::where('title', 'LIKE', '%' . $courseName . '%')->get();

        return response()->json($courses);
    }
}
