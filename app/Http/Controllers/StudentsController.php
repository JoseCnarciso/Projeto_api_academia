<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StudentsController extends Controller
{
    use HttpResponses;
    public function store(Request $request)
    {
        try {

            $authenticatedUserId = $request->user()->id;

            $data = $request->validate([
                'name' => 'string|required|max:255',
                'email' => 'email|required|max:255',
                'date_birth' => 'string|required|date_format:Y-m-d',
                'cpf' => 'string|required|regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/',
                'contact' => 'string|required|max:20|regex:/^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/',
                'user_id' => 'required|integer',
                'city' => 'string|max:50',
                'neighborhood' => 'string|max:50',
                'number' => 'string|max:30',
                'street' => 'string|max:30',
                'state' => 'string|max:2',
                'cep' => 'string|required|regex:/^\d{5}-\d{3}$/|max:20',
            ]);


            if ($data['user_id'] !== $authenticatedUserId) {
                return $this->error('O usuário logado não corresponde ao user_id fornecido', Response::HTTP_FORBIDDEN);
            }

            if (Student::where('email', $data['email'])->exists()) {
                return $this->error('Email já cadastrado', Response::HTTP_CONFLICT);
            }
            if (Student::where('cpf', $data['cpf'])->exists()) {
                return $this->error('CPF já cadastrado', Response::HTTP_CONFLICT);
            }

            $student = Student::create($data);
            $user = User::find($student->user_id);

            return $student;
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function index(Request $request)
    {
        try {

            $authenticatedUserId = Auth::user()->id;

            if (!$authenticatedUserId) {
                return $this->error('Usuário não autenticado', Response::HTTP_UNAUTHORIZED);
            }

            $students = Student::where('user_id', $authenticatedUserId)
                ->select(
                    'id',
                    'name',
                    'email',
                    'date_birth',
                    'cpf',
                    'contact',
                    'cep',
                    'street',
                    'state',
                    'neighborhood',
                    'city',
                    'number'
                );

            $filter = $request->query();
            if ($request->has('name') && !empty($filter['name'])) {
                $students->where('name', 'ilike', '%' . $filter['name'] . '%');
            }
            if ($request->has('cpf') && !empty($filter['cpf'])) {
                $students->where('cpf', 'ilike', '%' . $filter['cpf'] . '%');
            }
            if ($request->has('email') && !empty($filter['email'])) {
                $students->where('email', 'ilike', '%' . $filter['email'] . '%');
            }

            $columnOrder = $request->has('order') && !empty($filter['order']) ? $filter['order'] : 'id';

            return $students->orderBy($columnOrder)->get();
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function update($id, Request $request)
    {
        try {

            $authenticatedUserId = Auth::user()->id;

            if (!$authenticatedUserId) {
                return $this->error('Usuário não autenticado', Response::HTTP_UNAUTHORIZED);
            }

            $student = Student::find($id);

            if (!$student) {
                return $this->error('Estudante não encontrado', Response::HTTP_NOT_FOUND);
            }

            if ($student->user_id !== $authenticatedUserId->id) {
                return $this->error('Não autorizado a atualizar este estudante', Response::HTTP_FORBIDDEN);
            }

            $data = $request->only([
                'name' => 'string|max:255',
                'email' => 'email|max:255',
                'date_birth' => 'string|date_format:Y-m-d',
                'cpf' => 'string|regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/',
                'contact' => 'string|max:20|regex:/^\([1-9]{2}\) 9[0-9]{4}-[0-9]{4}$/',
                'user_id' => 'integer',
                'city' => 'string|max:50',
                'neighborhood' => 'string|max:50',
                'number' => 'string|max:30',
                'street' => 'string|max:30',
                'state' => 'string|max:2',
                'cep' => 'string|regex:/^\d{5}-\d{3}$/|max:20'
            ]);

            $student->update($data);

            return $this->response('Estudante atualizado com sucesso', 200, $student);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $authenticatedUserId = Auth::user()->id;

            if (!$authenticatedUserId) {
                return $this->error('Usuário não autenticado', Response::HTTP_UNAUTHORIZED);
            }

            if ($id) {
                $student = Student::where('user_id', $authenticatedUserId)->find($id);

                if (!$student) {
                    return $this->error('Estudante não encontrado', Response::HTTP_NOT_FOUND);
                }
            } else {
                $student = Student::where('user_id', $authenticatedUserId)->first();

                if (!$student) {
                    return $this->error('Estudante não encontrado', Response::HTTP_NOT_FOUND);
                }
            }

            return $student;
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function showWorkoutsStudents($id)
    {
        try {
            $authenticatedUserId = Auth::user()->id;

            if (!$authenticatedUserId) {
                return $this->error('Usuário não autenticado', Response::HTTP_UNAUTHORIZED);
            }

            $student = Student::where('user_id', $authenticatedUserId)->findOrFail($id);

            $organizedWorkouts = [];
            $daysOfWeek = ['SEGUNDA', 'TERÇA', 'QUARTA', 'QUINTA', 'SEXTA', 'SABADO', 'DOMINGO'];

            foreach ($daysOfWeek as $day) {
                $workouts = $student->workouts()
                    ->where('day', $day)
                    ->join('exercises', 'workouts.exercise_id', '=', 'exercises.id')
                    ->select('exercises.description', 'workouts.*')
                    ->get();

                $organizedWorkouts[$day] = $workouts->map(function ($workout) {
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

            $response = [
                'student_id' => $student->id,
                'student_name' => $student->name,
                'workouts' => $organizedWorkouts,
            ];

            return $response;
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy($id)

    {
        $student = Student::find($id);

        if (!$student) return $this->error('ID não encontrado', Response::HTTP_NOT_FOUND);

        $authenticatedUserId = Auth::id();

        if ($student->user_id !== $authenticatedUserId) {
            return $this->error('Você não tem permissão para excluir este exercício', Response::HTTP_FORBIDDEN);
        }

        $student->delete();

        return $this->response('', Response::HTTP_NO_CONTENT);
    }
}
