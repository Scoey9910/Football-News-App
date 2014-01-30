<?php require_once('Connections/loginfootball.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "admin";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_loginfootball, $loginfootball);
$query_qMembers = "SELECT * FROM loginfootball";
$qMembers = mysql_query($query_qMembers, $loginfootball) or die(mysql_error());
$row_qMembers = mysql_fetch_assoc($qMembers);
$totalRows_qMembers = mysql_num_rows($qMembers);


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/style.css" media="screen">
</head>
<body>
<div id="logo">
<img src="img/logo.png" />
</div>
<table width="1100" border="3">
  <caption>
    User Data
  </caption>
  <tr>
    <th width="26" scope="col">Id</th>
    <th width="68" scope="col">Username</th>
    <th width="94" scope="col">Password</th>
    <th width="114" scope="col">Email</th>
    <th width="158" scope="col">FirstName</th>
    <th width="166" scope="col">LastName</th>
    <th width="204" scope="col">Address</th>
    <th width="67" scope="col">State</th>
    <th width="63" scope="col">Zip</th>
    <th width="72" scope="col">Role</th>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="adminUpdate.php?id=<?php echo $row_qMembers['id']; ?>"><?php echo $row_qMembers['id']; ?></a></td>
      <td><?php echo $row_qMembers['username']; ?></td>
      <td><?php echo $row_qMembers['password']; ?></td>
      <td><?php echo $row_qMembers['email']; ?></td>
      <td><?php echo $row_qMembers['first_name']; ?></td>
      <td><?php echo $row_qMembers['last_name']; ?></td>
      <td><?php echo $row_qMembers['address']; ?></td>
      <td><?php echo $row_qMembers['state_code']; ?></td>
      <td><?php echo $row_qMembers['zip_postal']; ?></td>
      <td><?php echo $row_qMembers['role']; ?></td>
    </tr>
    <?php } while ($row_qMembers = mysql_fetch_assoc($qMembers)); ?>
</table>
<p>&nbsp;</p>


</body>
</html>
<?php
mysql_free_result($qMembers);
?>
