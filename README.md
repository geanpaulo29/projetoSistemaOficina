# 🛠️ Sistema de Gerenciamento de Oficina Mecânica

Este sistema foi desenvolvido para melhorar a organização de serviços em oficinas mecânicas, permitindo o controle detalhado de clientes, veículos, ordens de serviço e relatórios de faturamento. Foi pensado para funcionar **offline**, ideal para oficinas sem conexão estável com a internet.
    
## 🚀 Tecnologias Utilizadas

- Laravel
- Docker com Laradock (recomendado)
- XAMPP (alternativa local)
- PHP, MySQL
- Composer
- Node.js (opcional, para assets)

---

## 📦 Instalação com Laradock (Recomendado)

### 1. Clonar o projeto
```bash
git clone https://github.com/geanpaulo29/projetoSistemaOficina.git
cd projetoSistemaOficina
```

### 2. Clonar e configurar o Laradock
```bash
git clone https://github.com/laradock/laradock.git
cd laradock
cp env-example .env
```

### 3. Editar `.env` do Laradock
```ini
APP_CODE_PATH_HOST=../sistema-oficina
MYSQL_VERSION=latest
MYSQL_DATABASE=oficinadb
MYSQL_USER=default
MYSQL_PASSWORD=secret
MYSQL_ROOT_PASSWORD=root
```

### 4. Subir os containers
```bash
docker-compose up -d nginx mysql phpmyadmin workspace
```

### 5. Acessar o container
```bash
docker-compose exec workspace bash
```

### 6. Instalar dependências do Laravel
```bash
composer install
cp .env.example .env
php artisan key:generate
```

### 7. Configurar banco de dados no `.env`
```ini
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=oficinadb
DB_USERNAME=default
DB_PASSWORD=secret
```

### 8. Rodar migrações e seeders
```bash
php artisan migrate --seed
```

### 9. Acessar o sistema

- Sistema: http://localhost  
- PHPMyAdmin: http://localhost:8080

---

## 💻 Instalação com XAMPP

### 1. Clonar o projeto
```bash
git clone https://github.com/geanpaulo29/projetoSistemaOficina.git
cd projetoSistemaOficina
```

### 2. Mover para `htdocs`
Copie a pasta do projeto para `C:\xampp\htdocs\`.

### 3. Criar banco de dados
Acesse http://localhost/phpmyadmin e crie o banco `oficinadb`.

### 4. Instalar dependências
```bash
composer install
cp .env.example .env
```

### 5. Configurar `.env`
```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=oficina
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Gerar chave e migrar
```bash
php artisan key:generate
php artisan migrate --seed
```

### 7. (Opcional) Configurar Virtual Host

#### httpd-vhosts.conf
```apache
<VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs/sistema-oficina/public"
    ServerName oficina.test
    <Directory "C:/xampp/htdocs/sistema-oficina">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

#### Hosts do Windows
Adicione no arquivo `C:\Windows\System32\drivers\etc\hosts`:
```
127.0.0.1   oficina.test
```

### 8. Acessar o sistema

- http://localhost/sistema-oficina/public  
- ou http://oficina.test (se usar virtual host)

---

## 🔑 Primeiro Acesso

Acesse com:

- **Email:** `admin@oficina.com`  
- **Senha:** `password`

---

## 💡 Dicas de Desenvolvimento

### Laradock
- Parar containers:  
  ```bash
  docker-compose down
  ```

- Ver logs:  
  ```bash
  docker-compose logs nginx
  ```

### XAMPP
- Limpar cache:  
  ```bash
  php artisan cache:clear
  ```

- Gerar assets (opcional):  
  ```bash
  npm install
  npm run dev
  ```

---

## 🧩 Solução de Problemas

### Laradock
- **Portas ocupadas:**  
  Altere as portas no `.env` do Laradock

- **Permissões:**  
  ```bash
  chmod -R 777 storage bootstrap/cache
  ```

### XAMPP
- **Apache não inicia:**  
  Verifique se a porta 80 não está sendo usada por outro serviço

- **Erro em migrações:**  
  ```bash
  php artisan migrate:fresh --seed
  ```

---
