<?php

namespace App\Http\Controllers;

use App\Models\Exercises;
use App\Models\Student;
use App\Models\Workout;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class WorkoutController extends Controller
{
    use HttpResponses;
    public function store(Request $request)
    {
        try {

            if (!Auth::check()) {
                return $this->error('Usuário não autenticado', Response::HTTP_UNAUTHORIZED);
            }

            $authenticatedUserId = Auth::user()->id;

            $data = $request->validate([
                'student_id' => 'required|exists:students,id',
                'exercise_id' => 'required|exists:exercises,id',
                'repetitions' => 'required|integer|gt:0',
                'weight' => 'required|numeric',
                'break_time' => 'required|integer',
                'day' => 'in:SEGUNDA,TERÇA,QUARTA,QUINTA,SEXTA,SABADO,DOMINGO',
                'observations' => 'nullable|string',
                'time' => 'required|integer',
            ]);

            $studentExists = Student::find($data['student_id']);

            if (!$studentExists) {
                return $this->error('Estudante não encontrado', Response::HTTP_BAD_REQUEST);
            }

            if ($studentExists->user_id !== $authenticatedUserId) {
                return $this->error('Usuário não autorizado para cadastrar treinos para este aluno', Response::HTTP_UNAUTHORIZED);
            }


            $exerciseExists = Exercises::find($data['exercise_id']);

            if (!$exerciseExists) {
                return $this->error('Exercício não encontrado', Response::HTTP_BAD_REQUEST);
            }

            if ($exerciseExists->user_id !== $authenticatedUserId) {
                return $this->error('Usuário não autorizado para cadastrar treinos com este exercício', Response::HTTP_UNAUTHORIZED);
            }

            $existingWorkouts = Workout::where('day', $data['day'])
                ->where('student_id', $data['student_id'])
                ->where('exercise_id', $data['exercise_id'])
                ->count();

            if ($existingWorkouts > 0) {
                return $this->error('Este exercício já foi cadastrado para o estudante neste dia', Response::HTTP_CONFLICT);
            }

            $totalWorkoutsForDay = Workout::where('day', $data['day'])
                ->where('student_id', $data['student_id'])
                ->count();

            if ($totalWorkoutsForDay >= 12) {
                return $this->error('Limite de 12 exercícios atingido para o dia selecionado', Response::HTTP_CONFLICT);
            }

            $workout = Workout::create($data);

            $studentName = $studentExists->name;
            $exerciseName = $exerciseExists->description;

            return $this->response(
                'Treino cadastrado com sucesso',
                Response::HTTP_CREATED,
                [
                    'workout_id' => $workout->id,
                    'student_name' => $studentName,
                    'exercise_name' => $exerciseName,
                    'repetitions' => $data['repetitions'],
                    'weight' => $data['weight'],
                    'break_time' => $data['break_time'],
                    'day' => $data['day'],
                    'time' => $data['time'],
                ]
            );

        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
