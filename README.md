# YPG API

Projeto utilizando:
- Docker
- Laravel Lumen
- Swoole

Levantando o servidor:
php:
- php -S 0.0.0.0:3000 -t public

Swoole:
- php artisan swoole:http start
-- O host e a porta usados pelo swoole estão no .env.example

Obs: O comando deve ser rodado dentro da pasta api
