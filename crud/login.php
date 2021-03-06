<?php // Do not put any HTML above this line
session_start();
if ( isset($_SESSION['name']) ) {
    unset($_SESSION['name']);
}

if ( isset($_POST['cancel'] ) ) {
    // Redirect the browser to index.php
    header("Location: index.php");
    return;
}

$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';  // pw is php123

// $_SESSION['failure'] = false;  // If we have no POST data
// Check to see if we have some POST data, if we do process it
if ( isset($_POST['email']) && isset($_POST['pass']) ) {
    if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) {
        $_SESSION['failure'] = "User name and password are required";
        header("Location: login.php");
        return;
    } else if (strpos($_POST['email'], '@') === false) {
        $_SESSION['failure'] = "Email must have an at-sign (@)";
        header("Location: login.php");
        return;
    } else {
        $check = hash('md5', $salt.$_POST['pass']);
        if ( $check == $stored_hash ) {
            // Redirect the browser to view.php
            // Redirect the browser to view.php
            $_SESSION['name'] = $_POST['email'];
            header("Location: index.php");
            // find error logs at /Applications/MAMP/logs/php_error.log
            error_log("Login success ".$_POST['email']);
            return;
        } else {
            $_SESSION['failure'] = "Incorrect password";
            error_log("Login fail ".$_POST['email']." $check");
            header("Location: login.php");
            return;
        }
    }
}

// Fall through into the View
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once "bootstrap.php"; ?>
<title>Marcus Lee's Login Page</title>
</head>
<body>
<div class="container">
<h1>Please Log In</h1>
<?php
// Note triple not equals and think how badly double
// not equals would work here...
if ( isset($_SESSION['failure']) ) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">'.htmlentities($_SESSION['failure'])."</p>\n");
    unset($_SESSION['failure']);
}
?>
<form method="POST">
User Name <input type="text" name="email"><br/>
Password <input type="text" name="pass"><br/>
<input type="submit" value="Log In">
<input type="submit" name="cancel" value="Cancel">
</form>
<p>
For a password hint, view source and find a password hint
in the HTML comments.
<!-- Hint: The password is the language of this code, followed by 123. -->
</p>
</div>
</body>
