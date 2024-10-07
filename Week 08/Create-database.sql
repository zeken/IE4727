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
-- Insert sample data into the products table
INSERT INTO products (product_name, endless_price, single_price, double_price)
VALUES 
    ('Just Java', 6.00, NULL, NULL),
    ('Cafe au Lait', NULL, 2.00, 3.00),
    ('Iced Cappuccino', NULL, 4.75, 5.75);

-- Verify that the data was inserted correctly
SELECT * FROM products;
-- Insert data into the orders table
INSERT INTO orders (product_name, size, quantity, unit_price, total_price, order_date)
VALUES
('Just Java', 'Endless Cup', 10, 2.00, 20.00, '2024-10-04 14:53:36'),
('Cafe au Lait', 'Double', 9, 3.00, 27.00, '2024-10-04 14:53:36'),
('Cafe au Lait', 'Single', 1, 3.00, 3.00, '2024-10-04 14:55:39'),
('Iced Cappuccino', 'Double', 10, 5.75, 57.50, '2024-10-04 15:27:50'),
('Cafe au Lait', 'Double', 1, 3.00, 3.00, '2024-10-04 19:37:28'),
('Iced Cappuccino', 'Double', 1, 5.75, 5.75, '2024-10-04 19:37:28'),
('Iced Cappuccino', 'Double', 1, 5.75, 5.75, '2024-10-04 19:37:55');
