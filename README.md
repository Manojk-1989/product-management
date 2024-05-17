# product-management
```markdown
# Product Management System

This is a Product Management System that supports CRUD (Create, Read, Update, Delete) operations and image uploading to storage. The image upload functionality is implemented using AJAX calls. Below are the steps to set up and run the project.

## Prerequisites

- PHP 8.2.12 or higher
- Composer
- MySQL or any other database supported by Laravel
- Node.js and npm (for managing JavaScript dependencies)

## Getting Started

### 1. Clone the Repository

First, clone the repository from GitHub to your local machine:

```bash
git clone https://github.com/Manojk-1989/product-management.git
cd your-repository
```

### 2. Set Up Environment

Copy the `.env.example` file to `.env` and update the database configuration:

```bash
cp .env.example .env
```

Edit the `.env` file to include your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=
```

### 3. Install Dependencies

Install the necessary PHP dependencies using Composer:

```bash
composer install
```


```

### 4. Migrate the Database

Run the following command to migrate the tables to the database:

```bash
php artisan migrate:fresh
```

### 5. Link Storage

Run the following command to create a symbolic link from `public/storage` to `storage/app/public`:

```bash
php artisan storage:link
```

### 6. Seed Master Data

Before adding new products, you must add color and size master data. Use the application's interface to add this data.

## Usage

The application supports basic CRUD operations for managing products. The image upload feature is handled via AJAX to ensure a smooth user experience.

### Running the Application

You can run the application using the built-in Laravel server:

```bash
php artisan serve
```

By default, the application will be accessible at `http://127.0.0.1:8000`.

## Additional Commands

- To clear the configuration cache:

  ```bash
  php artisan config:cache
  ```

- To clear the route cache:

  ```bash
  php artisan route:cache
  ```

- To clear the view cache:

  ```bash
  php artisan view:cache
  ```

## License

This project is licensed under the MIT License.

## Contact

For any inquiries, please contact [your-email@example.com](mailto:manojkumarka99@gmail.com).

```

Feel free to customize the README file content as per your project's specific requirements.