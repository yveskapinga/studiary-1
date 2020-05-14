# Studiary

School management system.

## Getting started

### Prerequisites

- PHP 7.3.9 or higher
- Composer
- [Node.js](https://nodejs.org/en/)

### Installation

#### Clone the repository

```sh
git clone https://github.com/maelquerre/studiary
```

#### Install dependencies

```sh
composer install
npm install
```

#### Init your database credentials

Remember to add a `.env.local` file (just copy the `.env` file) and set the configuration for your local database.

#### Run the migrations

```sh
php bin/console doctrine:migrations:migrate
```

#### Initialise a first admin user

In order to access to the admin section, and therefore being able to add entity data such as other users, lessons, etc., you have to manually create an admin user with the role `ROLE_ADMIN`. Then log in to the app via the client interface at `/login`.

## Develop

### Run the local web server and watch files

````sh
npm run serve
````

This will start the PHP built-in server on http://localhost:8000.
