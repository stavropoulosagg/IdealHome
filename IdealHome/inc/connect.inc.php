<?php
header('Content-type: text/html; charset:utf8');
$con = mysql_connect("localhost","project_admin","123456789");
mysql_query("SET NAMES 'utf8'", $con);
if (!$con){
	die("Could not connect: " . mysql_error());
	}
	mysql_select_db("idealhome",$con);
?>