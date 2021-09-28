# Project

It is an online store with a backoffice, a payment and email system developed with Symfony.

## Development environment

### Prerequisites

- PHP 8.0
- Composer
- Somfony CLI
- Nodejs et npm

You can check the prerequisites with the following command (from the Symfony CLI) :

```bash
symfony check:requirements
```

### Download

To download the project typed the following commands:

```bash
cd your path (example : C:/wamp64/www)
git clone https://github.com/cdiot/ecommerce.git
```

### Launch the development environment

Configure `DATABASE_URL` environment variable by renaming the .env file to .env.local and enter your information.

To start the development environment typed the following commands :

```bash
composer install
npm install
npm run build
symfony serve -d
```
