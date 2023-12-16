<?php

namespace App\Http\Controllers;

use App\Models\Exercises;
use App\Models\Plan;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
    use HttpResponses;

    public function index(Request $request)
    {
        try {



            // Conta a quantidade de planos que tem no id
            $amountPlans = Plan::where('user_id', 1)->count();
            $amountExercises = Exercises::where('user_id',1)->count();

            return [
                'amountPlans' => $amountPlans,
                'amountExercises' => $amountExercises
            ];
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
