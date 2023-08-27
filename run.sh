#!/bin/bash

## variables are set here
first_argument="$1"
second_argument="$2"

runInit() {
    cp .env.example .env
    docker compose up -d --build
    docker compose exec app composer install
    docker compose exec app php artisan key:generate
    docker compose exec app php artisan migrate
    docker compose exec app php artisan db:seed
}

run() {
    docker compose up -d
    docker compose exec app php artisan migrate
}

runStop() {
    docker compose down
}

# flags
case $first_argument in
    init)
        runInit
        ;;
    run)
        run
        ;;
    stop)
        runStop
        ;;
    *)
        echo $"Usage: $0 {init|run|stop}"
        exit 1
esac