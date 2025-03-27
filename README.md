# Projeto Sistemas de vendas PHP / Laravel com Vue.js e MySQL

Este guia descreve como configurar o ambiente para o Laravel com Vue.js e MySQL, usando Docker para gerenciar os contêineres.

## Passo a Passo para Configuração do Projeto

### **1. Clone o repositório:**

```
git clone git@github.com:fffilipi/sistema-vendas.git
```

### **2. Acesse a pasta do projeto**

```
cd sistema-vendas
```

### **3. Suba os containers Docker**

Suba os contêineres necessários (com a opção --build para garantir que as imagens sejam construídas corretamente e -d para rodar em segundo plano):

```
docker-compose up --build -d
```

### **4. Instale as dependências do Laravel (dentro do contêiner)**
Acesse o contêiner do Laravel e instale as dependências do Composer:

```
docker-compose exec app bash
composer install
```

### **5. Configure o banco de dados**
Acesse a pasta backend

```
cd backend
cp .env.example .env
```

Edite .env e configure o banco de dados:

```
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=sistema_vendas
DB_USERNAME=user
DB_PASSWORD=secret
```

Gere a chave da aplicação e rode as migrations:

```
docker-compose exec app bash
php artisan key:generate
php artisan migrate
```

### **6. Instale as dependências do Vue.js e execute o projeto**

```
cd frontend
npm install
npm run dev
```

### Acesse a pagina do front pela porta 5173

http://localhost:5173/


## Criando dados ficticios para testar a aplicação


```
php artisan db:seed
```

