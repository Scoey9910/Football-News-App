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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE loginfootball SET username=%s, password=%s, email=%s, first_name=%s, last_name=%s, address=%s, state_code=%s, zip_postal=%s, `role`=%s WHERE id=%s",
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['first_name'], "text"),
                       GetSQLValueString($_POST['last_name'], "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['state_code'], "text"),
                       GetSQLValueString($_POST['zip_postal'], "int"),
                       GetSQLValueString($_POST['role'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_loginfootball, $loginfootball);
  $Result1 = mysql_query($updateSQL, $loginfootball) or die(mysql_error());

  $updateGoTo = "admin.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_qMembersDetails = "-1";
if (isset($_GET['id'])) {
  $colname_qMembersDetails = $_GET['id'];
}
mysql_select_db($database_loginfootball, $loginfootball);
$query_qMembersDetails = sprintf("SELECT * FROM loginfootball WHERE id = %s", GetSQLValueString($colname_qMembersDetails, "int"));
$qMembersDetails = mysql_query($query_qMembersDetails, $loginfootball) or die(mysql_error());
$row_qMembersDetails = mysql_fetch_assoc($qMembersDetails);
$totalRows_qMembersDetails = mysql_num_rows($qMembersDetails);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Football News App</title>
</head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1">
 	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css" media="screen">
    <link rel="stylesheet" type="text/css" href="css/signup.css">
    
<title>Football News App</title>
</head>
<body>
<div id="logo">
<img src="img/logo.png" />
</div>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
  <table align="center">

    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Password:</td>
      <td><input type="text" name="password" value="<?php echo $row_qMembersDetails['password']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Email:</td>
      <td><input type="email" name="email" value="<?php echo $row_qMembersDetails['email']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">First_name:</td>
      <td><input type="text" name="first_name" value="<?php echo $row_qMembersDetails['first_name']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Last_name:</td>
      <td><input type="text" name="last_name" value="<?php echo $row_qMembersDetails['last_name']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Address:</td>
      <td><input type="text" name="address" value="<?php echo $row_qMembersDetails['address']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">State_code:</td>
      <td><input type="text" name="state_code" value="<?php echo $row_qMembersDetails['state_code']; ?>" size="2" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Zip_postal:</td>
      <td><input type="text" name="zip_postal" value="<?php echo $row_qMembersDetails['zip_postal']; ?>" size="5" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><label for="role">Role</label>
        <select name="role" size="1" id="role">
          <option value="guest" <?php if (!(strcmp("guest", $row_qMembersDetails['role']))) {echo "selected=\"selected\"";} ?>>Guest</option>
          <option value="admin" <?php if (!(strcmp("admin", $row_qMembersDetails['role']))) {echo "selected=\"selected\"";} ?>>Admin</option>
          <?php
do {  
?>
          <option value="<?php echo $row_qMembersDetails['role']?>"<?php if (!(strcmp($row_qMembersDetails['role'], $row_qMembersDetails['role']))) {echo "selected=\"selected\"";} ?>><?php echo $row_qMembersDetails['role']?></option>
          <?php
} while ($row_qMembersDetails = mysql_fetch_assoc($qMembersDetails));
  $rows = mysql_num_rows($qMembersDetails);
  if($rows > 0) {
      mysql_data_seek($qMembersDetails, 0);
	  $row_qMembersDetails = mysql_fetch_assoc($qMembersDetails);
  }
?>
        </select></td>
      <td><input type="submit" value="Update" />
      <input name="id" type="hidden" id="id" value="<?php echo $row_qMembersDetails['id']; ?>" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
</form>
<p>&nbsp;</p>

</html>
<?php
mysql_free_result($qMembersDetails);
?>
