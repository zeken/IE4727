-- Select all data from the customers table
SELECT * FROM customers;

-- Select specific columns (name and city) from the customers table
SELECT name, city FROM customers;

-- Select customers who live in 'Box Hill'
SELECT name, address, city FROM customers
WHERE city = 'Box Hill';

-- Select orders where the customerid is 3 and the order amount is greater than 50
SELECT * FROM orders
WHERE customerid = 3 AND amount > 50;

-- Join orders with customers to display order details along with the customer's name
SELECT orders.orderid, customers.name, orders.amount, orders.date 
FROM orders
JOIN customers ON orders.customerid = customers.customerid;

-- Join orders and customers tables and filter by customer name 'Julie Smith'
SELECT orders.orderid, customers.name, orders.amount, orders.date 
FROM orders
JOIN customers ON orders.customerid = customers.customerid
WHERE customers.name = 'Julie Smith';

-- Select the title and price of a specific book by its ISBN
SELECT title, price FROM books
WHERE isbn = '0-672-31697-8';

-- Select all orders placed after the date '2007-04-10'
SELECT * FROM orders
WHERE date > '2007-04-10';

-- ====================
-- Examples with ORDER BY
-- ====================

-- Select all customers and order by the 'name' column in ascending order (A to Z)
SELECT * FROM customers
ORDER BY name ASC;

-- Select all customers and order by the 'city' column in descending order (Z to A)
SELECT * FROM customers
ORDER BY city DESC;

-- Select all orders and order by the 'amount' in descending order (highest to lowest)
SELECT * FROM orders
ORDER BY amount DESC;

-- Join orders with customers and order by the customer's name in ascending order
SELECT orders.orderid, customers.name, orders.amount, orders.date 
FROM orders
JOIN customers ON orders.customerid = customers.customerid
ORDER BY customers.name ASC;

-- Select all books and order by price in ascending order (lowest to highest)
SELECT * FROM books
ORDER BY price ASC;

-- Select all order items and order by the quantity in descending order (highest to lowest)
SELECT * FROM order_items
ORDER BY quantity DESC;

-- Select book reviews and order by the ISBN in ascending order
SELECT * FROM book_reviews
ORDER BY isbn ASC;
