<html>
<head>
</head>
<body bgcolor="#000000">
<?php
session_start();
if (!isset($_COOKIE["Auth"]) || !isset($_SESSION["username"])) {
    header('Location: index.php');
    exit; // Ensure no further code execution after redirection
}
?>
<div align="right">
    <a style="font-size:.8em;color:#FFFF00" href='index.php'><img src="../images/Home.png" height='45'; width='45'><br>HOME</a>
</div>

<?php
//including the Mysql connect parameters.
include("../sql-connections/sql-connect.php");

if (isset($_POST['submit'])) {
    // Validating the user input
    $username = $_SESSION["username"];
    $curr_pass = mysqli_real_escape_string($con, $_POST['current_password']);
    $pass = mysqli_real_escape_string($con, $_POST['password']);
    $re_pass = mysqli_real_escape_string($con, $_POST['re_password']);

    if ($pass == $re_pass) {
        $sql = "UPDATE users SET PASSWORD='$pass' WHERE username='$username' AND password='$curr_pass'";
        $res = mysqli_query($con, $sql);
        if ($res && mysqli_affected_rows($con) == 1) {
            echo '<font size="3" color="#FFFF00">';
            echo '<center>';
            echo '<img src="../images/password-updated.jpg">';
            echo "Password successfully updated";
            echo "</center>";
            echo "</font>";
        } else {
            echo '<font size="3" color="#FFFF00">';
            echo '<center>';
            echo "Failed to update password. Please try again.";
            echo "</center>";
            echo "</font>";
        }
    } else {
        echo '<font size="5" color="#FFFF00"><center>';
        echo "Make sure New Password and Retype Password fields have the same value";
        echo '</center></font>';
    }
}

if (isset($_POST['submit1'])) {
    session_destroy();
    setcookie('Auth', '', time() - 3600); // Clear cookie
    header('Location: index.php');
    exit;
}
?>
</body>
</html>
