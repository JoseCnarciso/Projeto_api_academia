<?php

namespace App\Http\Middleware;

use App\Models\Student;
use App\Models\User;
use App\Traits\HttpResponses;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateLimitStudentsToUser
{
    use HttpResponses;

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return $this->error('Não autorizado', Response::HTTP_UNAUTHORIZED);
        }

        $planId = $user->plan_id;

        $maxStudents = $this->getMaxStudentsByPlanId($planId);
        $currentStudents = Student::where('user_id', $user->id)->count();

        if ($currentStudents >= $maxStudents) {
            return $this->error('Limite de cadastro atingido', Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }

    public function getMaxStudentsByPlanId($planId)
    {
        switch ($planId) {
            case 1:
                return 10;
            case 2:
                return 20;
            case 3:
                return PHP_INT_MAX;
            default:
                return 0;
        }
    }
}