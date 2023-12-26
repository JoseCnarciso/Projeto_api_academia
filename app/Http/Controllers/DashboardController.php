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
use App\Models\Students;

class DashboardController extends Controller
{
    use HttpResponses;
    public function index(Request $request, ValidateLimitStudentsToUser $limitValidator)
    {
        try {
            $authenticatedUser = Auth::user();

            if (!$authenticatedUser) {
                return $this->error('Usuário não autenticado', Response::HTTP_UNAUTHORIZED);
            }

            $userPlan = $authenticatedUser->plan;

            $amountExercises = Exercises::where('user_id', $authenticatedUser->id)->count();
            $amountStudents = Students::where('user_id', $authenticatedUser->id)->count();

            $maxStudents = $limitValidator->getMaxStudentsByPlanId($userPlan->id);
            $remainingStudents = max(0, $maxStudents - $amountStudents);

            return [
                'registered_students' => $amountStudents,
                'registered_exercises' => $amountExercises,
                'current_user_plan' => "PLANO " . $userPlan->description,
                'remaining_students' => $remainingStudents,
            ];
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
