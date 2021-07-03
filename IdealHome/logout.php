<?php
session_start();
if(session_destroy()){
header('location:employees2.php');}
?>
