<h1 align="center" style="font-weight: bold;">E-Commerce Client Management API 💻</h1>

<p align="center">
 <a href="#technologies">Technologies</a> • 
 <a href="#getting-started">Getting Started</a> • 
</p>

<h2 id="technologies">💻 Technologies</h2>

- PHP 8.x  
- Laravel Framework  
- MySQL / PostgreSQL (Database)  
- DTO (Data Transfer Object) Pattern  
- Service Layer Pattern  
- Filament Admin Panel (Resource Management)  

<h2 id="getting-started">🚀 Getting Started</h2>

Follow these steps to run the project locally.

<h3>Prerequisites</h3>

- PHP 8.1+  
- Composer  
- MySQL or PostgreSQL  
- Git  

<h3>Clone the repository</h3>

```bash
git clone https://github.com/valter-junnior/duard-ecommerce-laravel.git
cd duard-ecommerce-laravel
````

<h3>Install dependencies</h3>

```bash
composer install
```

<h3>Set up environment variables</h3>

Copy `.env.example` to `.env` and configure your database, mail, and other credentials.

```bash
cp .env.example .env
```

Edit `.env` accordingly.

<h3>Run migrations and seeders</h3>

```bash
php artisan migrate --seed
```

<h3>Start the application</h3>

```bash
php artisan serve
```
