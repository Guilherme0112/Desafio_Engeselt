
# Desafio Engeselt

Este é um projeto de um **marketplace de confeitarias**, onde é possível:
- Cadastrar confeitarias e seus produtos.
- Realizar login (apenas usuários autenticados podem criar, editar e excluir confeitarias e produtos).

O projeto foi desenvolvido utilizando **Laravel** (back-end) e **Vue.js** (front-end) com **Inertia.js** para comunicação entre as camadas.

---

## Tecnologias utilizadas (Windows)

- **Node.js**: [22.14.0](https://nodejs.org/pt/blog/release/v22.14.0)
- **PHP**: [8.4.6](https://windows.php.net/downloads/releases/php-8.4.6-Win32-vs17-x64.zip)
- **Composer**: [2.8.8](https://getcomposer.org/Composer-Setup.exe)
- **PostgreSQL**: [17.4](https://www.enterprisedb.com/downloads/postgres-postgresql-downloads)

---

## Estrutura do Projeto

```
/project-root
  ├── app/
  |     ├── Http/
  |     |   ├── Services/      # Regra de negócio do sistema
  |     |   ├── Controllers/   # Controladores do sistema
  |     ├── Models/            # Modelo das entidades
  ├── bootstrap/
  ├── config/             # Configurações do projeto
  ├── database/           # Migrations
  ├── public/     
  ├── resources/
  │   ├── assets/          # Imagens utilizadas pelo sistema
  │   ├── css/             # Estilo do site
  │   ├── js/
  │   │   ├── Layouts/     # Layouts para partes do projeto (Padrão do laravel)
  │   │   ├── Pages/       # Páginas do Vue.js
  │   │   ├── Components/  # Componentes Vue.js
  │   │   ├── Scripts/     # Códigos em JavaScript
  │   └── views/           # View blade (Template raiz)
  ├── routes/
  │   └── web.php          # Rotas principais
  │   └── auth.php         # Rotas para autenticação (Padrão do Breeze)
  ├── storage/
  │   └── app/       
  │       └── public/         
  │           └── products/    # Uploads das imagens dos produtos      
  ├── tests/
  ├── package.json        # Dependências Node.js
  ├── composer.json       # Dependências PHP
  ├── vite.config.js      # Configuração do Vite
  └── README.md
```

---


---

## Como rodar o projeto

1. Clone o repositório:
```bash
git clone https://github.com/Guilherme0112/Desafio_Engeselt.git
cd Desafio_Engeselt
```

2. Instale as dependências do PHP com o Composer:
```bash
composer install
```

3. Instale as dependências do Node.js com o npm:
```bash
npm install
```

4. Crie o arquivo `.env` baseado no `.env.example`:
```bash
cp .env.example .env
```

5. Configure a conexão com o banco de dados PostgreSQL no arquivo `.env`.

6. Gere a chave da aplicação Laravel:
```bash
php artisan key:generate
```

7. Execute as migrations:
```bash
php artisan migrate
```

8. Em outro terminal, suba o front-end:
```bash
npm run dev
```

9. Rode o servidor de desenvolvimento:
```bash
php artisan serve
```

---

## Atenção: configurações no php.ini

Caso ocorra erros relacionados a extensões, **remova os comentários** (descomente) no seu `php.ini` das seguintes linhas:

```
extension=pdo_pgsql
extension=pgsql
extension=fileinfo
extension=zip
```

---

## Observação
Certifique-se de que todas as tecnologias listadas estão instaladas nas versões corretas para evitar problemas de compatibilidade.
