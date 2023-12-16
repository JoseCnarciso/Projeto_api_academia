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

    public function store(Request $request){
        try {

        $data = $request ->all();

        $request-> validate([
            'name' => 'string|required|max:255',
            'email' => 'email|required|max:255',
            'date_birth' => 'date|required',
            'cpf' => 'string|required|max:14',
            'contact' => 'string|required|max:20',
            'user_id' => 'required|integer',
            'city'=>'string|required|max:50',
            'neighborhood'=>'string|required|max:50',
            'number'=>'string|required|max:30',
            'street'=>'string|required|max:30',
            'state'=>'string|required|max:2',
            'cep'=>'string|required|max:20',

        ]);

        $student =Students::create($data);
        $user = User::find($student->user_id);

        return $student;

        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function index(Request $request){

        $filter = $request->query();


    }
}
