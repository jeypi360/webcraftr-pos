# CodeIgniter POS Midterm

A CodeIgniter 4 POS with staff login; products, customers, and staff CRUD; prepared product photos and avatars; atomic stock deduction for sales; and sales history.

## Requirements

PHP 8.2+, MySQL/MariaDB, PHP MySQLi and GD extensions. The web server must write to `writable/` and `public/uploads/products/` and `public/uploads/avatars/`.

## Set up a local database

1. Preserve your current `.env` and make a database backup if upgrading.
2. For an **empty** database, import `database/schema.sql` using phpMyAdmin. The file `database/basic_pos_db.sql` is an identical fresh schema. It contains no starter accounts.
3. For an **existing** database with customers and users, run `database/upgrade_existing.sql` instead. Never import the fresh schema into an existing database. The upgrade preserves customer and user records; old users receive an empty password until you assign a new one. If products or sales already exist, compare their columns with `database/schema.sql` before upgrading.
4. Set database settings and local base URL in your local `.env`; the ZIP intentionally excludes `.env`. From the project root run `D:\XAMPP\php\php.exe spark staff:setup johnj`, substituting an existing username. For an empty database, the command creates the first account. Enter a password of at least 8 characters (the command prompt may display your input). To start the local server: `D:\XAMPP\php\php.exe spark serve --port 8081`.
5. Visit `http://localhost:8081/login` and log in. Set passwords for other old staff in the Staff Edit page. You can then create staff accounts and upload images.

## Hosted database and deployment

Keep your hosted `.env`, `writable/` contents, and existing uploaded photos. Deploy the code to the same paths as your current installation; put the contents of `public/uploads/` in the **live public document root** if it differs from the local layout. Update the **hosted** database separately with `database/upgrade_existing.sql`.

If hosting has no command-line PHP, generate a password hash on your own computer: `D:\XAMPP\php\php.exe -r "echo password_hash('TEMP_PASSWORD', PASSWORD_DEFAULT), PHP_EOL;"`. In hosted phpMyAdmin update an existing username with `UPDATE users SET password = 'HASH_FROM_PREVIOUS_COMMAND' WHERE username = 'johnj';`. Choose your own temporary password and hash; change that password in Staff Edit immediately after login. For a fresh empty hosted database, create a first staff row with username, name, hash, and `NOW()` in phpMyAdmin. Do not upload local `.env`, passwords, or database backups to a public repository.

Product images are prepared at 400 × 400 pixels; avatars at 160 × 160 pixels. Both are stored under `public/uploads/`, and only a generated filename is stored in the database. Sales record the product's price at sale time and reduce stock in one transaction. Records tied to sales cannot be deleted, preserving the three foreign key relationships. Home and About remain public; all management pages require a staff session.
