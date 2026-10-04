-- Back up the existing database before running this once in phpMyAdmin.
-- Existing users receive an unusable empty password until explicitly assigned a hash.
-- Use the CLI command described in README.md to set the first password.
SET @schema_name = DATABASE();
SET @sql = IF((SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = @schema_name AND TABLE_NAME = 'users' AND COLUMN_NAME = 'password') = 0,
    'ALTER TABLE users ADD COLUMN password VARCHAR(255) NOT NULL DEFAULT ""', 'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;
SET @sql = IF((SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = @schema_name AND TABLE_NAME = 'users' AND COLUMN_NAME = 'avatar') = 0,
    'ALTER TABLE users ADD COLUMN avatar VARCHAR(255) DEFAULT NULL', 'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;
CREATE TABLE IF NOT EXISTS products (
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100) NOT NULL,
 price DECIMAL(10,2) NOT NULL,
 stock_quantity INT NOT NULL DEFAULT 0,
 image VARCHAR(255) DEFAULT NULL,
 created_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE IF NOT EXISTS sales (
 id INT AUTO_INCREMENT PRIMARY KEY,
 product_id INT NOT NULL,
 customer_id INT DEFAULT NULL,
 sold_by INT NOT NULL,
 quantity INT NOT NULL,
 total_price DECIMAL(10,2) NOT NULL,
 created_at DATETIME NOT NULL,
 CONSTRAINT fk_sales_product FOREIGN KEY (product_id) REFERENCES products(id),
 CONSTRAINT fk_sales_customer FOREIGN KEY (customer_id) REFERENCES customers(id),
 CONSTRAINT fk_sales_staff FOREIGN KEY (sold_by) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
