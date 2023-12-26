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

            if (!Auth::check()) {

                return $this->error('Usuário não autenticado', Response::HTTP_UNAUTHORIZED);
            }

            $authenticatedUserId = Auth::user()->id;

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
                'cep' => 'regex:/^\d{5}-\d{3}$/|max:20',
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

            return $this->response('Aluno cadastrado com sucesso', Response::HTTP_CREATED, $student);

        } catch (\Exception $exception) {

            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    public function index(Request $request)
    {
        try {

            if (!Auth::check()) {

                return $this->error('Usuário não autenticado', Response::HTTP_UNAUTHORIZED);
            }

            $authenticatedUserId = Auth::user()->id;

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

            if (!Auth::check()) {
                return $this->error('Usuário não autenticado', Response::HTTP_UNAUTHORIZED);
            }

            $authenticatedUserId = Auth::user()->id;

            $student = Student::find($id);

            if (!$student) {

                return $this->error('Estudante não encontrado', Response::HTTP_NOT_FOUND);
            }

            if ($student->user_id !== $authenticatedUserId) {

                return $this->error('Usuário não autorizado a atualizar este estudante', Response::HTTP_UNAUTHORIZED);
            }

            $data = $request->validate([
                'name' => 'string|max:255',
                'email' => 'email|max:255',
                'date_birth' => 'string|date_format:Y-m-d',
                'cpf' => 'string|regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/',
                'contact' => 'string|max:20|regex:/^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/',
                'city' => 'string|max:50',
                'neighborhood' => 'string|max:50',
                'number' => 'string|max:30',
                'street' => 'string|max:30',
                'state' => 'string|max:2',
                'cep' => 'string|regex:/^\d{5}-\d{3}$/|max:20',
            ]);

            $existingStudentWithEmail = Student::where('email', $data['email'])
                ->where('id', '!=', $id)
                ->first();

            if ($existingStudentWithEmail) {
                return $this->error('Aluno com o mesmo e-mail já cadastrado', Response::HTTP_CONFLICT);
            }

            $existingStudent = Student::where('cpf', $data['cpf'])
                ->where('id', '!=', $id)
                ->first();

            if ($existingStudent) {

                return $this->error('Aluno com o mesmo CPF já cadastrado', Response::HTTP_CONFLICT);
            }

            $student->update($data);

            return $this->response('Aluno atualizado com sucesso', Response::HTTP_OK, $student);

        } catch (\Exception $exception) {

            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    public function show(Request $request, $id = null)
    {
        try {
            if (!Auth::check()) {

                return $this->error('Usuário não autenticado', Response::HTTP_UNAUTHORIZED);
            }

            $authenticatedUserId = Auth::user()->id;

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

            if (!Auth::check()) {

                return $this->error('Usuário não autenticado', Response::HTTP_UNAUTHORIZED);
            }

            $authenticatedUserId = Auth::user()->id;

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
        if (!Auth::check()) {

            return $this->error('Usuário não autenticado', Response::HTTP_UNAUTHORIZED);
        }

        $authenticatedUserId = Auth::user()->id;

        $student = Student::find($id);

        if (!$student) return $this->error('ID não encontrado', Response::HTTP_NOT_FOUND);

        if ($student->user_id !== $authenticatedUserId) {

            return $this->error('Você não tem permissão para excluir este estudante', Response::HTTP_FORBIDDEN);
        }

        $student->delete();

        return $this->response('', Response::HTTP_NO_CONTENT);
    }
}
