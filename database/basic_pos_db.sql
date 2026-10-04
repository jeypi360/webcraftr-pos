-- Fresh database only. Import into an EMPTY database (never over existing data).
CREATE TABLE products (
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100) NOT NULL,
 price DECIMAL(10,2) NOT NULL,
 stock_quantity INT NOT NULL DEFAULT 0,
 image VARCHAR(255) DEFAULT NULL,
 created_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE customers (
 id INT AUTO_INCREMENT PRIMARY KEY,
 full_name VARCHAR(100) NOT NULL,
 email VARCHAR(100) NOT NULL,
 phone VARCHAR(20) DEFAULT NULL,
 created_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE users (
 id INT AUTO_INCREMENT PRIMARY KEY,
 username VARCHAR(50) NOT NULL UNIQUE,
 full_name VARCHAR(100) NOT NULL,
 password VARCHAR(255) NOT NULL,
 avatar VARCHAR(255) DEFAULT NULL,
 created_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE sales (
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
