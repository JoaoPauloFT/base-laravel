# base laravel
 Base em laravel para futuros projetos

## Pré-requisitos

- Ter o PHP na versão 8.2 ou superior.
- Ter o composer instalado e atualizado.
Obs.: para atualizar o composer utilize o código abaixo:
```sh
composer self-update
```

## Instalação da Base

1. Rode o código abaixo para baixar as dependências do PHP:
```sh
composer install
```

2. Crie o arquivo ".env" com base no arquivo ".env.example"


3. Altere as variáveis abaixo de acordo com a necessidade:
- APP_NAME = Incluindo o nome da aplicação. Ex.: Base
- APP_URL = Incluindo a URL usada para acessar a aplicação. Ex.: http://localhost/base-laravel
- DB_CONNECTION = Incluindo qual o banco a ser usado. Ex.: mysql
- DB_HOST = Incluindo o hostname do servidor do banco de dados. Ex.: 127.0.0.1
- DB_PORT = Incluindo a porta do servidor do banco de dados. Ex.: 3306
- DB_DATABASE = Incluindo o nome do banco de dados. Ex.: base
- DB_USERNAME = Incluindo o usuário do banco de dados. Ex.: root
- DB_PASSWORD = Incluindo a senha do usuário do banco de dados. Ex.: ********


4. Rode o código abaixo para gerar a key do projeto:
```sh
php artisan key:generate
```

5. Certique que o banco informado no ".env" está criado.


6. Rode as migrations padrões da base:
```sh
php artisan migrate
```

7. Rode as seeders padrões da base:
```sh
php artisan db:seed
```

8. Acesse o link da aplicação de acordo com o APP_URL.


9. Tente realizar o login com as credenciais abaixo:
```
Email: admin@admin.com
Senha: admin123
```
