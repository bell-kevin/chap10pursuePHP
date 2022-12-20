--Here is an example of how to use the UPDATE statement to change the name of a customer with a customer_id of 6 from 'Bob Smith' to 'Kevin Bell':

UPDATE customers
SET first_name = 'Kevin', last_name = 'Bell'
WHERE customer_id = 6;
