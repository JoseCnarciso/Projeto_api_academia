<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bem-vindo ao CrossTrain!</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            text-align: center;
            margin: 20px;
        }

        h2 {
            color: #3498db;
        }

        h3 {
            color: #2ecc71;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        strong {
            color: #e74c3c;
        }

        p {
            margin-bottom: 20px;
            line-height: 1.6;
        }

        footer {
            color: #999;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <h2>Olá, {{ $user->name }}!</h2>
    <p>Seja muito bem-vindo(a) ao CrossTrain! Estamos empolgados em tê-lo(a) como parte da nossa comunidade.</p>
    <h3>Detalhes da Sua Conta:</h3>
    <ul>
        <li><strong>Nome do Usuário:</strong> {{ $user->name }}</li>
        <li><strong>Plano Escolhido:</strong> {{ $plan->description }}</li>
        <li><strong>Limite de Alunos Cadastrados:</strong> {{ $plan->limit ?? 'Ilimitado' }}</li>
    </ul>

    <p>Agradecemos por escolher o CrossTrain para gerenciar suas atividades educacionais. Com o plano {{ $plan->description }}, você terá a oportunidade de cadastrar {{ $plan->limit ?? 'um número ilimitado de ' }} alunos.</p>

    <p>Estamos aqui para ajudar em tudo o que precisar. Se tiver alguma dúvida ou precisar de suporte, não hesite em entrar em contato conosco.</p>

    <p>Obrigado por fazer parte da nossa comunidade!</p>

    <footer>Atenciosamente, A Equipe do CrossTrain</footer>
</body>

</html>
