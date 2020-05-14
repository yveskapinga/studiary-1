# Studiary

School management system.

## Getting started

### Prerequisites

- PHP 7.3.9 or higher
- [Symfony CLI](https://symfony.com/download)
- [Node.js](https://nodejs.org/en/)

### Installation

1. Clone the repo
```sh
git clone https://github.com/maelquerre/studiary
```
2. Install the dependencies
```sh
composer install
npm install
```

In order to access to the admin section, you have to manually create an admin first in the database, with the role `ROLE_ADMIN`.

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
