
# CrossTrain

    O CrossTrain surge como uma revolucionária solução de gerenciamento de treinos, projetada sob medida para atender às necessidades exclusivas de academias e profissionais de educação física. Neste artigo, exploraremos em detalhes como o CrossTrain se destaca na otimização do controle e acompanhamento dos treinos de alunos.  


## Descrição do Problema Resolvido

    O CrossTrain visa simplificar e aprimorar a gestão de treinos, fornecendo uma plataforma eficiente para o cadastro de exercícios, planos, alunos e seus respectivos treinos.
    A principal proposta é oferecer uma solução que não apenas organize informações, mas também proporcione uma visão clara do progresso individual de cada aluno.

##  Tecnologias Utilizadas

- Laravel: A escolha do robusto framework PHP Laravel confere ao CrossTrain eficiência e confiabilidade.
- PostgreSQL: Como sistema de gerenciamento de banco de dados relacional, o PostgreSQL assegura uma manipulação eficaz dos dados.
- API REST: A implementação de uma API REST facilita a integração fluida entre o front-end e o back-end do sistema.
- DomPDF: A biblioteca DomPDF é utilizada para a geração de arquivos PDF, agregando valor à documentação do treino.
- Sanctum: Para autenticação via API, o CrossTrain utiliza Sanctum, garantindo segurança no acesso e manipulação de dados.
- Middleware: Implementado para validação e segurança em diversas operações, o uso de -Middleware eleva a integridade do sistema.


## Documentação da API



## 🚀 Como executar o projeto

-Clonar o repositório https://github.com/JoseCnarciso/Projeto_api_academia/

-Criar uma base de dados no PostgreSQL com nome **api_academia**

-Criar um arquivo .env na raiz do projeto com os seguintes parametros:
```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=api_academia
DB_USERNAME=admin
DB_PASSWORD=admin
```

-No prompt de comando executar :
```sh
composer install 
```
-Executar em seguida:
```sh
php artisan serve
```


### 🚥 Endpoints - Rotas Usuário

##
####  S01 - Cadastro de usuário

```http
  POST /api/users
```
Request exemplo:
`/api/users/`
| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :-------------------------------------------------- |
| `id` | `int` | **Autoincremental**.|
| `name` | `string` | **Obrigatório**. Nome completo |
| `email` | `email` | **Obrigatório**. Email, único e válido   |
| `password` | `string` | **Obrigatório**. Senha  |
| `plan_id` | `int` | **Obrigatório**. Id do plano selecionado |
| `cpf` | `string` | **Obrigatório**. CPF, único e válido |
| `date_birth` | `string` | **Obrigatório**. Data de nascimento  |


Body

```http
{
  "name": "José Carlos Narciso",
  "email": "josecdia@hotmail.com",
  "password": "senha123",
  "plan_id": 3,
  "cpf": "123.456.789-01",
  "date_birth": "1990-01-01"
}
```
Return JSON exemplo

```http
{
  "name": "José Carlos Narciso",
  "email": "josecdia@hotmail.com",
  "password": "senha123",
  "plan_id": 3,
  "cpf": "123.456.789-01",
  "date_birth": "1990-01-01"
}

```
| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `201` | sucesso |
|  `400` | campo obrigatório|
|  `409` | email já cadastrado |
|  `409` | CPF já cadastrado |
|  `500` | erro interno |

##
#### S02 - Login do usuário

```http
  POST /api/login
```
Request exemplo:
`/api/login/`
| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `email`      | `email` | **Obrigatório**. Válido |
| `password`      | `string` | **Obrigatório**. Válido |

Body 

```http
{
  "email": "josecdia@hotmail.com",
  "password": "senha123"
}
```

Return JSON exemplo

```http
{
  "message": "Autorizado",
  "status": 201,
  "data": {
    "token": "26|yhRBK4YVyar6jTeYHrdGPk47o8VkawPLOhJXyvUka8f17f49",
    "name": "JOSE"
  }
}
```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `201` | sucesso|
|  `400` | campo obrigatório|
|  `401` | Usuário não autenticado |
|  `500` | erro interno |


##
#### S02 - Logout do usuário

Não é necessario resquest body

Request exemplo: 
`/api/logout/`

Não há resposta no body em caso de sucesso

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `204` | sucesso |
|  `401` | Usuário não autenticado |
|  `500` | erro interno |

##
### 🚥 Endpoints - Rota Dashboard

##
####  S03 - Dashboard

```http
  GET /api/dashboard
```

Request exemplo: 
`/api/dashboard/`

Não é necessario resquest body

Response JSON 

```http
{
  "registered_students": 10,
  "registered_exercises": 25,
  "current_user_plan": "PLANO GOLD",
  "remaining_students": "ILIMITADO"
}
```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `200` | sucesso|
|  `400` | campo obrigatório|
|  `401` | Usuário não autenticado |
|  `500` | erro interno |

##
### 🚥 Endpoints - Rotas Exercícios

##
####  S04 - Cadastro de exercícios

```http
  POST /api/exercises
```
Request exemplo: 
`/api/exercises/`
 Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `id`      | `int` | **Autoincremental**. Chave primaria |
| `description` | `string` | **Obrigatório**. Nome do exercício |
| `user_id` | `int` | **Obrigatório** número inteiro chave primaria do usuario logado |

Body 
```http
{
  "id": 1,
  "description": "Flexão",
  "user_id": 1
}
```

Response JSON 

```http
{
  "id": 1,
  "description": "Flexão",
  "user_id": 1
}
```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `200` | sucesso|
|  `400` | campo obrigatório|
|  `401` | Usuário não autenticado |
|  `403` | O usuário logado não corresponde ao user_id fornecido |
|  `409` | Exercício ja foi cadastrado |
|  `500` | erro interno |

##
####  S05 - Listagem de exercícios

```http
  GET /api/exercises
```
Opcionalmente pode ser utilizado no patch um query param informando: o nome do 
exercicio cadastrado

Request exemplo:
`/api/exercises?description=Abdominal`
 Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `description`      | `string` | Nome do exercicio cadastrado |

Response JSON 

```http  
{
    "id": 2,
    "description": "Abdominal",
    "user_id": 1
}

```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `200` | sucesso|
|  `400` | erro não identificado |
|  `401` | Usuário não autenticado |
|  `500` | erro interno |

##
#### S06 - Exclusão de exercício

```http
  DELETE /api/exercises/:id
```
Não é necessario resquest body

Request exemplo:
`/api/exercises/1`
| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `id` | `int` | **Obrigatório** número inteiro chave primaria|

Não há response no body em caso de sucesso


| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `204` | sucesso|
|  `401` | Usuário não autenticado |
|  `404` | ID não encotrado |
|  `500` | erro interno |

##
### 🚥 Endpoints ExportPdf

##
#### S06 -Exportar pdf de treinos da semana do aluno

```http
  GET /api/students/:id/workouts/
```

Request exemplo:
`/api/students/2/workouts/`

Não é necessario resquest body

Request exemplo:
`//api/students/2/workouts/`
| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `student_id` | `int` | **Obrigatório** número inteiro chave primaria|

##
Response

`
 Lista de exercícios para a semana

        Nome: SAMANTA


         SEGUNDA
    | Exercício | Repetições | Peso | Tempo de descanso | Observações | Tempo | Feito?
    |  Esteira  |     10     |15.61 |        60         |     N/A     |    1  |  ☐

        TERÇA
    | Exercício | Repetições | Peso | Tempo de descanso | Observações | Tempo | Feito?
    |  Flexão   |     10     |15.61 |        60         |     N/A     |    1  |  ☐         
    
        QUARTA
    | Exercício | Repetições | Peso | Tempo de descanso | Observações | Tempo | Feito?
    |  Flexão   |     10     |15.61 |        60         |     N/A     |    1  |  ☐
   

        QUINTA
    | Não há treinos para este dia.
    
        SEXTA        
    | Exercício | Repetições | Peso | Tempo de descanso | Observações | Tempo | Feito?
    |  Esteira  |     10     |15.61 |        60         |     N/A     |    1  |  ☐

        SABADO
    | Não há treinos para este dia.
    
        DOMINGO
    | Não há treinos para este dia.
`


| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `204` | sucesso|
|  `400` | campo obrigatório|
|  `401` | Usuário não autenticado |
|  `404` | ID não encontrado |
|  `500` | erro interno |

##
#### S07 -Cadastrar novo aluno

```http
  POST /api/students/
```
Request exemplo:
`/api/students/`
 Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `id`      | `int` | **Autoincremental**. Chave primaria |
| `name` | `string` | **Obrigatório**. Nome do aluno |
| `email` | `email` | **Obrigatório**. Email válido e unico |
| `date_birth` | `date` | **Obrigatório**. Data de nascimento |
| `cpf` | `string` | **Obrigatório**. CPF válido e unico |
| `contact` | `string` | **Obrigatório**. Telefone válido  |
| `user_id` | `int` | **Obrigatório** Número inteiro chave primaria do usuario logado |
| `city` | `string` | **Opcional**. Nome da cidade  |
| `neighborhood` | `string` | **Opcional**. Nome do bairro  |
| `number` | `string` | **Opcional**. Número da casa  |
| `street` | `string` | **Opcional**. Nome da rua  |
| `state` | `string` | **Opcional**. Nome do estado  |
| `cep` | `string` | **Opcional**. Número do cep da rua, Válido  |


Body

```http
  {
  "name": "Juliana Bastiana",
  "email": "juliana@banana.com",
  "date_birth": "1993-08-21",
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
```

Response JSON 

```http
  {
  "message": "Aluno cadastrado com sucesso",
  "data":{
        "id": 1,
        "name": "Juliana Bastiana",
        "email": "juliana@banana.com",
        "date_birth": "1993-08-21",
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

```
| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `201` | sucesso|
|  `400` | campo obrigatório|
|  `401` | Usuário não autenticado |
|  `409` | Email já cadastrado|
|  `409` | CPF já cadastrado|
|  `500` | erro interno|


##
#### S08 - Busca de alunos cadastrados
```http
  GET /api/students?name=nome_aluno
```
Opcionalmente pode ser utilizado no patch um query param informando: 
name: Filtrar alunos por nome (opcional).
cpf: Filtrar alunos por CPF (opcional).
email: Filtrar alunos por email (opcional).
Caso não seja informado nenhuma query param retornará a lista de todos os alunos cadastrado pelo usuário logado

Request exemplo:
`/api/students/?name=Juliana`
| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `name` | `string` | **opcional** Nome do aluno cadstrado|

Response JSON

```http
{
    "id": 1,
    "name": "Juliana Bastiana",
    "email": "juliana@banana.com",
    "date_birth": "1993-08-21",
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
```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `201` | sucesso|
|  `400` | campo obrigatório|
|  `401` | Usuário não autenticado |
|  `500` | erro interno|


##
#### S09 - Atualização de dados de aluno

```http
  PUT /api/students/:id
```

Request exemplo:
`/api/students/19`
 Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `name` | `string` | Nome do aluno |
| `email` | `email` | Email válido e unico |
| `date_birth` | `date` | Data de nascimento |
| `cpf` | `string` | CPF válido e unico |
| `contact` | `string` | Telefone válido  |
| `user_id` | `int` | **Obrigatório** Número inteiro chave primaria do usuario logado |
| `city` | `string` | Nome da cidade  |
| `neighborhood` | `string` | Nome do bairro  |
| `number` | `string` | Número da casa  |
| `street` | `string` | Nome da rua  |
| `state` | `string` | Nome do estado  |
| `cep` | `string` | Número do cep da rua, Válido  |

Body
```http
{       
    "name": "Francisco Uberti Narciso",
    "email": "francisco_narciso@hotmail.com",
    "date_birth": "1993-08-23",
    "cpf": "123.456.789-01",
    "contact": "(99) 99912-3214",
    "user_id": 1,
    "city": "Concórdia",
    "neighborhood": "Arvoredo",
    "number": "284",
    "street": "Luis Santi",
    "state": "SC",
    "cep": "12345-6789"
}
```


Response JSON

```http
{   "message": "Aluno atualizado com sucesso",
    "status": 200,
    "data":{
        "id": 19,
        "name": "Francisco Uberti Narciso",
        "email": "francisco_uberti@hotmail.com",
        "date_birth": "1993-08-23",
        "cpf": "123.456.789-10",
        "contact": "(49) 12345-6789",
        "user_id": 1,
        "city": "Concórdia",
        "neighborhood": "Arvoredo",
        "number": "284",
        "street": "Luis Santi",
        "state": "SC",
        "cep": "89701-402"
    }
}
```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `200` | sucesso|
|  `400` | campo obrigatório|
|  `401` | Usuário não autenticado |
|  `404` | Estudante não encontrado |
|  `500` | erro interno|


##
#### S10 - Busca de alunos cadastrados por ID


```http
   GET /api/students/:id
```

Request exemplo:
`/api/students/15`
| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `id` | `int` | **Obrigátorio**, inteiro e válido|

Response JSON
```http
{    
    "id": 15,
    "name": "Francisco Uberti Narciso",
    "email": "francisco_uberti@hotmail.com",
    "date_birth": "1993-08-23",
    "cpf": "123.456.789-10",
    "contact": "(49) 12345-6789",
    "user_id": 1,
    "city": "Concórdia",
    "neighborhood": "Arvoredo",
    "number": "284",
    "street": "Luis Santi",
    "state": "SC",
    "cep": "89701-402"
}
```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `200` | sucesso|
|  `400` | campo obrigatório|
|  `401` | Usuário não autenticado |
|  `404` | Estudante não encontrado |
|  `500` | erro interno |


##
#### S11 - Exclusão de aluno  por ID


```http
   DELETE /api/students/:id
```
Não é necessario resquest body

Request exemplo:
`/api/students/1`
| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `id` | `int` | **Obrigatório** número inteiro chave primaria|

Não há response no body em caso de sucesso


| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `204` | sucesso|
|  `400` | campo obrigatório|
|  `401` | Usuário não autenticado |
|  `404` | Estudante não encontrado |
|  `500` | erro interno |


##
#### S12 - Cadastro de treinos do aluno

```http
   POST /api/workouts/
```

Request exemplo:
`/api/workouts/`
| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `student_id`      | `int` | **Obrigatório**. Número inteiro chave primaria|
| `exercise_id`      | `int` | **Obrigatório**. Número inteiro chave primaria|
| `repetitions` | `integer` | **Obrigatório**. Quantidade de repetiçoes|
| `weight` | `numeric` | **Obrigatório**. Peso |
| `day` | `string` | **Obrigatório**. Valores: 'SEGUNDA', 'TERÇA', 'QUARTA', 'QUINTA', 'SEXTA', 'SABADO', 'DOMINGO' |
| `observations` | `string` |  Personalização de algum exercício |
| `time` | `integer` | **Obrigatório**. Tempo de descanso |


Body
```http   
{
  "student_id": 1,
  "exercise_id": 1,
  "repetitions": 10,
  "weight": 20.5,
  "break_time": 60,
  "day": "SEGUNDA",
  "observations": "Observações sobre o exercício",
  "time": 10
}
```

Response JSON

```http  
{
  "message": "Treino cadastrado com sucesso",
  "data": {
    "workout_id": 1,
    "student_name": "Nome do Aluno",
    "exercise_name": "Nome do Exercício",
    "repetitions": 10,
    "weight": 20.5,
    "break_time": 60,
    "day": "SEGUNDA",
    "observations": "Observações sobre o exercício",
    "time": 10
  }
}
```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `204` | sucesso|
|  `400` | campo obrigatório|
|  `401` | Usuário não autenticado |
|  `401` | Usuário não autorizado para cadastrar treinos para este aluno |
|  `401` | Usuário não autorizado para cadastrar treinos com este exercício |
|  `404` | Estudante não encontrado |
|  `409` | Este exercício já foi cadastrado para o estudante neste dia |
|  `500` | erro interno |




## Autor

- [@joseCnarciso](https://github.com/JoseCnarciso/)

