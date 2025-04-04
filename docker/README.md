# Building development environment
[BACK TO ROOT](./../README.md)
## Installation

First clone .env.example file to .env file. Something like this:
```shell
cp .env.example .env
```
**MUST** change the APP_CODE and COMPOSE_PROJECT_NAME that defines your application and error code of project.
```dotenv
APP_CODE=NAL
COMPOSE_PROJECT_NAME=yourappname
```
**MUST** change the CORS_ORIGIN_WHITELIST that defines the domain that can access your API.
```dotenv
CORS_ORIGIN_WHITELIST=http://localhost:3000,https://example.com
```

**MUST** update `yourappname_app` command syntax on **docker/hooks/pre-commit** and **docker/hooks/pre-push** files to prepare command to running checking code convention and php unit. After changed it and pushed to GIT, we can check code convention and php unit inside docker containers. 
```shell
docker exec yourappname_app ./vendor/bin/phpcs -n --standard=phpcs.xml
docker exec yourappname_app ./vendor/bin/phpmd app text phpmd.xml
docker exec yourappname_app ./vendor/bin/phpstan analyse -c phpstan.neon --memory-limit=2G
docker exec yourappname_app ./vendor/bin/phpunit -c phpunit.xml --coverage-html ./storage/coverage
```
*Note: Above change only need on first install project. If your application decided that no need unit test, you can comment out it on docker/entrypoint.sh file*

After that, lets following below command to build the docker containers:

*Note: If you are using M1 or M2 chip, let using this command `export DOCKER_DEFAULT_PLATFORM=linux/amd64` to set up docker compatible with your OS before building the containers.*

```shell
docker-compose build
```

Waiting for a while to finish building containers. Then start run containers.
```shell
docker-compose up -d
```

You should be seen all containers state is `up`

#### Setup laravel
Open workspace container then install composer for project
```shell
docker exec -it yourappname_app bash
```

```shell
composer install
```

Directory permissions to `bootstrap/cache` and `storage` folder.
```shell
chmod -R 775 bootstrap/cache/ storage/
```

Make sure root folder has `.env` file and `APP_KEY` has been set. If not please using this command to add them.
```shell
php artisan key:generate
```

Run command to install all dependencies:

```shell
php artisan dev:install
```

Open browser and type `api.localhost` then it should be load successful.

## Working with containers
### Database container

We recommended connect database by some tools: 

- [DataGrip](https://www.jetbrains.com/datagrip/)
- [Mysql Workbench](https://www.mysql.com/products/workbench/)
- [DBeaver](https://dbeaver.io/)
- [Navicat](https://navicat.com/en/)

**NOT RECOMMENDED** use phpmyadmin to connect database because of the UI is too messy and the config is complex.

Tips: Some way to import data through docker container:

+ Using pv to import data with process pipe bar ([install pv](https://macappstore.org/pv/))
```shell
pv /path-to-your-file/data.sql | docker exec -i yourappname_db -u"root" -p app_db
```

+ Import file without pv
```shell
docker exec -i yourappname_db -u"root" -p app_db < /path-to-your-file/data.sql
```

### S3 bucket container

We are using [minio](https://min.io/docs/minio/container/index.html) to support storage objects with high performance. It provides an Amazon Web Services S3-compatible API and supports all core S3 features.

Site: `http://localhost:9001/login`
Login Info: `minio_access_key/minio_secret_key`

![Minio Login Screen](assets/minio-screen.png)

After login site, let create your bucket then update AWS_BUCKET value.

*Note: Must update env AWS_USE_PATH_STYLE_ENDPOINT=true and AWS_ENDPOINT=http://s3:9000 to using minio bucket on your local*

```dotenv
AWS_ACCESS_KEY_ID=minio_access_key
AWS_SECRET_ACCESS_KEY=minio_secret_key
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your-bucket
AWS_USE_PATH_STYLE_ENDPOINT=true
AWS_ENDPOINT=http://s3:9000
```

### Mailhog container

Access the site: `http://localhost:8025` to get your mailbox. 

![Mailhog Screen](assets/mailhog-screen.png)

The .env variables should be config like this:

```dotenv
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=info@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Redis container

Let's download [RedisInsight](https://redis.io/docs/stack/insight/) to visualize and optimize Redis data on your local.

![RedisInsight Screen](assets/redisinsight-screen.png)

[BACK TO ROOT](./../README.md)
