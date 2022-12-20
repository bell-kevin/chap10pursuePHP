DELIMITER //
CREATE PROCEDURE delete_customer_account(IN customer_id INT)
BEGIN
  -- First, delete all transactions related to the customer
  DELETE FROM transactions WHERE to_account_id IN (SELECT account_id FROM accounts WHERE customer_id = customer_id);
  DELETE FROM transactions WHERE from_account_id IN (SELECT account_id FROM accounts WHERE customer_id = customer_id);
  
  -- Then, delete all accounts related to the customer
  DELETE FROM accounts WHERE customer_id = customer_id;
  
  -- Finally, delete the customer itself
  DELETE FROM customers WHERE customer_id = customer_id;
END //
DELIMITER ;
