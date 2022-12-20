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

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Form was submitted, process input
  if (isset($_POST["edit"])) {
    // Edit customer form was submitted
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
  } elseif (isset($_POST["delete"])) {
    // Delete customer form was submitted
    $customer_id = $_POST["customer_id"];

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
  }
}

// Select all customers from the customers table
$query = "SELECT * FROM customers";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    // Output the customer data
    echo "<table>";
    echo "<tr><th>Customer ID</th><th>Name</th><th>Actions</th></tr>";
    while($row = mysqli_fetch_assoc($result)) {
      $customer_id = $row["customer_id"];
      $first_name = $row["first_name"];
      $last_name = $row["last_name"];
      echo "<tr>";
      echo "<td>" . $customer_id . "</td>";
      echo "<td>" . $first_name . " " . $last_name . "</td>";
      echo "<td>";
      // Edit button
      echo "<form action='edit_user.php' method='post'>";
      echo "<input type='hidden' name='customer_id' value='" . $customer_id . "'>";
      echo "<input type='submit' name='edit' value='Edit'>";
      echo "</form>";
      // Delete button
      echo "<form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post'>";
      echo "<input type='hidden' name='customer_id' value='" . $customer_id . "'>";
      echo "<input type='submit' name='delete' value='Delete'>";
      echo "</form>";
      echo "</td>";
      echo "</tr>";
    }
    echo "</table>";
  } else {
    echo "No customers found.";
  }
  
  mysqli_close($conn);
  
  ?>
  
  <!-- Edit customer form -->
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" style="display:none;" id="edit-form">
    <label for="customer_id">Customer ID:</label><br>
    <input type="text" id="customer_id" name="customer_id" readonly><br>
    <label for="first_name">First Name:</label><br>
    <input type="text" id="first_name" name="first_name"><br>
    <label for="last_name">Last Name:</label><br>
    <input type="text" id="last_name" name="last_name"><br><br>
    <input type="submit" value="Save">
  </form>
  
  <!-- JavaScript to show the edit form and pre-fill the form with the selected customer's information -->
  <script>
    function showEditForm(customer_id, first_name, last_name) {
      document.getElementById("edit-form").style.display = "block";
      document.getElementById("customer_id").value = customer_id;
      document.getElementById("first_name").value = first_name;
        document.getElementById("last_name").value = last_name;
    }
    </script>