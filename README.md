# Studiary

School management system.

## Getting started

### Prerequisites

- PHP 7.3.9 or higher
- [Symfony CLI](https://symfony.com/download)
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

#### Initialise a first admin user

In order to access to the admin section, and therefore being able to add entity data such as other users, lessons, etc., you have to manually create an admin user with the role `ROLE_ADMIN`. Then log in to the app via the client interface at `/login`.

## Develop

Start the local Symfony web server
```sh
symfony server:start
```

Or with the PHP built-in server
```sh
php -S localhost:8000 -t public/
```

These commands start a development server on http://localhost:8000.
