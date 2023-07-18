# TestClearPhp Project
This is a simple PHP project using clear php without any framework.

## Getting Started

To run this project locally, follow these steps:

1. Clone the repository to your local machine:

   ```bash
   git clone git@github.com:yurez/testclearphp.git
   
2. Navigate to the project directory:
   ```bash
   cd testclearphp

3. Copy `.env.dist` to `.env` and update it

4. Build the Docker container:
   ```bash
   docker-compose -f docker/docker-compose.yml build

5. Start the Docker container:
   ```bash
   docker-compose -f docker/docker-compose.yml up -d
   
6. Run composer install
   ```bash
   docker exec -it testclearphp composer install
   
7. Run database migrations
   ```bash
   docker exec -it testclearphp ./bin/run_migrations.sh

8. Update `/etc/hosts` to add `127.0.0.1    testclearphp`

9. Open your web browser and visit [http://testclearphp/](http://testclearphp/) to access the application

## Features
The TestClearPhp project includes the following features:

* User registration and login functionality.
* User authentication and session management using PHP sessions.
* User data persistence with a MySQL database using Docker.

## Structure

The project follows a simple PHP project structure:

* `src/`: Contains all PHP source code files, including controllers, models, and services.
* `public/`: Contains the publicly accessible files, such as the front-end assets and index.php file.
* `config/`: Contains configuration files, such as routes.php, security.php, and services.php.
* `docker/`: Contains the Docker-related files, such as the Dockerfile and docker-compose.yml.

## Testing
To run the PHPUnit tests for this project, run the following command:

   ```bash
   docker exec -it testclearphp ./vendor/bin/phpunit