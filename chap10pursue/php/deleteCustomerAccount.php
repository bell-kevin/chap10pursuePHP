<?php

// Connect to the database
$db_host = "localhost";
$db_user = "root";
$db_pass = "password";
$db_name = "banking";

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Define variables
$customer_id = $_POST[12];

// Check if the customer has any active accounts
$query = "SELECT * FROM accounts WHERE customer_id='$customer_id'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
  // Customer has active accounts, cannot delete
  echo "Error: Cannot delete customer due to foreign key constraints.";
} else {
  // Customer does not have any active accounts, can delete
  $query = "DELETE FROM customers WHERE customer_id='$customer_id'";
  if (mysqli_query($conn, $query)) {
    echo "Success: Customer account deleted.";
  } else {
    echo "Error: Could not delete customer account.";
  }
}

mysqli_close($conn);

?>