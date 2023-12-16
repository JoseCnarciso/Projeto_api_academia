<?php

namespace App\Http\Controllers;

use App\Models\Exercises;
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

            $data = $request->all();

            $request->validate([
                'description' => 'required|string|max:255',
                'user_id' => 'required|exists:users,id'
            ]);

            if (Exercises::where('description', $data['description'])->exists()) {
                return $this->error('Exercício já cadastrado', Response::HTTP_CONFLICT);
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
            $filter = $request->query('description');

            $exercises = Exercises::query()
                ->select('id', 'description');

            if ($request->has('description') && !empty($filter)) {
                $exercises->where('description', 'ilike', '%' . $filter . '%');
            }

            $columnOrder = $request->has('order') && !empty($filter['order']) ? $filter['order'] : 'id';

            return $exercises->orderBy($columnOrder)->get();
        } catch (\Exception $exception) {

            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy($id)

    {
        $exercise = Exercises::find($id);

        if (!$exercise) return $this->error('ID não encontrado', Response::HTTP_NOT_FOUND);

        $authenticatedUserId = Auth::id();

        if ($exercise->user_id !== $authenticatedUserId) {
            return $this->error('Você não tem permissão para excluir este exercício', Response::HTTP_FORBIDDEN);
        }

        $exercise->delete();

        return $this->response('', Response::HTTP_NO_CONTENT);
    }
}
