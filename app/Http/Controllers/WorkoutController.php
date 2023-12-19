<?php

namespace App\Http\Controllers;

use App\Models\Exercises;
use App\Models\Students;
use App\Models\Workout;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WorkoutController extends Controller
{
    use HttpResponses;
    public function store(Request $request)
    {
        try {
            $authenticatedUser = $request->user();
            if (!$authenticatedUser) {
                return $this->error('Usuário não autenticado', Response::HTTP_UNAUTHORIZED);
            }

            $data = $request->validate([
                'student_id' => 'required|integer|exists:students,id',
                'exercise_id' => 'required|integer|exists:exercises,id',
                'repetitions' => 'integer|required',
                'weight' => 'float|required',
                'break_time' => 'integer|required',
                'day' => 'string|required'
            ]);

            $studentExists = Students::find($data['student_id']);
            $exerciseExists = Exercises::find($data['exercise_id']);

            if (!$studentExists) {
                return $this->error('Estudante não encontrado', Response::HTTP_NOT_FOUND);
            }
            if (!$exerciseExists) {
                return $this->error('Exercício não encontrado', Response::HTTP_NOT_FOUND);
            }

            $workout = Workout::create($data);

            return $workout;
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
