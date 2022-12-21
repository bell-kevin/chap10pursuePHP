<?php

$page_title = 'Change Your Password';
include('includes/header.html');

// Connect to the database
$db_host = "localhost";
$db_user = "root";
$db_pass = "password";
$db_name = "banking";

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Form was submitted, process input
  $customer_id = $_POST["customer_id"];
  $first_name = $_POST["first_name"];
  $last_name = $_POST["last_name"];

  // Update customer in the database
  $query = "UPDATE customers SET first_name='$first_name', last_name='$last_name' WHERE customer_id='$customer_id'";
  if (mysqli_query($conn, $query)) {
  echo "Success: Customer information updated.";
  } else {
  echo "Error: Could not update customer information.";
  }
  }
  
  // Retrieve the customer's information
  $query = "SELECT * FROM customers WHERE customer_id='$customer_id'";
  $result = mysqli_query($conn, $query);
  
  if (mysqli_num_rows($result) == 1) {
  // Output the customer data
  $row = mysqli_fetch_assoc($result);
  $first_name = $row["first_name"];
  $last_name = $row["last_name"];
  
  // Display the edit form
  echo "<form action='edit_user.php' method='post'>";
  echo "<input type='hidden' name='customer_id' value='$customer_id'>";
  echo "First name: <input type='text' name='first_name' value='$first_name'><br>";
  echo "Last name: <input type='text' name='last_name' value='$last_name'><br>";
  echo "<input type='submit' value='Submit'>";
  echo "</form>";
  } else {
  echo "Error: Could not retrieve customer information.";
  }
  
  mysqli_close($conn);
  
  ?>
