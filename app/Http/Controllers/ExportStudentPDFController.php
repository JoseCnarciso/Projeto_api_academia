<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Traits\HttpResponses;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExportStudentPDFController extends Controller
{
    use HttpResponses;

    public function showPerfilStudentPdf(Request $request)
    {
        try {

            if (!Auth::check()) {

                return $this->error('Usuário não autenticado', Response::HTTP_UNAUTHORIZED);
            }

            $user = Auth::user();

            $id = $request->input('id');
            $student = Student::where('user_id', $user->id)->findOrFail($id);

            if (!$student) {

                return $this->error('Você não tem permissão para exportar este aluno', Response::HTTP_FORBIDDEN);
            }

            $daysOfWeek = ['SEGUNDA', 'TERÇA', 'QUARTA', 'QUINTA', 'SEXTA', 'SABADO', 'DOMINGO'];
            $organizedWorkouts = [];

            foreach ($daysOfWeek as $day) {

                $workouts = $this->getStudentWorkoutsByDay($student, $day);
                $organizedWorkouts[$day] = $this->formatWorkouts($workouts);
            }

            $data = [
                'student_name' => $student->name,
                'workouts' => $organizedWorkouts,
            ];

            $pdf = Pdf::loadView('pdf.exportStudentPdf', $data);

            return $pdf->stream('student_workouts.pdf');

        } catch (\Exception $exception) {

            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    private function getStudentWorkoutsByDay(Student $student, $day)
    {
        return $student->workouts()
            ->where('day', $day)
            ->join('exercises', 'workouts.exercise_id', '=', 'exercises.id')
            ->select('exercises.description', 'workouts.*')
            ->get();
    }

    private function formatWorkouts($workouts)
    {
        return $workouts->map(function ($workout) {
            return [
                'exercise_description' => $workout->description,
                'repetitions' => $workout->repetitions,
                'weight' => $workout->weight,
                'break_time' => $workout->break_time,
                'observations' => $workout->observations,
                'time' => $workout->time,
            ];
        })->toArray();
    }
}
