<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * List enrollments.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        $userName = trim($request->input('user_name'));
        $courses = User::where('name', 'LIKE', '%' . $userName . '%')->get();

        return response()->json($courses);
    }
}
