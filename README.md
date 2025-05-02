# Projeto Sistemas de vendas PHP / Laravel com Vue.js e MySQL

Este guia descreve como configurar o ambiente para o Laravel com Vue.js e MySQL, usando Docker para gerenciar os contêineres.

## Passo a Passo para Configuração do Projeto

### **1. Clone o repositório:**

```
git clone git@github.com:fffilipi/sistema-vendas.git
```

### **2. Suba os containers Docker**

Suba os contêineres necessários (com a opção --build para garantir que as imagens sejam construídas corretamente e -d para rodar em segundo plano):

```
cd backend
```

```
docker-compose up --build -d
```

### **3. Instale as dependências do Laravel (dentro do contêiner)**
Acesse o contêiner do Laravel e instale as dependências do Composer:

```
docker-compose exec app bash
```

```
composer install
```

```
exit
```

### **4. Configure o banco de dados**
Acesse a pasta backend

```
cd backend
```

```
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

Gere a chave da aplicação e rode as migrations ja com os seeders para os dados ficticios:

```
docker-compose exec app bash
```

```
php artisan key:generate
```

```
php artisan migrate --seed
```

### **5. Instale as dependências do Vue.js e execute o projeto**

```
cd frontend
```

```
npm install
```

## Configure o .env do front

Indique a URL base do seu back para consumo do frontend

```
cp .env.example .env
```

## Execute o projeto

```
npm run dev
```

### Acesse a aplicação

http://localhost:5173/

### Documentação API

https://documenter.getpostman.com/view/43541147/2sAYkLoHo7

### Documentação de desenvolvimento

https://drive.google.com/file/d/1XKkcHQS1DVgkYG6rAHdgWJ18X-MXa578/view?usp=drive_link

## Resultado

https://github.com/user-attachments/assets/ade6a0b3-4183-45b7-8b49-f2acb19fa01b
