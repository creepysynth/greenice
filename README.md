# Local project setup

1. In .env file set value for DB_PASSWORD;

2. Run:
    ```bash
    docker-compose up -d
    docker-compose exec app composer install
    docker-compose exec app php artisan migrate
    docker-compose exec app php artisan key:generate
    ```

Access to application: `http://localhost:8000`

Access to application's shell: `docker-compose exec app bash`
