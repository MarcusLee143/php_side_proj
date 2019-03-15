<?php
require_once "pdo.php";
require_once "bootstrap.php";
session_start();

if ( !isset($_SESSION['name']) ) {
    die("ACCESS DENIED");
}

if ( isset($_POST['make']) && isset($_POST['model'])
     && isset($_POST['year']) && isset($_POST['mileage'])) {

    // Data validation
    if ( strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1
        || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1) {
        $_SESSION['error'] = 'Missing data';
        header("Location: add.php");
        return;
    }

    if ( !is_numeric($_POST['year'])) {
        $_SESSION['error'] = 'Year must be an integer';
        header("Location: add.php");
        return;
    } else if (! is_numeric($_POST['mileage']) ) {
        $_SESSION['error'] = 'Mileage must be an integer';
        header("Location: add.php");
        return;
    }

    $sql = "INSERT INTO autos (make, model, year, mileage) VALUES (:mk, :md, :yr, :mi)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':mk' => $_POST['make'],
        ':md' => $_POST['model'],
        ':yr' => $_POST['year'],
        ':mi' => $_POST['mileage']));
    $_SESSION['success'] = 'Record Added';
    header( 'Location: index.php' ) ;
    return;
}
?>
<!DOCTYPE html>
<html>
<body>
<div class="container">
<h2>Add A New Automobile</h2>
<?php
// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
?>
<form method="POST">
Make: <input type="text" name="make"><br/>
Model: <input type="text" name="model"><br/>
Year: <input type="text" name="year"><br/>
Mileage: <input type="text" name="mileage"><br/>
<input type="submit" value="Add">
<input type="submit" name="cancel" value="Cancel">
</form>
