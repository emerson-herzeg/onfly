## Microsserviço de Gerenciamento de Pedidos de Viagem Corporativa (Onfly)

Este repositório contém um microsserviço desenvolvido em Laravel para gerenciar pedidos de viagem corporativa. O serviço expõe uma API RESTful para as operações de criação, atualização, consulta e listagem de pedidos, além de implementar funcionalidades de cancelamento, filtragem e notificação.

### Requisitos

- PHP >= 8.1
- Composer
- MySQL
- Docker
- Docker Compose

### Instalação

1. Clone este repositório:

```bash
git clone https://github.com/emerson-herzeg/onfly.git 
```

2. Acesse o diretório do projeto:

```bash
cd onfly/src
```

3. Instale as dependências:

```bash
composer install
```

4. Duplique o arquivo `.env.example` e renomeie-o para `.env`.

5. Configure as variáveis de ambiente no arquivo `.env`:

```
DB_CONNECTION=mysql
DB_HOST=onfly-mysql-1
DB_PORT=3306
DB_DATABASE=onfly
DB_USERNAME=onfly
DB_PASSWORD=#oNf!8i

JWT_SECRET=WrPVKPvHQBWBweYOrNn1a2LfCxWvjhJGWETksoLl3AgGD2pPLZAIvfns1OkLYw18
```

### Execução com Docker

1. Construa e execute os containers:

```bash
docker-compose up -d
```

2. Acesse o container da aplicação:

```bash
docker-compose exec web bash
```

3. Gere a chave da aplicação:

```bash
php artisan key:generate
```

4. Execute as migrações do banco de dados:

```bash
php artisan migrate
```


5. Execute seed :

```bash
php artisan db:seed
```
Os seguintes usuários serão criados:
- Usuário: test1@test.com
- Senha: password1

- Usuário: test2@test.com
- Senha: password2

### Testes

1. Acesse o container da aplicação (se usar Docker):

```bash
docker-compose exec web bash
```

2. Execute os testes:

```bash
php artisan test
```

3. Saia do container:

```bash
exit
```

### Documentação da API

A API RESTful está disponível na rota `/api`. Abaixo estão os endpoints disponíveis:

- **POST /api/travel-order:** Cria um novo pedido de viagem.
- **POST /api/travel-order/{id}:** Atualiza o status de um pedido de viagem.
- **GET /api/travel-order/{id}:** Consulta um pedido de viagem por ID.
- **GET /api/travel-order:** Lista todos os pedidos de viagem, com opções de filtro por status, período e destino.

### Informações Adicionais

- A autenticação é feita via JWT. O token deve ser incluído no header `Authorization` com o prefixo `Bearer`.
- As notificações de aprovação e cancelamento são enviadas para o usuário que solicitou o pedido.
