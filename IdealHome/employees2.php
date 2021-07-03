<?php 
header('Content-type: text/html; charset:utf8');
include('inc/header.inc.php');
include('inc/connect.inc.php');
session_start();
if(isset($_SESSION['afm'])){
header('location:employees3.php');}
?>
<div id="menu">
<ul>
<li><a href="index.php">ΑΡΧΙΚΗ ΣΕΛΙΔΑ</a></li>
<li><a href="employees1.php" style="background-color:#E0E0E0">ΥΠΑΛΛΗΛΟΙ</a></li>
<li><a href="properties1.php">ΑΚΙΝΗΤΑ</a></li>
<li><a href="clients1.php">ΜΙΣΘΩΤΕΣ</a></li>
<li><a href="owners1.php">ΕΚΜΙΣΘΩΤΕΣ</a></li>
<li><a href="contracts1.php">ΣΥΜΒΟΛΑΙΑ</a></li>
</ul>
</div>
</br>
<div id="main">

<div id="menu2">
<ul>
<li><a href="employees1.php" >Συγκεντρωτικός πίνακας</a></li>
<li><a href="employees8.php" >Στατιστικά στοιχεία υπαλλήλων</a></li>
<li><a href="employees2.php" style="background-color:#E0E0E0">Προσωποποιημένη πληροφόρηση</a></li>
</ul>
</div>
</br></br>
<?php
$DisplayForm=True;
$DisplayForm2=True;
if(isset($_POST['submit']))
{
	if(empty($_POST['name'])or(empty($_POST['surname']))or(empty($_POST['afm'])))
	{
		$DisplayForm=True;
		echo "<h4> Δεν έχετε συμπληρώσει όλα τα υποχρεωτικά πεδία. </h4></br>";
	}
	else{
		$query1="SELECT e.FirstName,e.LastName,e.AFM from Employees as e where e.FirstName='$_POST[name]' and e.LastName='$_POST[surname]' and e.AFM='$_POST[afm]'";
		$data1=mysql_query($query1,$con);
		if($count=mysql_num_rows($data1)){
		while($row1=mysql_fetch_array($data1)){
		}
		$_SESSION['afm']=$_POST['afm'];
		header('location:employees3.php');
		exit();
		}else{
		$DisplayForm=True;
		echo"<h4>Δεν υπάρχει εργαζόμενος με τα στοιχεία που πληκτρολογήσατε. Προσπαθείστε ξανά.</h4>";
		}
}}
	
	
if ($DisplayForm)
{
?>
<form id='form1' method='post' action='employees2.php'>
<fieldset>
<legend>Είσοδος</legend>

<label for='fname'>
<span>Όνομα:</span>
<input id='fname' type='text' name='name' size='20'/>
</label>

<label for='lname'>
<span>Επίθετο:</span>
<input id='lname' type='text' name='surname' size='20'/>
</label>

<label for='adrstrname'>
<span>ΑΦΜ:</span>
<input id='adrstrname' type='text' name='afm' size='20'/>
</label>

<label for='submit1' id='submit'>
<input id='submit1' class='submit' type='submit' name='submit' value='Εμφάνιση'/>
</label>

</fieldset>
</form>
<?php

}
?>









</div>
</body>
</div>
<div id="foot"><footer><p>Copyright © 2015 Ομάδα 4, Βάσεις Δεδομένων</p></footer></div>
</html>