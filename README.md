# Buzzvel 2024 Dev Team Test
2024 - Vacation Plan

[📼 Video Demo](https://youtube/code)

[🧾 Documentation](https://documenter.getpostman.com/view/10594710/2sA2xk1roM)

API is hosted live in http://lucaspenha.com.br/buzzvel/api

## What is it?

RESTful API to manage holiday plans for the year 2024.

### Authentication
You need to authenticate to use the API

To do this, you need to register and log in. After that, you will have the Bearer Token for transactions.

### API Endpoints
- Create a new holiday plan
- Retrieve all holiday plans
- Retrieve a specific holiday plan by ID
- Update an existing holiday plan
- Delete a holiday plan
- Trigger PDF generation for a specific holiday plan

## Running the project in localhost

The app was build using Laravel Sail (Docker).

1. Clone this reposistory.
2. Enter the cloned folder and install composer dependecies with docker

    ```
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v "$(pwd):/var/www/html" \
        -w /var/www/html \
        laravelsail/php83-composer:latest \
        composer install --ignore-platform-reqs
    ```
3. Copy .env.example file to .env

    ```
    cp .env.example .env
    ```
3. Start the containers with Sail
    ```
    ./vendor/bin/sail up -d
    ```
5. Create App Key: 
    ```
    ./vendor/bin/sail artisan key:generate
    ```
6. Link to storage folder link to public: 
    ```
    ./vendor/bin/sail artisan storage:link
    ```
7. Execute the migrations with seeds: 
    ```
    ./vendor/bin/sail artisan migrate --seed
    ```

It`s Ready! everything should be working 🤣