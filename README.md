# Time to Exchange

В рамках репозитория присутствуют два проекта:

- api
- backend

## Быстрая настройка (через docker-compose)

```shell
# init Yii env
./init --env=Development --overwrite=yes

# define variables
cp .env.example backend/web/.env
cp .env.example api/web/.env

# run docker-compose
docker-compose up api backend

# access services
curl http://localhost:8014/ # -> api
curl http://localhost:8015/ # -> backend
```


## Инфраструктура

Развернуто 2 окружения - **dev** и **prod**. Каждое из окружений запущено на отдельном сервере. Также на отдельном сервере поднята БД MySQL.

- **dev**-среда:  dev.time-to-exchange.ru, web.dev.time-to-exchange.ru, api.dev.time-to-exchange.ru
- **prod**-среда: prod.time-to-exchange.ru, web.prod.time-to-exchange.ru, api.prod.time-to-exchange.ru, web.time-to-exchange.ru, api.time-to-exchange.ru
- **MySQL DB**: 94.228.113.169

На DB подняты две логические базы для подключения разных сред:

- **time-to-exchange-dev** - БД для теста
- **time-to-exchange-prod** - БД для промышленной среды


### Настройка инфраструктуры

Хосты настраиваются также с помощью Ansible. Инвентарь находится по пути `ansible/inventory`

Для всех хостов предварительно были применены playbook-и:

- `ansible/configure_node.yml`

На `dev.time-to-exchange.ru` также запущен GitLab Runner:

- `ansible/configure_gitlab_runner.yml`

БД также сконфигурирована с помощью Ansible. 
- `ansible/configure_db.yml`

Данные логинов и паролей зашифрованы в файле `ansible/inventory/db/host_vars/time-to-exchange-db-1/mysql_users` (для расшифровки понадобится ключ Ansible Vault).

### CI/CD

Деплой осуществляется с помощью Ansible. Используется playbook `ansible/time-to-exchange.yml`. Используются публичные Ansible-роли, а также часть собственных (`playbook/roles`, `ansible/roles`). В процессе CI/CD дополнительные роли устанавливаются из файла `ansible/requirements.yml`.


### Работа с репозиторием

Используются две активные ветки:

- `development` - синхронизация dev-среды. При коммите в ветку `development` автоматически будет запущен процесс сихнронизации dev-ветки.
- `main` - синхронизация prod-среды. При коммите в ветку `main` автоматически будет запущен процесс сихнронизации prod-ветки.

То есть для обновления dev-среды вам необходимо выполнить Merge в ветку `development`. Аналогично и для промышленной среде.

Также данные ветки являются Protected, удаление и изменение кодовой базы в ветках ограничено Maintainer-ами проекта.

При создании веток и работе с репозиторием рекомендуется придерживаться правил наименования [GitFlow](https://nvie.com/posts/a-successful-git-branching-model/). Примеры названий.

- feat/auth
- fix/bug
- feat/ISSUE-231
- release/v1.23

## Конфигурация сервисов

### Переменные окружения

- Для API - `/var/www/html/time_to_exchange_backend/api/web/.env`
- Для Backend - `/var/www/html/time_to_exchange_backend/backend/web/.env`

Данные пути добавлены в правило `deny all` на Nginx, поэтому напрямую скачать из интернета эти файлы не удастся.

## Yii template

<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Advanced Project Template</h1>
    <br>
</p>

Yii 2 Advanced Project Template is a skeleton [Yii 2](http://www.yiiframework.com/) application best for
developing complex Web applications with multiple tiers.

The template includes three tiers: front end, back end, and console, each of which
is a separate Yii application.

The template is designed to work in a team development environment. It supports
deploying the application in different environments.

Documentation is at [docs/guide/README.md](docs/guide/README.md).

[![Latest Stable Version](https://img.shields.io/packagist/v/yiisoft/yii2-app-advanced.svg)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Total Downloads](https://img.shields.io/packagist/dt/yiisoft/yii2-app-advanced.svg)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![build](https://github.com/yiisoft/yii2-app-advanced/workflows/build/badge.svg)](https://github.com/yiisoft/yii2-app-advanced/actions?query=workflow%3Abuild)

DIRECTORY STRUCTURE
-------------------

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
    tests/               contains tests for common classes    
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for backend application    
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for frontend application
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
```
