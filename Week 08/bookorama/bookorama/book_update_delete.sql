-- ====================
-- Example 1: Update Book Price for a Specific ISBN
-- ====================

-- Update the price of a book identified by its ISBN
UPDATE books
SET price = 29.99
WHERE isbn = '0-672-31697-8';

-- This will update the price of the book "Java 2 for Professional Developers" to $29.99.

-- ====================
-- Example 2: Update Customer Address
-- ====================

-- Update the address of a customer identified by their customerid
UPDATE customers
SET address = '123 New Street', city = 'New City'
WHERE customerid = 3;

-- This will update the address of the customer with customerid = 3 to '123 New Street' in 'New City'.

-- ====================
-- Example 3: Delete a Customer by customerid
-- ====================

-- Delete a customer from the database based on their customerid
DELETE FROM customers
WHERE customerid = 4;

-- This will delete the customer with customerid = 4 (Alan Wong) from the database.

-- ====================
-- Example 4: Delete Orders for a Specific Customer
-- ====================

-- Delete all orders for a customer with a specific customerid
DELETE FROM orders
WHERE customerid = 3;

-- This will delete all orders placed by the customer with customerid = 3 (Julie Smith).

-- ====================
-- Example 5: Update Multiple Fields in Orders Table
-- ====================

-- Update both the amount and the date of an order based on the orderid
UPDATE orders
SET amount = 59.99, date = '2024-09-30'
WHERE orderid = 1;

-- This will update the amount of the order with orderid = 1 to $59.99 and change the order date to '2024-09-30'.

-- ====================
-- Example 6: Increase the Price of All Books by 10%
-- ====================

-- Update the price of all books by multiplying the current price by 1.1 (a 10% increase)
UPDATE books
SET price = price * 1.1;

-- This query will update the price of all books, increasing them by 10%.
