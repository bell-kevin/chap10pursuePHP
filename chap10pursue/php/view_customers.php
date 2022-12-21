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

// Select all customers from the customers table
$query = "SELECT * FROM customers";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
  // Output the customer data
  while($row = mysqli_fetch_assoc($result)) {
    echo "Customer ID: " . $row["customer_id"]. " - Name: " . $row["first_name"]. " " . $row["last_name"]. "<br>";
  }
} else {
  echo "No customers found.";
}

mysqli_close($conn);

?>