CREATE DATABASE javajam;
USE javajam;
CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(255) NOT NULL,
    size VARCHAR(50),
    quantity INT NOT NULL,
    unit_price DECIMAL(5,2) NOT NULL,
    total_price DECIMAL(6,2) NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(255) NOT NULL,
    endless_price DECIMAL(5,2),
    single_price DECIMAL(5,2),
    double_price DECIMAL(5,2)
);
