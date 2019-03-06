<?php
require_once "pdo.php";
session_start();
// Demand a GET parameter
if ( ! isset($_SESSION['name']) || strlen($_SESSION['name']) < 1  ) {
    die('Not logged in');
}

// If the user requested cancel go back to view.php
if ( isset($_POST['cancel']) ) {
    header('Location: view.php');
    return;
}

$_SESSION['failure'] = false;  // If we have no POST data
$_SESSION['success'] = false;  // If we have no POST data

if ( isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) ) {
    if ( (is_numeric($_POST['year'])===false) || (is_numeric($_POST['mileage'])===false) ) {
        $_SESSION['failure'] = "Mileage and year must be numeric";
        header("Location: view.php");
        return;
    } else if ( strlen($_POST['make']) < 1 ) {
        $_SESSION['failure'] = "Make is required";
        header("Location: view.php");
        return;
    } else {
        $stmt = $pdo->prepare('INSERT INTO autos (make, year, mileage) VALUES ( :mk, :yr, :mi)');
        $stmt->execute(array(':mk' => $_POST['make'], ':yr' => $_POST['year'], ':mi' => $_POST['mileage']));
        $_SESSION['success'] = "Record inserted";
        header("Location: view.php");
        return;
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
if ( isset($_SESSION['name']) ) {
    echo "<h1>Tracking Autos for ";
    echo htmlentities($_SESSION['name']);
    echo "</h1>\n";
}
?>
<form method="POST">
Make: <input type="text" name="make"><br/>
Year: <input type="text" name="year"><br/>
Mileage: <input type="text" name="mileage"><br/>
<input type="submit" value="Add">
<input type="submit" name="cancel" value="Cancel">
</form>
</div>
</body>
</html>
