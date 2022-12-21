<?php # Script 10.5 - #5
// This script retrieves all the records from the users table.
// This new version allows the results to be sorted in different ways.

$page_title = 'View the Current Users';
include('includes/header.html');
echo '<h1>Registered Users</h1>';

require('../mysqli_connect.php');

$dbc = mysqli_connect('localhost', 'root', 'password', 'banking');


 	// Count the number of records:
	$q = "SELECT COUNT(customer_id) FROM banking.customers";
	$r = @mysqli_query($dbc, $q);
	$row = @mysqli_fetch_array($r, MYSQLI_NUM);
	$records = $row[0];
	


// Determine where in the database to start returning results...
if (isset($_GET['s']) && is_numeric($_GET['s'])) {
	$start = $_GET['s'];
} else {
	$start = 0;
}

// Determine the sort...
// Default is by registration date.
$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'rd';



// Define the query:
$q = "SELECT last_name, first_name FROM banking.customers";
$r = @mysqli_query($dbc, $q); // Run the query.

// Table header:
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

// Fetch and print all the records....
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
} // End of WHILE loop.

echo '</tbody></table>';
mysqli_free_result($r);
mysqli_close($dbc);



include('includes/footer.html');
?>