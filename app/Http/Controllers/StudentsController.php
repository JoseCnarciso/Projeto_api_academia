<?php

namespace App\Http\Controllers;

use App\Models\Students;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
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
            // pesquisa geral - nome, cpf e email
            $filter = $request->query();

            $students = Students::query()
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

            if ($request->has('name') && !empty($filter['name'])) {
                $students->where('name', 'ilike', '%' . $filter['name'] . '%');
            }
            if ($request->has('cpf') && !empty($filter['cpf'])) {
                $students->where('cpf', 'ilike', '%' . $filter['cpf'] . '%');
            }
            if ($request->has('email') && !empty($filter['email'])) {
                $students->where('email', 'ilike', '%' . $filter['email'] . '%');
            }

            $columnOrder = $request->has('order') && !empty($filter['order']) ?  $filter['order'] : 'name';

            return $students->orderBy($columnOrder)->get();
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
