<?php # Script 10.5 - #5
// This script retrieves all the records from the users table.
// This new version allows the results to be sorted in different ways.

$page_title = 'View the Current Users';
include('includes/header.html');
echo '<h1>Registered Users</h1>';

require('../mysqli_connect.php');

$dbc = mysqli_connect('localhost', 'root', 'password', 'banking');


 	// Count the number of records:
	$q = "SELECT COUNT(customer_id) FROM customers";
	$r = @mysqli_query($dbc, $q);
	$row = @mysqli_fetch_array($r, MYSQLI_NUM);
	$records = $row[0];
	


// Determine where in the database to start returning results...
if (isset($_GET['s']) && is_numeric($_GET['s'])) {
	$start = $_GET['s'];
} else {
	$start = 0;
}



// Define the query:
$q = "SELECT customer_id, last_name, first_name FROM customers";
$r = @mysqli_query($dbc, $q); // Run the query.



//if sort=fn sort by first name
if (isset($_GET['sort'])) {
	if ($_GET['sort'] == 'fn') {
		$q = "SELECT customer_id, last_name, first_name FROM customers ORDER BY first_name ASC";
		$r = @mysqli_query($dbc, $q); // Run the query.
	}
}

//if sort=ln sort by last name
if (isset($_GET['sort'])) {
	if ($_GET['sort'] == 'ln') {
		$q = "SELECT customer_id, last_name, first_name FROM customers ORDER BY last_name ASC";
		$r = @mysqli_query($dbc, $q); // Run the query.
	}
}

// run the query
$r = @mysqli_query($dbc, $q);

// if the query ran ok, display the records
if ($r) {
	// table header
	echo '<table width="60%">
	<thead>
	<tr>
		<th align="left"><strong>Edit</strong></th>
		<th align="left"><strong>Delete</strong></th>
		<th align="left"><strong><a href="view_users.php?sort=ln">Last Name</a></strong></th>
		<th align="left"><strong><a href="view_users.php?sort=fn">First Name</a></strong></th>
	</tr>
	</thead>
	<tbody>
	';

	// fetch and print all the records
	$bg = '#eeeeee';
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee');
		echo '<tr bgcolor="' . $bg . '">
			<td align="left"><a href="edit_user.php?id=' . $row['customer_id'] . '">Edit</a></td>
			<td align="left"><a href="delete_user.php?id=' . $row['customer_id'] . '">Delete</a></td>
			<td align="left">' . $row['last_name'] . '</td>
			<td align="left">' . $row['first_name'] . '</td>
		</tr>
		';
	} // end of while loop

	echo '</tbody></table>';
	mysqli_free_result($r);
} else { // if the query did not run ok
	// error message
	echo '<p class="error">The current users could not be retrieved. We apologize for any inconvenience.</p>';

	// debug message
	echo '<p>' . mysqli_error($dbc) . '<br><br>Query: ' . $q . '</p>';
} // end of if ($r)

echo '</tbody></table>';
mysqli_close($dbc);

// echo break
echo '<br>';

include('includes/footer.html');
?>