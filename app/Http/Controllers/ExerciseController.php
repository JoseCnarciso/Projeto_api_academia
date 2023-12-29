<?php

namespace App\Http\Controllers;

use App\Models\Exercises;
use App\Models\Student;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ExerciseController extends Controller
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
                'description' => 'required|string|max:255',
                'user_id' => 'required|exists:users,id'
            ]);

            if ($data['user_id'] !== $authenticatedUserId) {
                return $this->error('O usuário logado não corresponde ao user_id fornecido', Response::HTTP_FORBIDDEN);
            }

            $existingExercise = Exercises::where('description', $data['description'])
                ->where('user_id', $authenticatedUserId)
                ->first();

            if ($existingExercise) {
                return $this->error('Este exercício já foi cadastrado pelo usuário', Response::HTTP_CONFLICT);
            }

            $exercise = Exercises::create($data);
            $user = User::find($exercise->user_id);

            return $exercise;

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

            $filter = $request->query('description');

            $exercises = Exercises::query()
                ->select('id', 'description')
                ->where('user_id', $authenticatedUserId);

            if ($request->has('description') && !empty($filter)) {
                $exercises->where('description', 'ilike', '%' . $filter . '%');
            }

            $columnOrder = $request->has('order') ? $request->query('order') : 'id';

            return $exercises->orderBy($columnOrder)->get();

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

    $exercise = Exercises::find($id);

    if (!$exercise) {
        return $this->error('ID não encontrado', Response::HTTP_NOT_FOUND);
    }

    if ($exercise->user_id !== $authenticatedUserId) {

        return $this->error('Você não tem permissão para excluir este exercício', Response::HTTP_FORBIDDEN);
    }
    
    $count = AnotherModel::where('exercise_id', $exercise->id)->count();

    if ($count > 0) {

        return $this->error('O exercício está sendo usado e não pode ser excluído', Response::HTTP_CONFLICT);
    }
    
    $exercise->delete();

    return $this->response('', Response::HTTP_NO_CONTENT);
}

}