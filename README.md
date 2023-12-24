Nome do Software: FitManager

Introdução
O FitManager surge como uma revolucionária solução de gerenciamento de treinos, projetada sob medida para atender às necessidades exclusivas de academias e profissionais
de educação física. Neste artigo, exploraremos em detalhes como o FitManager se destaca na otimização do controle e acompanhamento dos treinos de alunos.

Descrição do Problema Resolvido
O FitManager visa simplificar e aprimorar a gestão de treinos, fornecendo uma plataforma eficiente para o cadastro de exercícios, planos, alunos e seus respectivos treinos.
A principal proposta é oferecer uma solução que não apenas organize informações, mas também proporcione uma visão clara do progresso individual de cada aluno.

Técnicas e Tecnologias Utilizadas
Laravel: A escolha do robusto framework PHP Laravel confere ao FitManager eficiência e confiabilidade.
PostgreSQL: Como sistema de gerenciamento de banco de dados relacional, o PostgreSQL assegura uma manipulação eficaz dos dados.
API REST: A implementação de uma API REST facilita a integração fluida entre o front-end e o back-end do sistema.
DomPDF: A biblioteca DomPDF é utilizada para a geração de arquivos PDF, agregando valor à documentação do treino.
Sanctum: Para autenticação via API, o FitManager utiliza Sanctum, garantindo segurança no acesso e manipulação de dados.
Middleware: Implementado para validação e segurança em diversas operações, o uso de Middleware eleva a integridade do sistema.
Estrutura do Projeto
O FitManager estrutura-se em modelos essenciais, cada um desempenhando um papel vital no armazenamento e organização dos dados:

Exercise: Armazena dados específicos de exercícios.
Plan: Registra informações sobre os planos de treino.
Student: Contém dados individuais de alunos.
User: Responsável por armazenar dados de usuários do sistema.
Workout: Centraliza informações relativas aos treinos.
Utilização no Projeto
Os modelos são a espinha dorsal do FitManager, proporcionando a estrutura necessária para o armazenamento de dados cruciais, incluindo exercícios, planos, alunos, usuários e treinos. Cada um desempenha um papel fundamental no funcionamento fluido do sistema, garantindo que as informações sejam armazenadas e acessadas de maneira eficiente.

Melhorando Dados Básicos
Ao abordar a necessidade de melhorar os dados básicos, reconhecemos a importância de aprimorar a qualidade da informação. O FitManager oferece uma abordagem abrangente, capacitando academias a enriquecer os dados essenciais para um gerenciamento eficaz. As funcionalidades intuitivas e a interface amigável do FitManager tornam o processo de aprimoramento de dados simples e acessível.

Conclusão
Em conclusão, o FitManager se destaca como uma poderosa ferramenta para academias que buscam otimizar o gerenciamento de treinos. Com uma combinação de tecnologias avançadas, uma estrutura de projeto sólida e um compromisso com a qualidade dos dados, o FitManager posiciona-se como líder no mercado. Ao adotar essa solução, academias podem não apenas melhorar seus dados básicos, mas também elevar a eficiência e a qualidade de seus serviços.

Como Executar o Projeto Laravel:

Clone o repositório: git clone <Uhttps://github.com/JoseCnarciso/Projeto_api_academia.git>
Navegue até o diretório do projeto: Projeto_api_academia
Instale as dependências: composer install
Copie o arquivo .env.example para .env: cp .env.example .env

DIALECT_DATABASE=''
HOST_DATABASE=''
USER_DATABASE=''
PASSWORD_DATABASE=''
PORT_DATABASE=''
PORT_API=''
NAME_DATABASE=''

Configure o arquivo .env com suas credenciais de banco de dados e outras configurações necessárias.
Execute as migrações do banco de dados: php artisan migrate
Execute as seeders do banco de dados: php artisan db:seed PolupatePlans
Inicie o servidor: php artisan serve
A aplicação estará disponível em http://localhost:8000.

Rotas da Aplicação - FitManager

Aqui estão as rotas detalhadas para as diversas operações disponíveis na aplicação FitManager.

UserController - Modelo de Requisição e Resposta

Método: store (Cadastro de Novo Usuário)
Modelo de Requisição:

Tipo: POST
Endpoint: /api/users
Corpo da Requisição (JSON):
json

{
  "name": "Nome do Usuário",
  "email": "exemplo@email.com",
  "password": "senha123",
  "plan_id": 1,
  "cpf": "123.456.789-01",
  "date_birth": "1990-01-01"
}

Observações:

O campo name deve ser uma string válida e é obrigatório.
O campo email deve ser um endereço de e-mail válido e é obrigatório.
O campo password deve ser uma string válida contendo entre 8 e 32 caracteres, e é obrigatório.
O campo plan_id deve ser um número inteiro e é obrigatório.
O campo cpf deve ser uma string válida contendo 14 caracteres (formato: xxx.xxx.xxx-xx) e é obrigatório.
O campo date_birth deve ser uma data válida no formato 'YYYY-MM-DD' e é obrigatório.
Modelo de Resposta (Sucesso):

Status: 200 OK
Corpo da Resposta (JSON):
json

{
  "id": 1,
  "name": "Nome do Usuário",
  "email": "exemplo@email.com",
  "plan_id": 1,
  "cpf": "123.456.789-01",
  "date_birth": "1990-01-01"
}

Observações:

Os campos id, created_at, e updated_at são gerados automaticamente pelo sistema.
Em caso de sucesso, o usuário é criado e retornado como resposta.
Modelo de Resposta (Falha - E-mail ou CPF já cadastrados):

Status: 409 Conflict
Corpo da Resposta (JSON):
json

{
  "error": "Email já cadastrado"
}
ou
json

{
  "error": "CPF já cadastrado"
}

Observações:

Em caso de tentativa de cadastro com um e-mail ou CPF já existentes no sistema.
Modelo de Resposta (Falha - Outros Erros):

Status: 400 Bad Request
Corpo da Resposta (JSON):
json

{
  "error": "Mensagem de Erro"
}

Observações:

Em caso de outros erros durante o processamento da requisição.


AuthController
- Modelo de Requisição e Resposta

Método: store (Autenticação do Usuário)
Modelo de Requisição:

Tipo: POST
Endpoint: /api/login
Corpo da Requisição (JSON):
json

{
  "email": "exemplo@email.com",
  "password": "senha123"
}

Observações:

O campo email deve ser uma string válida e é obrigatório.
O campo password deve ser uma string válida e é obrigatório.
Modelo de Resposta (Sucesso):

Status: 201 Created
Corpo da Resposta (JSON):
json

{
  "message": "Autorizado",
  "data": {
    "token": "token_gerado",
    "name": "Nome do Usuário"
  }
}

Observações:

O campo token contém o token de acesso gerado.
O campo name contém o nome do usuário autenticado.
Modelo de Resposta (Falha):

Status: 401 Unauthorized
Corpo da Resposta (JSON):
json

{
  "error": "Não autorizado. Credenciais incorretas"
}

Observações:

Em caso de falha na autenticação devido a credenciais incorretas.
Método: logout (Logout do Usuário)
Modelo de Requisição:

Tipo: POST
Endpoint: /api/logout
Modelo de Resposta (Sucesso):

Status: 204 No Content
Corpo da Resposta:
Resposta vazia.

Observações:

O token de acesso atual é revogado, realizando o logout do usuário.
Modelo de Resposta (Falha):

Status: 401 Unauthorized
Corpo da Resposta (JSON):
json

{
  "error": "Não autorizado. Usuário não autenticado"
}

Observações:

Em caso de falha devido à tentativa de logout de um usuário não autenticado.


DashboardController - Modelo de Requisição e Resposta

Método: index (Obtenção de Estatísticas do Painel de Controle)
Modelo de Requisição:

Tipo: GET
Endpoint: /api/dashboard
Cabeçalhos: Authorization: Bearer <seu_token_de_autenticação>
Modelo de Resposta (Sucesso):

Status: 200 OK
Corpo da Resposta (JSON):
json

{
  "registered_students": 10,
  "registered_exercises": 25,
  "current_user_plan": "PLANO GOLD",
  "remaining_students": "ILIMITADO"
}

Observações:

Os valores em "registered_students" e "registered_exercises" representam a quantidade total de alunos
cadastrados e exercícios registrados pelo usuário autenticado, respectivamente.
O campo "current_user_plan" indica o plano atual do usuário.
O campo "remaining_students" indica a quantidade de alunos que o usuário pode cadastrar ainda, com base no limite do plano.
Modelo de Resposta (Falha - Usuário Não Autenticado):

Status: 401 Unauthorized
Corpo da Resposta (JSON):
json

{
  "error": "Usuário não autenticado"
}

Observações:

Em caso de tentativa de acesso ao painel sem autenticação.
Modelo de Resposta (Falha - Outros Erros):

Status: 400 Bad Request
Corpo da Resposta (JSON):
json

{
  "error": "Mensagem de Erro"
}

Observações:

Em caso de outros erros durante o processamento da requisição.


ExerciseController - Modelos de Requisição e Resposta

Método: store (Cadastro de Novo Exercício)
Modelo de Requisição:

Tipo: POST
Endpoint: /api/exercises
Cabeçalhos: Authorization: Bearer <seu_token_de_autenticação>
Corpo da Requisição (JSON):
json

{
  "description": "Nome do Exercício",
  "user_id": 1
}

Observações:

O campo "description" é obrigatório e deve ser uma string com no máximo 255 caracteres.
O campo "user_id" é obrigatório e deve ser o ID do usuário autenticado.
Modelo de Resposta (Sucesso):

Status: 201 Created
Corpo da Resposta (JSON):
json

{
  "id": 1,
  "description": "Nome do Exercício",
  "user_id": 1
}

Observações:

Retorna os dados do exercício recém-criado.
Modelo de Resposta (Falha - Usuário Não Autenticado):

Status: 401 Unauthorized
Corpo da Resposta (JSON):
json

{
  "error": "Usuário não autenticado"
}

Observações:

Em caso de tentativa de cadastro sem autenticação.
Modelo de Resposta (Falha - Outros Erros):

Status: 400 Bad Request
Corpo da Resposta (JSON):
json

{
  "error": "Mensagem de Erro"
}

Observações:

Em caso de outros erros durante o processamento da requisição.


Método: index (Listagem de Exercícios)
Modelo de Requisição:

Tipo: GET
Endpoint: /api/exercises
Cabeçalhos: Authorization: Bearer <seu_token_de_autenticação>
Parâmetros de Consulta (Opcionais):
description: Filtrar por descrição do exercício.
order: Ordenar por coluna (default: 'id').
Modelo de Resposta (Sucesso):

Status: 200 OK
Corpo da Resposta (JSON):
json

[
  {
    "id": 1,
    "description": "Nome do Exercício 1"
  },
  {
    "id": 2,
    "description": "Nome do Exercício 2"
  },
  ...
]

Observações:

Retorna uma lista de exercícios do usuário autenticado.
Modelo de Resposta (Falha - Usuário Não Autenticado):

Status: 401 Unauthorized
Corpo da Resposta (JSON):
json

{
  "error": "Usuário não autenticado"
}

Observações:

Em caso de tentativa de acesso à lista sem autenticação.
Modelo de Resposta (Falha - Outros Erros):

Status: 400 Bad Request
Corpo da Resposta (JSON):
json

{
  "error": "Mensagem de Erro"
}

Observações:

Em caso de outros erros durante o processamento da requisição.
Método: destroy (Exclusão de Exercício)
Modelo de Requisição:

Tipo: DELETE
Endpoint: /api/exercises/{id}
Cabeçalhos: Authorization: Bearer <seu_token_de_autenticação>
Modelo de Resposta (Sucesso):

Status: 204 No Content
Corpo da Resposta: Vazio

Observações:

Retorna uma resposta sem conteúdo em caso de exclusão bem-sucedida.
Modelo de Resposta (Falha - Usuário Não Autenticado):

Status: 401 Unauthorized
Corpo da Resposta (JSON):
json

{
  "error": "Usuário não autenticado"
}

Observações:

Em caso de tentativa de exclusão sem autenticação.
Modelo de Resposta (Falha - ID Não Encontrado):

Status: 404 Not Found
Corpo da Resposta (JSON):
json

{
  "error": "ID não encontrado"
}

Observações:

Em caso de tentativa de exclusão com um ID de exercício inexistente.
Modelo de Resposta (Falha - Permissão Negada):

Status: 403 Forbidden
Corpo da Resposta (JSON):
json

{
  "error": "Você não tem permissão para excluir este exercício"
}

Observações:

Em caso de tentativa de exclusão de um exercício que não pertence ao usuário autenticado.


ExportStudentPDFController - Modelo de Requisição e Resposta

Método: showPerfilStudentPdf (Geração de PDF com Informações Detalhadas dos Treinos de um Aluno)
Modelo de Requisição:

Tipo: GET
Endpoint: /api/students/{id}/workouts/
Cabeçalhos: Authorization: Bearer <seu_token_de_autenticação>
Parâmetros de Rota:
{id}: ID do aluno para o qual o PDF será gerado.
Modelo de Resposta (Sucesso):

Status: 200 OK
Corpo da Resposta: O PDF gerado, que será exibido ou baixado automaticamente pelo navegador.

Observações:

Este endpoint não tem um modelo de resposta JSON convencional, pois a resposta é um arquivo PDF.
O PDF contém informações detalhadas dos treinos do aluno, organizados por dia da semana.
Em caso de sucesso, o navegador exibirá ou solicitará o download do PDF gerado.
Modelo de Resposta (Falha - Usuário Não Autenticado):

Status: 401 Unauthorized
Corpo da Resposta (JSON):
json

{
  "error": "Usuário não autenticado"
}
Observações:
Em caso de tentativa de acesso sem autenticação.
Modelo de Resposta (Falha - Aluno Não Encontrado ou Sem Permissão):

Status: 403 Forbidden
Corpo da Resposta (JSON):
json

{
  "error": "Você não tem permissão para exportar este aluno"
}

Observações:

Em caso de tentativa de exportar um aluno que não existe ou que não pertence ao usuário autenticado.
Modelo de Resposta (Falha - Outros Erros):

Status: 400 Bad Request
Corpo da Resposta (JSON):
json

{
  "error": "Mensagem de Erro"
}

Observações:

Em caso de outros erros durante o processamento da requisição.


StudentsController - Exibição de Dados Gerados

Método: store (Cadastro de Novo Aluno)
Modelo de Requisição:

Tipo: POST
Endpoint: /api/students
Cabeçalhos: Authorization: Bearer <seu_token_de_autenticação>
Corpo da Requisição (JSON):
json

{
  "name": "Nome do Aluno",
  "email": "email@aluno.com",
  "date_birth": "yyyy-mm-dd",
  "cpf": "123.456.789-01",
  "contact": "(99) 99999-9999",
  "user_id": 1,
  "city": "Nome da Cidade",
  "neighborhood": "Nome do Bairro",
  "number": "Número",
  "street": "Nome da Rua",
  "state": "UF",
  "cep": "12345-6789"
}

Observações:

Certifique-se de substituir os valores de exemplo pelos dados reais do aluno.
Modelo de Resposta (Sucesso):

Status: 201 Created
Corpo da Resposta (JSON):
json

{
  "message": "Aluno cadastrado com sucesso",
  "data": {
    "id": 1,
    "name": "Nome do Aluno",
    "email": "email@aluno.com",
    "date_birth": "yyyy-mm-dd",
    "cpf": "123.456.789-01",
    "contact": "(99) 99999-9999",
    "user_id": 1,
    "city": "Nome da Cidade",
    "neighborhood": "Nome do Bairro",
    "number": "Número",
    "street": "Nome da Rua",
    "state": "UF",
    "cep": "12345-6789"
  }
}

Observações:

A resposta inclui os dados do aluno recém-cadastrado.

Método: index (Listagem de Alunos)

Modelo de Requisição:

Tipo: GET
Endpoint: /api/students
Cabeçalhos: Authorization: Bearer <seu_token_de_autenticação>
Parâmetros de Consulta Opcionais:
name: Filtrar alunos por nome (opcional).
cpf: Filtrar alunos por CPF (opcional).
email: Filtrar alunos por email (opcional).
order: Ordenar resultados por uma coluna específica (opcional).
Modelo de Resposta (Sucesso):

Status: 200 OK
Corpo da Resposta (JSON):
json

[
  {
    "id": 1,
    "name": "Nome do Aluno",
    "email": "email@aluno.com",
    "date_birth": "yyyy-mm-dd",
    "cpf": "123.456.789-01",
    "contact": "(99) 99999-9999",
    "cep": "12345-6789",
    "street": "Nome da Rua",
    "state": "UF",
    "neighborhood": "Nome do Bairro",
    "city": "Nome da Cidade",
    "number": "Número"
  },
  {
    "id": 2,
    "name": "Nome do Aluno2",
    "email": "email2@aluno.com",
    "date_birth": "yyyy-mm-dd",
    "cpf": "123.456.789-01",
    "contact": "(99) 99999-9999",
    "cep": "12345-6789",
    "street": "Nome da Rua2",
    "state": "UF",
    "neighborhood": "Nome do Bairro",
    "city": "Nome da Cidade",
    "number": "Número"
  },
  // ... outros alunos
]

Observações:

A resposta inclui uma lista de alunos com os dados básicos.


Método: update (Atualização de Aluno)
Modelo de Requisição:

Tipo: PUT
Endpoint: /api/students/{id}
Cabeçalhos: Authorization: Bearer <seu_token_de_autenticação>
Parâmetros de Rota:
{id}: ID do aluno a ser atualizado.
Corpo da Requisição (JSON):
json

{
  "name": "Novo Nome do Aluno",
  "email": "novo_email@aluno.com",
  "date_birth": "yyyy-mm-dd",
  "cpf": "111.222.333-44",
  "contact": "(88) 88888-8888",
  "city": "Nova Cidade",
  "neighborhood": "Novo Bairro",
  "number": "Novo Número",
  "street": "Nova Rua",
  "state": "NU",
  "cep": "98765-4321"
}

Observações:

Certifique-se de substituir os valores de exemplo pelos dados reais do aluno a ser atualizado.
Modelo de Resposta (Sucesso):

Status: 200 OK
Corpo da Resposta (JSON):
json

{
  "message": "Aluno atualizado com sucesso",
  "data": {
    "id": 1,
    "name": "Novo Nome do Aluno",
    "email": "novo_email@aluno.com",
    "date_birth": "yyyy-mm-dd",
    "cpf": "111.222.333-44",
    "contact": "(88) 88888-8888",
    "cep": "98765-4321",
    "street": "Nova Rua",
    "state": "NU",
    "neighborhood": "Novo Bairro",
    "city": "Nova Cidade",
    "number": "Novo Número"
  }
}

Observações:

A resposta inclui os dados atualizados do aluno.
Método: show (Exibição de Aluno)
Modelo de Requisição:

Tipo: GET
Endpoint: /api/students/{id} (opcional, se não fornecido, retorna os dados do próprio usuário autenticado)
Cabeçalhos: Authorization: Bearer <seu_token_de_autenticação>
Modelo de Resposta (Sucesso):

Status: 200 OK
Corpo da Resposta (JSON):
json

{
  "id": 1,
  "name": "Nome do Aluno",
  "email": "email@aluno.com",
  "date_birth": "yyyy-mm-dd",
  "cpf": "123.456.789-01",
  "contact": "(99) 99999-9999",
  "cep": "12345-6789",
  "street": "Nome da Rua",
  "state": "UF",
  "neighborhood": "Nome do Bairro",
  "city": "Nome da Cidade",
  "number": "Número"
}

Observações:

A resposta inclui os dados do aluno solicitado.


Método: showWorkoutsStudents (Exibição de Treinos de Aluno)
Modelo de Requisição:

Tipo: GET
Endpoint: /api/students/{id}/workouts
Cabeçalhos: Authorization: Bearer <seu_token_de_autenticação>
Parâmetros de Rota:
{id}: ID do aluno para o qual os treinos devem ser exibidos.
Modelo de Resposta (Sucesso):

Status: 200 OK
Corpo da Resposta (JSON):
json
{
  "student_id": 2,
  "student_name": "Francisco Uberti",
  "workouts": {
    "SEGUNDA": [
      {
        "exercise_description": "Supino",
        "repetitions": 10,
        "weight": "15.60",
        "break_time": 60,
        "observations": null,
        "time": 1
      }
    ],
    "TERÇA": [
      {
        "exercise_description": "Supino",
        "repetitions": 10,
        "weight": "15.60",
        "break_time": 60,
        "observations": null,
        "time": 1
      },
      {
        "exercise_description": "Supino",
        "repetitions": 10,
        "weight": "15.60",
        "break_time": 60,
        "observations": null,
        "time": 1
      }
    ],
    "QUARTA": [
      {
        "exercise_description": "Rosca invertida ",
        "repetitions": 10,
        "weight": "15.60",
        "break_time": 60,
        "observations": null,
        "time": 1
      },
      {
        "exercise_description": "Rosca invertida ",
        "repetitions": 10,
        "weight": "15.60",
        "break_time": 60,
        "observations": null,
        "time": 1
      },
      {
        "exercise_description": "Rosca invertida",
        "repetitions": 10,
        "weight": "15.60",
        "break_time": 60,
        "observations": null,
        "time": 1
      },
      {
        "exercise_description": "Rosca invertida ",
        "repetitions": 10,
        "weight": "15.60",
        "break_time": 60,
        "observations": null,
        "time": 1
      },
      {
        "exercise_description": "Supino",
        "repetitions": 10,
        "weight": "15.60",
        "break_time": 60,
        "observations": null,
        "time": 1
      }
    ],
    "QUINTA": [
      {
        "exercise_description": "Prancha",
        "repetitions": 10,
        "weight": "15.60",
        "break_time": 60,
        "observations": null,
        "time": 1
      },
      {
        "exercise_description": "Corrida estacionaria",
        "repetitions": 10,
        "weight": "15.60",
        "break_time": 60,
        "observations": null,
        "time": 1
      },
      {
        "exercise_description": "Rosca invertida",
        "repetitions": 10,
        "weight": "15.61",
        "break_time": 60,
        "observations": null,
        "time": 1
      },
      {
        "exercise_description": "Supino",
        "repetitions": 10,
        "weight": "15.60",
        "break_time": 60,
        "observations": null,
        "time": 1
      }
    ],
    "SEXTA": [],
    "SABADO": [
      {
        "exercise_description": "Supino",
        "repetitions": 10,
        "weight": "15.60",
        "break_time": 60,
        "observations": null,
        "time": 1
      }
    ],
    "DOMINGO": [
      {
        "exercise_description": "Supino",
        "repetitions": 10,
        "weight": "15.60",
        "break_time": 60,
        "observations": null,
        "time": 1
      }
    ]
  }
}

Observações:
A resposta inclui os treinos organizados por dias da semana para o aluno especificado.

Método: destroy (Exclusão de Aluno)
Modelo de Requisição:

Tipo: DELETE
Endpoint: /api/students/{id}
Cabeçalhos: Authorization: Bearer <seu_token_de_autenticação>
Parâmetros de Rota:
{id}: ID do aluno a ser excluído.
Modelo de Resposta (Sucesso):

Status: 204 No Content
Corpo da Resposta Vazio
Observações:

A resposta indica que o aluno foi excluído com sucesso.


WorkoutController - Exibição de Dados Gerados

Método: store (Cadastro de Novo Treino)
Modelo de Requisição:

Tipo: POST
Endpoint: /api/workouts
Cabeçalhos: Authorization: Bearer <seu_token_de_autenticação>
Corpo da Requisição (JSON):
json

{
  "student_id": 1,
  "exercise_id": 1,
  "repetitions": 10,
  "weight": 20,
  "break_time": 60,
  "day": "SEGUNDA",
  "observations": "Observações sobre o exercício",
  "time": 10
}
Observações:
Certifique-se de substituir os valores de exemplo pelos dados reais do treino.
O campo observations é opcional e pode ser removido se não houver observações.
Modelo de Resposta (Sucesso):

Status: 201 Created
Corpo da Resposta (JSON):
json

{
  "message": "Treino cadastrado com sucesso",
  "data": {
    "workout_id": 1,
    "student_name": "Nome do Aluno",
    "exercise_name": "Nome do Exercício",
    "repetitions": 10,
    "weight": 20,
    "break_time": 60,
    "day": "SEGUNDA",
    "time": 10
  }
}
Observações:
A resposta inclui os dados do treino recém-cadastrado.

Observações Gerais:

Certifique-se de adaptar os nomes dos campos de acordo com a estrutura real do seu banco de dados.
A resposta inclui informações relevantes sobre o treino, como nome do aluno, nome do exercício, repetições, peso, tempo de descanso, dia e hora do treino.


Middleware: ValidateLimitStudentsToUser - Exibição de Dados Gerados

Middleware: ValidateLimitStudentsToUser
Objetivo:
Garantir que o usuário não ultrapasse o limite de estudantes permitido pelo plano.

Observações:

Este middleware é destinado a garantir que um usuário não exceda o número máximo de estudantes permitido pelo plano associado à sua conta.
Dados Gerados:
Cenários:

Usuário Autenticado e Dentro do Limite:

Usuário: Autenticado.
Plano: Associado ao plano 1 (Exemplo: Plano Básico).
Número Atual de Estudantes: Menos de 10.
Modelo de Requisição (Exemplo):
Tipo: POST, PUT, DELETE, ou qualquer tipo de requisição que acione o middleware.
Endpoint: Qualquer endpoint protegido por este middleware.
Modelo de Resposta (Sucesso):
json

{
  "message": "Acesso autorizado. Número de estudantes dentro do limite permitido."
}
Usuário Autenticado e Excedendo o Limite:

Usuário: Autenticado.
Plano: Associado ao plano 1 (Exemplo: Plano Básico).
Número Atual de Estudantes: 10 ou mais.
Modelo de Requisição (Exemplo):
Tipo: POST, PUT, DELETE, ou qualquer tipo de requisição que acione o middleware.
Endpoint: Qualquer endpoint protegido por este middleware.
Modelo de Resposta (Erro):
Status: 403 Forbidden
json

{
  "error": "Limite de cadastro atingido",
  "message": "Você atingiu o limite máximo de estudantes permitidos pelo seu plano."
}
Usuário Não Autenticado:

Usuário: Não autenticado.
Modelo de Requisição (Exemplo):
Tipo: POST, PUT, DELETE, ou qualquer tipo de requisição que acione o middleware.
Endpoint: Qualquer endpoint protegido por este middleware.
Modelo de Resposta (Erro):
Status: 401 Unauthorized
json

{
  "error": "Não autorizado",
  "message": "Você precisa estar autenticado para acessar este recurso."
}

Observações Gerais:

Certifique-se de adaptar os nomes dos campos e as lógicas de autenticação de acordo com a estrutura real do seu aplicativo.
O número máximo de estudantes permitido varia de acordo com o plano associado ao usuário.


Algumas rotas necessitam de autenticação via Sanctum para acesso.

Recomenda-se revisar a documentação dos endpoints para uma compreensão detalhada das requisições e respostas.

Implementar testes automatizados.
Adicionar funcionalidades de busca e filtro nas listagens.
Aprimorar a documentação dos endpoints da API.
Integração com serviços de terceiros, como notificações por e-mail.
Implementar um sistema de notificações para lembretes de treinos.
Desenvolver uma interface administrativa para gestão eficiente.
Melhorar a escalabilidade da aplicação para suportar um maior número de usuários.
Implementar logs para rastrear ações e detectar problemas.
Introduzir um sistema de backups regulares para garantir a segurança dos dados.

Considerações Finais
Esta documentação abrange as principais rotas e funcionalidades da aplicação FitManager, incluindo autenticação de usuário, cadastro, assinatura de plano e obtenção
de informações de assinatura ativa. Certifique-se de ajustar as solicitações e os parâmetros conforme necessário para atender aos requisitos específicos do seu sistema.
Consulte a documentação do Laravel para obter informações detalhadas sobre autenticação, middleware e outras funcionalidades do framework.
