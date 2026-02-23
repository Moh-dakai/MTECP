# MTECP (Multi-Tenant E-Commerce Platform)

MTECP is a robust multi-tenant e-commerce platform built with Laravel. It allows multiple tenants to manage their own separate product catalogs, categories, and store settings on a single shared application instance.

## Features

- **Multi-Tenancy**: Built-in support for multiple isolated tenants.
- **Product Catalog Management**: Tenants can manage their own categories, products, and the relationships between them.
- **Scalable Architecture**: Designed to handle a growing number of tenants and products efficiently.

## Requirements

- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL or PostgreSQL

## Installation

1. Clone the repository... (or use existing codebase)
2. Install PHP dependencies:
   ```bash
   composer install
   ```
3. Copy the environment file and generate an application key:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Configure your database settings in the `.env` file.
5. Run database migrations:
   ```bash
   php artisan migrate
   ```

## Usage

Start the local development server:
```bash
php artisan serve
```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
