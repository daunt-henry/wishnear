<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

$showError = "false";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '_dbconnect.php';
    $email = $_POST['loginEmail'];
    $pass = $_POST['loginPass'];

    $sql = "SELECT * FROM users WHERE user_email='$email'";
    $result = mysqli_query($conn, $sql);
    $numRows = mysqli_num_rows($result);

    if ($numRows == 1) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($pass, $row['user_pass'])) {
            // Remove or comment out the var_dump line
            // var_dump("Password match");

            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['sno'] = $row['sno'];
            $_SESSION['useremail'] = $email;

            header("Location: /fforum_dev/index.php");
            exit(); // Always exit after a header redirect
        } else {
            $showError = "Incorrect Password";
        }
    } else {
        $showError = "User not found";
    }
}

// Redirect for cases where the login was not successful
header("Location: /fforum_dev/index.php?error=$showError");
exit(); // Always exit after a header redirect
?> 