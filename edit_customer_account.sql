DELIMITER //
CREATE PROCEDURE edit_customer_account(IN customer_id INT, IN first_name VARCHAR(255), IN last_name VARCHAR(255))
BEGIN
  UPDATE customers
  SET first_name = first_name, last_name = last_name
  WHERE customer_id = customer_id;
END //
DELIMITER ;
