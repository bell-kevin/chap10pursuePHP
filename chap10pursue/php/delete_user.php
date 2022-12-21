<?php
# Script 10.2 - delete_user.php
// This page is for deleting a user record.
// This page is accessed through view_users.php.

$page_title = 'Delete a Customer';
include('includes/header.html');
echo '<h1>Delete a User</h1>';

// Check for a valid user ID, through GET or POST:
if ((isset($_GET['id'])) && (is_numeric($_GET['id']))) { // From view_users.php
	$id = $_GET['id'];
} elseif ((isset($_POST['id'])) && (is_numeric($_POST['id']))) { // Form submission.
	$id = $_POST['id'];
} else { // No valid ID, kill the script.
	echo '<p class="error">This page has been accessed in error.</p>';
	include('includes/footer.html');
	exit();
}

require('../mysqli_connect.php');

// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if ($_POST['sure'] == 'Yes') { // Delete the record.

		// Check for related records in the accounts table:
		$q = "SELECT COUNT(*) FROM accounts WHERE customer_id=$id";
		$r = @mysqli_query($dbc, $q);
		$count = mysqli_fetch_array($r, MYSQLI_NUM);
		if ($count[0] > 0) {
			// Display an error message and exit the script:
			echo '<p class="error">There are still accounts associated with this customer. Please delete those accounts first before deleting the customer.</p>';
			include('includes/footer.html');
			exit();
		}

		// If there are no related records, proceed with the DELETE query:
		$q = "DELETE FROM customers WHERE customer_id=$id LIMIT 1";
		$r = @mysqli_query($dbc, $q);
		if (mysqli_affected_rows($dbc) == 1) {
			// Print a message:
			echo '<p>The user has been deleted.</p>';
		} else {
			echo '<p class="error">The user could not be deleted due to a system error.</p>';
			echo '<p>' . mysqli_error($dbc) . '<br>Query: ' . $q . '</p>';
		}
	} else { // No confirmation of deletion.
		echo '<p>The user has NOT been deleted.</p>';
	}
} else { // Show the form.

	// Retrieve the user's information:
	$q = "SELECT CONCAT(last_name, ', ', first_name) FROM customers WHERE customer_id=$id";
	$r = @mysqli_query($dbc, $q);

	if (mysqli_num_rows($r) == 1) { // Valid user ID, show the form.

		// Get the user's information:
		$row = mysqli_fetch_array($r, MYSQLI_NUM);

		// Display the record being deleted:
		echo "<h3>Name: $row[0]</h3>
		Are you sure you want to delete this user?";

		// Create the form:
		echo '<form action="delete_user.php" method="post">
	<input type="radio" name="sure" value="Yes"> Yes
	<input type="radio" name="sure" value="No" checked="checked"> No
	<input type="submit" name="submit" value="Submit">
	<input type="hidden" name="id" value="' . $id . '">
	</form>';
	} else { // Not a valid user ID.
		echo '<p class="error">This page has been accessed in error.</p>';
	}
} // End of the main submission conditional.

mysqli_close($dbc);

include('includes/footer.html');
?>