<?php
require_once "pdo.php";

// Demand a GET parameter
if ( ! isset($_GET['name']) || strlen($_GET['name']) < 1  ) {
    die('Name parameter missing');
}

// If the user requested logout go back to index.php
if ( isset($_POST['logout']) ) {
    header('Location: index.php');
    return;
}

$failure = false;  // If we have no POST data
$success = false;  // If we have no POST data

if ( isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) ) {
    if ( (is_numeric($_POST['year'])===false) || (is_numeric($_POST['mileage'])===false) ) {
        $failure = "Mileage and year must be numeric";
    } else if ( strlen($_POST['make']) < 1 ) {
        $failure = "Make is required";
    } else {
        $stmt = $pdo->prepare('INSERT INTO autos (make, year, mileage) VALUES ( :mk, :yr, :mi)');
        $stmt->execute(array(':mk' => $_POST['make'], ':yr' => $_POST['year'], ':mi' => $_POST['mileage']));
        $success = "Record inserted";
    }
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
if ( isset($_REQUEST['name']) ) {
    echo "<h1>Trackin Autos for ";
    echo htmlentities($_REQUEST['name']);
    echo "</h1>\n";
}
?>
<form method="POST">
Make: <input type="text" name="make"><br/>
Year: <input type="text" name="year"><br/>
Mileage: <input type="text" name="mileage"><br/>
<input type="submit" value="Add">
<input type="submit" name="logout" value="Logout">
</form>
<?php
// Note triple not equals and think how badly double
// not equals would work here...
if ( $failure !== false ) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");
} else if ( $success !== false ) {
    echo('<p style="color: green;">'.htmlentities($success)."</p>\n");
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
</div>
</body>
</html>
