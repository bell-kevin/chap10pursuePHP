INSERT INTO customers(first_name, last_name)
VALUES('Sarah', 'Vowell'),('David', 'Sedaris'),('Kojo', 'Nnamdi');
INSERT INTO accounts(customer_id, balance)
VALUES(1, 5460.23),(2, 909325.24),(3, 892.00);
INSERT INTO accounts(customer_id, TYPE, balance)
VALUES(2, 'Savings', 13546.97);
