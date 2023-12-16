<?php

namespace App\Http\Controllers;

use App\Models\Exercises;
use App\Models\Students;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
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
                return $this->error('Exercicio já cadastrado', Response::HTTP_CONFLICT);
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

            // Verifica se o parâmetro 'description' está presente e não está vazio.
            if ($request->has('description') && !empty($filter)) {
                // Utiliza a cláusula WHERE para filtrar por descrição.
                $exercises->where('description', 'ilike', '%' . $filter . '%');
            }

            $columnOrder = $request->has('order') && !empty($filter['order']) ? $filter['order'] : 'id';

            // Ordena a consulta pela coluna especificada.
            return $exercises->orderBy($columnOrder)->get();
        } catch (\Exception $exception) {
            // Em caso de exceção, retorna uma resposta de erro com a mensagem da exceção e status HTTP 400 (Bad Request).
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
