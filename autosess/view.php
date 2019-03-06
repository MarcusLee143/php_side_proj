<?php
require_once "pdo.php";
session_start();
// Demand a GET parameter
if ( ! isset($_SESSION['name']) || strlen($_SESSION['name']) < 1  ) {
    die('Not logged in');
}

// If the user requested logout go back to index.php
if ( isset($_POST['logout']) ) {
    header('Location: logout.php');
    return;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Marcus Lee's Automobile Database</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
<?php
if ( isset($_SESSION['name']) ) {
    echo "<h1>Tracking Autos for ";
    echo htmlentities($_SESSION['name']);
    echo "</h1>\n";
}
?>
<?php
// Note triple not equals and think how badly double
// not equals would work here...
if ( isset($_SESSION['failure']) ) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">'.htmlentities($_SESSION['failure'])."</p>\n");
    unset($_SESSION['failure']);
}

if ( isset($_SESSION['success'])) {
    echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
    unset($_SESSION['success']);
}
?>
<h3>Automobiles</h3>
<!-- put automobile database here-->
<?php
require_once "pdo.php";
$stmt = $pdo->query("SELECT * FROM autos");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "<ul>";
foreach ( $rows as $row ) {
    echo "<li>";
    echo($row['year']);
    echo " ";
    echo($row['make']);
    echo(" / ");
    echo($row['mileage']);
    echo("</li>\n");
}
echo "</ul>";
?>
<p>
<a href="add.php">Add New</a> | <a href="logout.php">Logout</a>
</div>
</body>
</html>
