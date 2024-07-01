<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Less-17 Update Query- Error based - String</title>
</head>

<body bgcolor="#000000">

<div style="margin-top:20px;color:#FFF; font-size:24px; text-align:center"><font color="#FFFF00"> [PASSWORD RESET] </br></font>&nbsp;&nbsp;<font color="#FF0000"> Dhakkan </font><br></div>

<div align="center" style="margin:20px 0px 0px 520px; background-color:#0CF; text-align:center; width:400px; height:150px;">

<div style="padding-top:10px; font-size:15px;">

<!--Form to post the contents -->
<form action="" name="form1" method="post">
  <div style="margin-top:15px; height:30px;">User Name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;&nbsp;
    <input type="text" name="uname" value=""/>  </div>
  
  <div> New Password : &nbsp; &nbsp;
    <input type="text" name="passwd" value=""/></div><br>
    <div style="margin-top:9px;margin-left:90px;"><input type="submit" name="submit" value="Submit" /></div>
</form>
</div>
</div>
<div style="margin-top:10px;color:#FFF; font-size:23px; text-align:center">
<font size="6" color="#FFFF00">

<?php
// Including the Mysql connect parameters.
include("../sql-connections/sql-connect.php");
error_reporting(0);

function check_input($con, $value) {
    if (!empty($value)) {
        // Truncate to 15 characters
        $value = substr($value, 0, 15);
    }

    // Quote if not a number
    if (!ctype_digit($value)) {
        $value = "'" . mysqli_real_escape_string($con, $value) . "'";
    } else {
        $value = intval($value);
    }
    return $value;
}

// Take the variables
if (isset($_POST['uname']) && isset($_POST['passwd'])) {
    $uname = check_input($con, $_POST['uname']);
    $passwd = $_POST['passwd'];

    // Logging the connection parameters to a file for analysis.
    $fp = fopen('result.txt', 'a');
    fwrite($fp, 'User Name:' . $uname . "\n");
    fwrite($fp, 'New Password:' . $passwd . "\n");
    fclose($fp);

    // Connectivity
    $sql = "SELECT username, password FROM users WHERE username=$uname LIMIT 0,1";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);

    if ($row) {
        $row1 = $row['username'];
        $update = "UPDATE users SET password='" . mysqli_real_escape_string($con, $passwd) . "' WHERE username='$row1'";
        mysqli_query($con, $update);

        if (mysqli_error($con)) {
            echo '<font color="#FFFF00" size="3">';
            print_r(mysqli_error($con));
            echo "</br></br>";
            echo "</font>";
        } else {
            echo '<font color="#FFFF00" size="3">';
            echo "Your password has been successfully updated.";
            echo "<br>";
            echo "</font>";
        }

        echo '<img src="../images/flag1.jpg" />';
    } else {
        echo '<font size="4.5" color="#FFFF00">';
        echo "</br>";
        echo '<img src="../images/slap1.jpg" />';
        echo "</font>";
    }
}
?>

</font>
</div>
</body>
</html>
