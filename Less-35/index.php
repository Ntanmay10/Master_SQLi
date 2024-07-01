<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Less-35 **why care for addslashes()**</title>
</head>

<body bgcolor="#000000">
<div style="margin-top:70px;color:#FFF; font-size:23px; text-align:center">Welcome&nbsp;&nbsp;&nbsp;<font color="#FF0000"> Dhakkan </font><br>
<font size="5" color="#00FF00">

<?php
//including the Mysql connect parameters.
include("../sql-connections/sql-connect.php");

// Function to sanitize input (not using addslashes)
function sanitize_input($string, $con) {
    // Using mysqli_real_escape_string to escape the string
    $string = mysqli_real_escape_string($con, $string);
    return $string;
}

// Take the variables 
if(isset($_GET['id'])) {
    $id = sanitize_input($_GET['id'], $con); // Sanitize input using the function

    // Logging the connection parameters to a file for analysis.
    $fp = fopen('result.txt', 'a');
    fwrite($fp, 'ID:'.$id."\n");
    fclose($fp);

    // Connectivity 
    mysqli_query($con, "SET NAMES gbk");
    $sql = "SELECT * FROM users WHERE id=? LIMIT 0,1";
    
    // Using prepared statement to prevent SQL injection
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if($row) {
        echo '<font color= "#00FF00">';    
        echo 'Your Login name:'. htmlspecialchars($row['username']);
        echo "<br>";
        echo 'Your Password:' . htmlspecialchars($row['password']);
        echo "</font>";
    } else {
        echo '<font color= "#FFFF00">';
        echo "No user found or error occurred.";
        echo "</font>";
    }
} else {
    echo "Please input the ID as parameter with numeric value";
}
?>
</font> </div><br/><br/><br/><center>
<img src="../images/Less-35.jpg" /><br/><br/><br/><br/><br/>
<font size='4' color= "#33FFFF">
<?php
echo "Hint: The Query String you input is escaped as : " . htmlspecialchars($id);
?>
</center>
</font> 
</body>
</html>
