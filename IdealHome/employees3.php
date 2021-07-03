<?php 
header('Content-type: text/html; charset:utf8');
include('inc/header.inc.php');
include('inc/connect.inc.php');
session_start();
if(!isset($_SESSION['afm'])){
}
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
<li><a href="logout.php">Έξοδος από προσωποποιημένη πληροφόρηση</a></li>
</ul>
</div></br>
<div id="menu3">
<ul>
<li><a href="employees3.php" style="background-color:#E0E0E0">Μεταβολή προσωπικών στοιχείων</a></li>
<li><a href="employees4.php" >Οι Υφιστάμενοί μου</a></li>
<li><a href="employees5.php" >Τα ακίνητά μου</a></li>
<li><a href="employees6.php"  >Οι Μισθωτές μου</a></li>
</ul>
</div>
</br></br>
<?php
if(isset($_POST['submit1'])){
	$sql2="UPDATE employees 
	SET FirstName='$_POST[name]', LastName='$_POST[surname]', AddrStreetName='$_POST[adrstrname]', AddrStreetNo='$_POST[adrstrnο]',
	AddrPostalCode='$_POST[adrpc]', MobilePhoneNumber='$_POST[mpn]' 
	where AFM='$_POST[hidden1]'";
	mysql_query($sql2,$con);
	}

$sql1="SELECT e1.*,e2.FirstName as sfn, e2.LastName as sln from employees as e1, employees as e2 where e1.AFM='$_SESSION[afm]' and e2.AFM=e1.SupervisorAFM";
$data1=mysql_query($sql1,$con);
$rec1=mysql_fetch_array($data1);
echo" 
<form id='form1' method='post' action='employees3.php'>
<fieldset>
<legend>Τα προσωπικά μου στοιχεία</legend>

<label for='fname'>
<span>ΑΦΜ:</span>
$rec1[AFM]
</label>

<label for='adrstrnο'>
<span>Mισθός:</span>
€ $rec1[Salary]
</label>

<label for='adrstrnο'>
<span>Προϊστάμενος/η:</span>
$rec1[sfn] $rec1[sln]
</label>

<label for='fname'>
<span>Όνομα:</span>
<input id='fname' type='text' name='name' value='$rec1[FirstName]' size='20'/>
</label>

<label for='lname'>
<span>Επίθετο:</span>
<input id='lname' type='text' name='surname' value='$rec1[LastName]' size='20'/>
</label>

<label for='adrstrname'>
<span>Όδος:</span>
<input id='adrstrname' type='text' name='adrstrname' value='$rec1[AddrStreetName]' size='20'/>
</label>

<label for='adrstrnο'>
<span>Αριθμός:</span>
<input id='adrstrnο' type='text' name='adrstrnο' value='$rec1[AddrStreetNo]' size='20'/>
</label>

<label for='adrstrnο'>
<span>T. K:</span>
<input id='adrstrnο' type='text' name='adrpc' value='$rec1[AddrPostalCode]' size='20'/>
</label>


<label for='adrstrname'>
<span>Κινητό τηλέφωνο:</span>
<input id='adrstrname' type='text' name='mpn' value='$rec1[MobilePhoneNumber]' size='20'/>
</label>

<input type='hidden' name='hidden1' value='$rec1[AFM]'/>

<label for='submit1' id='submit'>
<input id='submit1' class='submit' type='submit' name='submit1' value='μεταβολή'/>
</label>

</fieldset>
</form>";




?>

</div>
</body>
</div>
<div id="foot"><footer><p>Copyright © 2015 Ομάδα 4, Βάσεις Δεδομένων</p></footer></div>
</html>