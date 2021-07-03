## Dockerized blog

Dockerized blog consist of both backend and frontend created using Laravel, Tailwind, Nuxt and MySQL. This project is a combination of following 3 projects.

[Nuxt blog client](https://github.com/Yrol/blog-client)
[Laravel blog backend](https://github.com/Yrol/Laravel-nuxt-blog)
[Dockerized template for Laravel and NUXT](https://github.com/Yrol/Docker-Laravel-Nuxt)

## Features

Once the project is [set up](#installation) successfully, you should be able to use the following features.

- Articles

  - View all articles: [http://localhost:8080/](http://localhost:8080/)
  - View a single article: `http://localhost:8080/posts/<article-name>`
  - Pagination:
  - View articles by category: `http://localhost:8080/categories/<category-name>`

- Categories

  - View all categories: [http://localhost:8080/categories/](http://localhost:8080/categories/)

- User login: [http://localhost:8080/mystery](http://localhost:8080/mystery)
  The seedings (`db-seed` run during installation) will add mock users to the DB and the default password for each user is "password". For instance, you should be able login using the credentials as below.

  ```
  email: winfield12@example.net
  password: password
  ```

- Main admin panel: [http://localhost:8080/admin](http://localhost:8080/admin)

  - View all posts: [http://localhost:8080/admin/posts/page/1](http://localhost:8080/admin/posts/page/1)
  - View all categories: [http://localhost:8080/admin/categories](http://localhost:8080/admin/categories)

- Articles (Admin)

  - Add new article: [http://localhost:8080/admin/new-post](http://localhost:8080/admin/new-post)
  - Edit article: Option available via each article card.
  - Delete article: Option available via each article card.
  - Unpublish article: Option available through each article card.

- Categories (Admin)

  - Add, Edit and Delete categories: [http://localhost:8080/admin/categories](http://localhost:8080/admin/categories)

- Settings: [http://localhost:8080/admin/settings](http://localhost:8080/admin/settings)
  This will allow you to add Key & Value pairs that can be used across the application. For instance, we can use the credentials like below to upload images to [https://imgur.com/](imgur) via its APIs (currently being used in `ImageUploadController.php`).
  ```
  Key: imgur
  Value: cd6b3f7821exyz
  ```

## Outline

This build consist of following.

- [Stack](#stack)
- [Layout](#layout)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Usage](#usage)
- [Environment](#environment)
- [Nuxt](#nuxt)
  - [Requests](#requests)
  - [Dependencies](#dependencies)
- [Laravel](#laravel)
  - [Artisan](#artisan)
  - [File storage](#file-storage)
- [Makefile](#makefile)
- [Aliases](#aliases)
- [Database](#database)
- [Redis](#redis)
- [Mailhog](#mailhog)
- [MailTrap](#mailtrap)
- [Logs](#logs)
- [Running commands](#running-commands-from-containers)

## Stack

- Laravel - 7.26.1
- Nuxt.JS - 2.14.0
- MySQL - Ver 14.14 Distrib 5.7.29
- Nginx 1.18.0
- Redis 6.2
- Supervisor (queues, schedule commands & etc)
- Mailhog (SMTP testing)

## Layout

Both Laravel and Nuxt projects are completely decoupled from each other. Therefore, the projects can be maintained individually.

## Prerequisites

- Docker
- Make tool

## Installation

**1. Clone or download the repository and enter the project directory**

```
git clone git@github.com:Yrol/dockerized-blog.git
cd app
```

**2. Run the installation script (this might take a while depending on network)**

```
make install
```

**3. Once the above commands are executed successfully, the Laravel and Nuxt projects can be accessed using the follow URLs**

Laravel - [http://localhost:8081](http://localhost:8081)

Nuxt - [http://localhost:8080](http://localhost:8080)

## Usage

Application base url (fronend) will be [http://localhost:8080](http://localhost:8080). All requests to Laravel API must be sent using to the url starting with `/api` prefix. Nginx server will proxy all requests with `/api` prefix to the node static server which serves the Nuxt.

Also, the backend can be accessed using [http://localhost:8081](http://localhost:8081) which is handled by Laravel.

## Environment

To up all containers, run the command:

```
# Make command
make up

# Underlying command
docker-compose up -d
```

To shut down all containers, run the command:

```
# Make command
make down

# Underlying command
docker-compose down
```

## Nuxt

Nuxt application is available at [http://localhost:8080](http://localhost:8080).

Take a look at `client/.env` file. There are two variables:

```
API_URL=http://nginx:80
API_URL_BROWSER=http://localhost:8080
```

`API_URL` is the url where Nuxt sends requests during SSR process and is equal to the Nginx url inside the docker network.
`API_URL_BROWSER` is the base application url for browsers.

To make them work, ensure you have the import dotenv statement at the very top in the nuxt.config.js file

```
require('dotenv').config()

export default {
  // Nuxt configuration
}
```

_Note: this project uses NPM as the default package manager. To use the Yarn as the package manager, replace the following line in `Makefile` of the `install-nuxt` section._

```
docker-compose run client npx create-nuxt-app ../client
```

with

```
docker-compose run client yarn create nuxt-app ../client
```

Also replace the following line in `docker/client/Dockerfile`

```
CMD ["sh", "-c", "npm run dev"]
```

with

```
CMD ["sh", "-c", "yarn install && yarn dev"]
```

#### Requests

Example of API request:

```
this.$axios.post('/api/login', {
    username: this.username,
    password: this.password
});
```

Async data

```
async asyncData ({ app }) {
    const [articlesResponse, categoriesResponse] = await Promise.all([
      app.$axios.$get('/api/articles'),
      app.$axios.$get('/api/categories')
    ])

    return {
      articles: articlesResponse.data,
      categories: categoriesResponse.data
    }
},
```

#### Dependencies

If you update or install node dependencies, you should restart the Nuxt process, which is executed automatically by the client container:

```
# Make command
make rc

# Full command
docker-compose restart client
```

## Laravel

Laravel API URL [http://localhost:8081/api](http://localhost:8081/api).

Laravel base URL [http://localhost:8081](http://localhost:8081).

#### Artisan

Artisan commands can be used like below

```
docker-compose exec php php artisan migrate
```

To generate a new controller or any laravel class, all commands should be executed from the current user like this, which grants all needed file permissions

```
docker-compose exec --user "$(id -u):$(id -g)" php php artisan make:controller ArticleController
```

Alternatively, the _aliases.sh_ executable is available to run the commands more easily.

```
artisan make:controller ArticleController
```

[More on aliases.sh](#Aliases)

#### File storage

Nginx will proxy all requests with the `/storage` path prefix to the Laravel storage, so you can easily access it.
Just make sure you run the `artisan storage:link` command (Runs automatically during the `make install` process).

## Makefile

There are a lot of useful make commands you can use.
All of them you should run from the project directory where `Makefile` is located.

Examples:

```
# Up docker containers
make up

# Apply the migrations
make db-migrate

# Run tests
make test

# Down docker containers
make down
```

Feel free to explore it and add your commands if you need them.

## Aliases

Also, there is the _aliases.sh_ file which you can apply with command:

```
source aliases.sh
```

_You should always run this command per new terminal instance._

It helps to execute commands from different containers a bit simpler:

For example, instead of

```
docker-compose exec mysql mysqldump
```

You can use the alias `from`:

```
from mysql mysqldump
```

`artisan` alias

In order to generate a new controller or any Laravel class, all commands should be executed from the current user, which grants all needed file permissions

```
docker-compose exec --user "$(id -u):$(id -g)" php php artisan make:model Post
```

The `artisan` alias allows to do the same like this:

```
artisan make:model Post
```

## Database

In order to connect to MySQL database from an external tool, for example _Sequel Pro_ or _Navicat_, use the following parameters

```
HOST: localhost
PORT: 3306
DB: homestead
USER: homestead
PASSWORD: homestead
```

If you want to dump MySQL data, use the command

```
make db-dump-mysql
```

The above all dump the latest MySQL data to `docker/mysql/dumps/`

## Redis

To connect to redis cli, use the command:

```
docker-compose exec redis redis-cli
```

If you want to connect with external GUI tool, use the port `54321`

## Mailhog

To check how all sent mail look, go to [http://localhost:8026](http://localhost:8026).
It is the test mail catcher tool for SMTP testing. All sent mails will be stored here.

## Mailtrap

Backend has also been configured to use MailTrap. The following fields can be configured for this in `api/.env`.

```
MAIL_USERNAME=null
MAIL_PASSWORD=null
```

## Logs

All **_nginx_** logs are available inside the _docker/nginx/logs_ directory.

All **_supervisor_** logs are available inside the _docker/supervisor/logs_ directory.

To view docker containers logs, use the command:

```
# All containers
docker-compose logs

# Individual container
docker-compose logs <container>
```

## Running commands from containers

You can run commands from inside containers' cli. To enter into the container run the following command:

```
# PHP
docker-compose exec php bash

# NODE
docker-compose exec client /bin/sh
```

## Additional information

- This template has been tested in Mac OS 10.15. Therefore, make changes to the commands such as `chown` available in `Makefile` depending on your environment.
