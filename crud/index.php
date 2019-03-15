<?php // Do not put any HTML above this line
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Marcus Lee - Autos Database Homepage</title>
<?php
require_once "bootstrap.php";
?>
</head>
<body>
<div class="container">
<h1>Welcome to the Automobiles Database</h1>
<p>
<?php if ( !isset($_SESSION['name']) ) { ?>
<a href="login.php">Please Log In</a>
<?php } else {
	if ( isset($_SESSION['success']) ) {
	    echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
	    unset($_SESSION['success']);
	}
	// Flash pattern
	if ( isset($_SESSION['error']) ) {
	    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
	    unset($_SESSION['error']);
	}
	require_once "pdo.php";
	$stmt = $pdo->query("SELECT * FROM autos");
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	if ($rows !== false) { ?>
		<table>
		<tr>
			<th>Make</th>
			<th>Model</th>
			<th>Year</th>
			<th>Mileage</th>
			<th>Action</th>
		</tr>
	<?php	foreach ( $rows as $row ) {
		    echo("<tr>");
		    echo("<td>".$row['make']."</td>");
		    echo("<td>".$row['model']."</td>");
		    echo("<td>".$row['year']."</td>");
		    echo("<td>".$row['mileage']."</td>");
		    echo("<td>");
		    ?>
		    <a href="edit.php?autos_id=<?= $row["autos_id"]?>">Edit</a> / <a href="delete.php?autos_id=<?= $row["autos_id"]?>">Delete</a></td>
		    <?php
		    echo("</tr>\n");
		}

	?> </table> <?php
	} else {
		echo("No rows found");
	}
?>
<p><p>
<a href="add.php">Add New Entry</a>
<p>
<a href="logout.php">Logout</a>
<?php } ?>
</div>
</body>