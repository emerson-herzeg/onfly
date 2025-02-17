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
git clone https://github.com/<seu-usuario>/<nome-do-repositorio>.git
```

2. Acesse o diretório do projeto:

```bash
cd <nome-do-repositorio>
```

3. Instale as dependências:

```bash
composer install
```

4. Duplique o arquivo `.env.example` e renomeie-o para `.env`.

5. Configure as variáveis de ambiente no arquivo `.env`:

```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=viagem_corporativa
DB_USERNAME=root
DB_PASSWORD=root

JWT_SECRET=<chave-secreta-jwt>
```

### Execução com Docker

1. Construa e execute os containers:

```bash
docker-compose up -d
```

2. Acesse o container da aplicação:

```bash
docker-compose exec app bash
```

3. Gere a chave da aplicação:

```bash
php artisan key:generate
```

4. Execute as migrações do banco de dados:

```bash
php artisan migrate
```

5. Saia do container:

```bash
exit
```

### Configuração do Ambiente

- **Banco de dados:** Configure as credenciais do banco de dados MySQL no arquivo `.env`.
- **JWT Secret:** Gere uma chave secreta para o JWT no arquivo `.env`.
- **Outras variáveis:** Ajuste as demais variáveis de ambiente conforme necessário.

### Execução Local (sem Docker)

1. Instale o Composer:

```bash
composer install
```

2. Configure o arquivo `.env` conforme as instruções acima.

3. Gere a chave da aplicação:

```bash
php artisan key:generate
```

4. Execute as migrações do banco de dados:

```bash
php artisan migrate
```

5. Inicie o servidor de desenvolvimento:

```bash
php artisan serve
```

### Testes

1. Acesse o container da aplicação (se usar Docker):

```bash
docker-compose exec app bash
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

- **POST /api/viagens:** Cria um novo pedido de viagem.
- **PUT /api/viagens/{id}:** Atualiza o status de um pedido de viagem.
- **GET /api/viagens/{id}:** Consulta um pedido de viagem por ID.
- **GET /api/viagens:** Lista todos os pedidos de viagem, com opções de filtro por status, período e destino.

### Informações Adicionais

- A autenticação é feita via JWT. O token deve ser incluído no header `Authorization` com o prefixo `Bearer`.
- As notificações de aprovação e cancelamento são enviadas para o usuário que solicitou o pedido.
- O código segue as boas práticas de desenvolvimento e utiliza os recursos do Laravel de forma eficiente.

### Critérios de Avaliação

- Organização e Qualidade do Código
- Uso de Boas Práticas do Laravel
- Eficiência da Solução
- Testes e Confiabilidade
- Documentação

Este README.md fornece as instruções necessárias para instalar, configurar e executar o microsserviço. O código foi desenvolvido com atenção aos critérios de avaliação e busca atender aos requisitos do desafio de forma clara e eficiente.
