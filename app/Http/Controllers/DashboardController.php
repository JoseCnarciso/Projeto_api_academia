<?php

namespace App\Http\Controllers;

use App\Models\Exercises;
use App\Models\Plan;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Middleware\ValidateLimitStudentsToUser;
use App\Models\Student;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    use HttpResponses;
    public function index(Request $request, ValidateLimitStudentsToUser $limitValidator)
    {
        try {

            if (!Auth::check()) {
                return $this->error('Usuário não autenticado', Response::HTTP_UNAUTHORIZED);
            }

            $authenticatedUser = Auth::user();


            $userPlan = $authenticatedUser->plan;
            $amountExercises = Exercises::where('user_id', $authenticatedUser->id)->count();
            $amountStudents = Student::where('user_id', $authenticatedUser->id)->count();

            $maxStudents = $limitValidator->getMaxStudentsByPlanId($userPlan->id);
            $remainingStudents = max(0, $maxStudents - $amountStudents);

            $response = [
                'registered_students' => $amountStudents,
                'registered_exercises' => $amountExercises,
                'current_user_plan' => "PLANO " . $userPlan->description,
                'remaining_students' => ($maxStudents === PHP_INT_MAX) ? 'ILIMITADO' : max(0, (int)$maxStudents - $amountStudents)
            ];

            return $response;

        } catch (\Exception $exception) {

            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
