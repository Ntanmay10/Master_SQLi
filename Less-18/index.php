<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Less-18 Header Injection- Error Based- string</title>
</head>

<body bgcolor="#000000">

<div style="margin-top:20px;color:#FFF; font-size:24px; text-align:center"> Welcome&nbsp;&nbsp;&nbsp;<font color="#FF0000"> Dhakkan </font><br></div>
<div align="center" style="margin:20px 0px 0px 510px; background-color:#0CF; text-align:center;width:400px; height:150px;">
<div style="padding-top:10px; font-size:15px;">

<!--Form to post the contents -->
<form action="" name="form1" method="post">
  <div style="margin-top:15px; height:30px;">Username : &nbsp;&nbsp;&nbsp;
    <input type="text" name="uname" value=""/>  </div>
  
  <div> Password : &nbsp; &nbsp;
    <input type="text" name="passwd" value=""/></div><br>
    <div style="margin-top:9px;margin-left:90px;"><input type="submit" name="submit" value="Submit" /></div>
</form>
</div>
</div>
<div style="margin-top:10px;color:#FFF; font-size:23px; text-align:center">
<font size="3" color="#FFFF00">

<?php
// Including the Mysql connect parameters.
include("../sql-connections/sql-connect.php");
error_reporting(0);

function check_input($con, $value) {
    if (!empty($value)) {
        // Truncate to 20 characters
        $value = substr($value, 0, 20);
    }

    // Quote if not a number
    if (!ctype_digit($value)) {
        $value = "'" . mysqli_real_escape_string($con, $value) . "'";
    } else {
        $value = intval($value);
    }
    return $value;
}

$uagent = $_SERVER['HTTP_USER_AGENT'];
$IP = $_SERVER['REMOTE_ADDR'];
echo "<br>";
echo 'Your IP ADDRESS is: ' . $IP;
echo "<br>";

// Take the variables
if (isset($_POST['uname']) && isset($_POST['passwd'])) {
    $uname = check_input($con, $_POST['uname']);
    $passwd = check_input($con, $_POST['passwd']);

    // Logging the connection parameters to a file for analysis.
    $fp = fopen('result.txt', 'a');
    fwrite($fp, 'User Agent:' . $uname . "\n");
    fclose($fp);

    $sql = "SELECT users.username, users.password FROM users WHERE users.username=$uname AND users.password=$passwd ORDER BY users.id DESC LIMIT 0,1";
    $result1 = mysqli_query($con, $sql);
    $row1 = mysqli_fetch_array($result1);

    if ($row1) {
        echo '<font color="#FFFF00" size="3">';
        $insert = "INSERT INTO `security`.`uagents` (`uagent`, `ip_address`, `username`) VALUES ('$uagent', '$IP', $uname)";
        mysqli_query($con, $insert);
        echo "</font>";
        echo '<font color="#0000ff" size="3">';
        echo 'Your User Agent is: ' . $uagent;
        echo "</font>";
        echo "<br>";
        print_r(mysqli_error($con));
        echo "<br><br>";
        echo '<img src="../images/flag.jpg" />';
        echo "<br>";
    } else {
        echo '<font color="#0000ff" size="3">';
        print_r(mysqli_error($con));
        echo "<br><br>";
        echo '<img src="../images/slap.jpg" />';
        echo "</font>";
    }
}
?>

</font>
</div>
</body>
</html>
