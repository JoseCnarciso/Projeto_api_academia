<?php

namespace App\Http\Controllers;

use App\Mail\SendWelcomeUser;
use App\Models\Plan;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    use HttpResponses;

    public function store(Request $request)
    {

        try {

            $data = $request->all();

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'email|required|max:255',
                'password' => 'string|required|min:8|max:32',
                'plan_id' => 'required|integer',
                'cpf' => 'string|required|min:14|max:14',
                'date_birth' => 'date|required'
            ]);

            if (User::where('email', $data['email'])->exists()) {
                return $this->error('Email já cadastrado', Response::HTTP_CONFLICT);
            }
            if (User::where('cpf', $data['cpf'])->exists()) {
                return $this->error('cpf já cadastrado', Response::HTTP_CONFLICT);
            }

            $user = User::create($data);
            $plan = Plan::find($user->plan_id);

            Mail::to($user->email, $user->name)->send(new SendWelcomeUser($user, $plan));



            return $user;
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
