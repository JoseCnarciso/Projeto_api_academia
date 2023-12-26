<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lista de exercícios para a semana</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            font-size: 8px;
            margin: 20px;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        h2 {
            color: #555;
            margin-top: 20px;
            text-align: center;
        }

        table {
            width: 100%;
            margin-top: 10px;
            border-collapse: collapse;
        }

        th, td {
            padding: 3px;
            border: 1px solid #ddd;
            text-align: center;
            width: 8%;
        }

        th {
            background-color: #f2f2f2;
        }

        p {
            color: #777;
            text-align: center;
        }

        .exercise-done-checkbox {
            margin-right: 5px;
        }
    </style>
</head>

<body>

    <h1>Lista de exercícios para a semana</h1>
    <p>Nome: {{ $student_name }}</p>

    @foreach ($workouts as $day => $dayWorkouts)
        <h2>{{ $day }}</h2>

        @if (count($dayWorkouts) > 0)
            <table>
                <thead>
                    <tr>
                        <th>Exercício</th>
                        <th>Repetições</th>
                        <th>Peso</th>
                        <th>Tempo de Descanso</th>
                        <th>Observações</th>
                        <th>Tempo</th>
                        <th>Check</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dayWorkouts as $workout)
                        <tr>
                            <td>{{ $workout['exercise_description'] }}</td>
                            <td>{{ $workout['repetitions'] }}</td>
                            <td>{{ $workout['weight'] }}</td>
                            <td>{{ $workout['break_time'] }}</td>
                            <td>{{ $workout['observations'] ?: 'N/A' }}</td>
                            <td>{{ $workout['time'] }}</td>
                            <td>
                                <input type="checkbox" class="exercise-done-checkbox" name="exercise_done[{{ $workout['exercise_description'] }}]">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Não há treinos para este dia.</p>
        @endif
    @endforeach

</body>

</html>
