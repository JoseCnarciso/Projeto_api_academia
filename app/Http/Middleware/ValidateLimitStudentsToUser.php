<?php

namespace App\Http\Middleware;

use App\Models\Students;
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
    $user = User::query()->where('id', $request->user()->id)->first();

    if (!$request->user()) {
        return $this->error('Não autorizado', Response::HTTP_UNAUTHORIZED);
    }

    if ($user) {
        $planId = $user->plan_id;

        $maxStudents = $this->getMaxStudentsByPlanId($planId);
        $currentStudents = Students::where('user_id', $user->id)->count();

        if ($currentStudents >= $maxStudents) {

            return $this->error('Limite de cadastro atingido', Response::HTTP_FORBIDDEN);
        }
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

