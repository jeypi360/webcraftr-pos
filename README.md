# CodeIgniter Basic POS System

This project is a basic Point-of-Sale application developed using CodeIgniter 4. It displays customer and user account records retrieved from a MySQL database through CodeIgniter Models and Query Builder.

## Features

- Home page
- About page
- Customer Accounts page
- User Accounts page
- MySQL database connection
- CustomerModel and UserModel
- Database records retrieved using `findAll()`

## Requirements

- PHP 8.1 or newer
- XAMPP
- MySQL or MariaDB
- CodeIgniter 4

## Local Setup

1. Place the project folder inside:

   `D:\XAMPP\htdocs\myproject`

2. Start Apache and MySQL using the XAMPP Control Panel.

3. Open phpMyAdmin:

   `http://localhost/phpmyadmin`

4. Create a database named:

   `basic_pos_db`

5. Import the database file:

   `database/basic_pos_db.sql`

6. Create a `.env` file in the project root and add:

   ```ini
   CI_ENVIRONMENT = development

   app.baseURL = 'http://localhost:8081/'

   database.default.hostname = localhost
   database.default.database = basic_pos_db
   database.default.username = root
   database.default.password =
   database.default.DBDriver = MySQLi
   database.default.DBPrefix =
   database.default.port = 3306
   ```

7. Start the CodeIgniter development server:

   ```powershell
   D:\XAMPP\php\php.exe spark serve --port 8081
   ```

8. Open the application:

   `http://localhost:8081`

## Database Tables

The application uses two MySQL tables:

- `customers`
- `users`

Each table contains five sample records.

## Models

The application retrieves database records using:

- `CustomerModel`
- `UserModel`

Both controllers use the CodeIgniter Model method `findAll()` instead of static PHP arrays.

## Hosted Application

[https://jeypi-codeigniter-pos.infinityfree.me](https://jeypi-codeigniter-pos.infinityfree.me)

## GitHub Repository

[https://github.com/jeypi360/codeigniter-pos-system](https://github.com/jeypi360/codeigniter-pos-system)