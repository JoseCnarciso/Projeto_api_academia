<?php

namespace App\Http\Controllers;

use App\Models\Students;
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
            $data = $request->validate([
                'name' => 'string|required|max:255',
                'email' => 'email|required|max:255',
                'date_birth' => 'date|required',
                'cpf' => 'string|required|max:14',
                'contact' => 'string|required|max:20',
                'user_id' => 'required|integer',
                'city' => 'string|required|max:50',
                'neighborhood' => 'string|required|max:50',
                'number' => 'string|required|max:30',
                'street' => 'string|required|max:30',
                'state' => 'string|required|max:2',
                'cep' => 'string|required|max:20',
            ]);

            if (Students::where('email', $data['email'])->exists()) {
                return $this->error('Email já cadastrado', Response::HTTP_CONFLICT);
            }
            if (Students::where('cpf', $data['cpf'])->exists()) {
                return $this->error('cpf já cadastrado', Response::HTTP_CONFLICT);
            }

            $student = Students::create($data);
            $user = User::find($student->user_id);

            return $student;
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    public function index(Request $request)
    {
        try {

            $authenticatedUser = Auth::user();

            if (!$authenticatedUser) {
                return $this->error('Usuário não autenticado', Response::HTTP_UNAUTHORIZED);
            }

            $students = $authenticatedUser->students()
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

            $students->where('user_id', $authenticatedUser->id);

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

            $columnOrder = $request->has('order') && !empty($filter['order']) ? $filter['order'] : 'name';

            return $students->orderBy($columnOrder)->get();
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function update($id, Request $request)
    {
        try {
            $authenticatedUser = Auth::user();

            if (!$authenticatedUser) {
                return $this->error('Usuário não autenticado', Response::HTTP_UNAUTHORIZED);
            }

            $student = Students::find($id);

            if (!$student) {
                return $this->error('Estudante não encontrado', Response::HTTP_NOT_FOUND);
            }

            $data = $request->validate([
                'name' => 'string|required|max:255',
                'email' => 'email|required|max:255',
                'date_birth' => 'date|required',
                'cpf' => 'string|required|max:14',
                'contact' => 'string|required|max:20',
                'city' => 'string|required|max:50',
                'neighborhood' => 'string|required|max:50',
                'number' => 'string|required|max:30',
                'street' => 'string|required|max:30',
                'state' => 'string|required|max:2',
                'cep' => 'string|required|max:20',
            ]);

            if (Students::where('email', $data['email'])->where('id', '<>', $id)->exists()) {
                return $this->error('Email já cadastrado', Response::HTTP_CONFLICT);
            }

            if (Students::where('cpf', $data['cpf'])->where('id', '<>', $id)->exists()) {
                return $this->error('CPF já cadastrado', Response::HTTP_CONFLICT);
            }

            $student->update($data);

            return $student;
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }



    public function destroy($id)

    {
        $student = Students::find($id);

        if (!$student) return $this->error('ID não encontrado', Response::HTTP_NOT_FOUND);

        $authenticatedUserId = Auth::id();

        if ($student->user_id !== $authenticatedUserId) {
            return $this->error('Você não tem permissão para excluir este exercício', Response::HTTP_FORBIDDEN);
        }

        $student->delete();

        return $this->response('', Response::HTTP_NO_CONTENT);
    }

}
