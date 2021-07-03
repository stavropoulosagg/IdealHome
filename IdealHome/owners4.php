<?php 
header('Content-type: text/html; charset:utf8');
include('inc/header.inc.php');
include('inc/connect.inc.php');
?>
<div id="menu">
<ul>
<li><a href="index.php">ΑΡΧΙΚΗ ΣΕΛΙΔΑ</a></li>
<li><a href="employees1.php">ΥΠΑΛΛΗΛΟΙ</a></li>
<li><a href="properties1.php">ΑΚΙΝΗΤΑ</a></li>
<li><a href="clients1.php">ΜΙΣΘΩΤΕΣ</a></li>
<li><a href="owners1.php"style="background-color:#E0E0E0">ΕΚΜΙΣΘΩΤΕΣ</a></li>
<li><a href="contracts1.php">ΣΥΜΒΟΛΑΙΑ</a></li>
</ul>
</div>
</br>
<div id="main">

<div id="menu2">
<ul>
<li><a href="owners1.php">Συγκεντρωτικός πίνακας</a></li>
<li><a href="owners2.php">Τηλεφωνικός κατάλογος</a></li>
<li><a href="owners3.php">Προσθήκη εκμισθωτή</a></li>
<li><a href ="owners4.php" style="background-color:#E0E0E0">Μεταβολή στοιχείων εκμισθωτή</a></li>
</ul>
</div>
</br></br>
<?php
$Display=True;
if($Display){
echo"</br></br>
<form id='form1' method='post' action='owners4.php'>
<fieldset>
<legend>Μεταβολή στοιχείων μισθωτή</legend>
<label for='find'>
<span>Εκμισθωτής:</span>
<select name='find'>
<option value='' disabled selected>Επιλέξτε</option>
<option value='1'>Ιδιώτης</option>
<option value='2'>Επιχείρηση</option>
</select>
</label>
	 
<label for='submit1' id='submit'>
<input id='submit1' class='submit' type='submit' name='choose' value='Eμφάνιση'/>
</label></fieldset></form>";}

if (isset($_POST['choose'])){
	if($_POST['find']==1){
		$sql1="SELECT PrivateOwners.FirstName,PrivateOwners.LastName,PrivateOwners.AFM
		FROM PrivateOwners";
		$data1=mysql_query($sql1,$con);
		echo"</br>
		<form id='form1' method='post' action='owners4.php'>
		<fieldset>
		<legend>Επιλογή μισθωτή</legend>
		<label for='find'>
		<span>Επιλέξτε ιδιώτη:</span>
		<select name='pfind'>
		<option value='' disabled selected>Επιλέξτε</option>";
		while($rec1=mysql_fetch_array($data1)){
			$afm=$rec1['AFM'];
			$fname=$rec1['FirstName'];
			$lname=$rec1['LastName'];
		echo "<option value='$afm'>".$fname." ".$lname. "</option>";}
		echo"</select></label>
		<label for='submit2' id='submit'>
		<input id='submit2' class='submit' type='submit' name='choose1' value='αναζήτηση'/>
	</label></fieldset></form></br>";}
	else{
	$sql4="SELECT BusinessOwners.BusinessName, BusinessOwners.ContactFirstName,BusinessOwners.ContactLastName,BusinessOwners.AFM from BusinessOwners";
	$data4=mysql_query($sql4,$con);
	echo"</br>
		<form id='form1' method='post' action='owners4.php'>
		<fieldset>
		<legend>Επιλογή μισθωτή</legend>
		<label for='find'>
		<span>Επιλέξτε επιχείρηση:</span>
		<select name='bfind'>
		<option value='' disabled selected>Επιλέξτε</option>";
		while($reco=mysql_fetch_array($data4)){
			$bafm=$reco['AFM'];
			$bname=$reco['BusinessName'];
			$bfname=$reco['ContactFirstName'];
			$blname=$reco['ContactLastName'];
		echo "<option value='$bafm'>".$bname.": ".$bfname." ".$blname. "</option>";}
		echo"</select></label>
		<label for='submit2' id='submit'>
		<input id='submit2' class='submit' type='submit' name='choose2' value='αναζήτηση'/>
</label></fieldset></form></br>";}
}

if (isset($_POST['choose1'])){
	$sql2="SELECT * from PrivateOwners natural join Owners where PrivateOwners.AFM='$_POST[pfind]'";
	$data2=mysql_query($sql2,$con);
	$r2=mysql_fetch_assoc($data2);
	echo"<form id='form1' method='post' action='owners4.php'>
<fieldset>
<legend>Μεταβολή στοιχείων ιδιώτη</legend>
<input type='hidden' name='hiddena' value= '$r2[AFM]'/>
<label for='fname'>
<span>ΑΦΜ:</span>
$r2[AFM]
</label>

<label for='fname'>
<span>Όνομα:</span>
<input id='fname' type='text' name='fname' value='$r2[FirstName]' size='20'/>
</label>

<label for='lname'>
<span>Επίθετο:</span>
<input id='lname' type='text' name='lname' value='$r2[LastName]' size='20'/>
</label>

<label for='adrstrname'>
<span>Οδός:</span>
<input id='adrstrname' type='text' name='adrstrname' value='$r2[AddrStreetName]' size='20'/>
</label>

<label for='adrstrno'>
<span>Αριθμός:</span>
<input id='' type='text' name='adrstrno' value='$r2[AddrStreetNo]' size='20'/>
</label>

<label for='adrpcode'>
<span>Ταχυδρομικός κώδικας:</span>
<input id='adrpcode' type='text' name='adrpcode' value='$r2[AddrPostalCode]' size='20'/>
</label>

<label for='submit1' id='submit'>
<input id='submit1' class='submit' type='submit' name='change1' value='Μεταβολή'/>
</label>
</fieldset>
</form>";}
	
	elseif(isset($_POST['choose2'])){
		$sql3="SELECT * from BusinessOwners natural join Owners where BusinessOwners.AFM ='$_POST[bfind]'";
		$data3=mysql_query($sql3,$con);
		$r3=mysql_fetch_assoc($data3);
		echo"<form id='form1' method='post' action='owners4.php'>
<fieldset>
<legend>Μεταβολή στοιχείων επιχείρησης</legend>
<input type='hidden' name='hiddenb' value= '$r3[AFM]'/>
<label for='fname'>
<span>ΑΦΜ:</span>
$r3[AFM]
</label>

<label for='fname'>
<span>Επωνυμία:</span>
<input id='fname' type='text' name='bname' value='$r3[BusinessName]' size='20'/>
</label>

<label for='fname'>
<span>Είδος:</span>
<input id='fname' type='text' name='kind' value='$r3[BusinessType]' size='20'/>
</label>

<label for='fname'>
<span>Όνομα εκπροσώπου:</span>
<input id='fname' type='text' name='bfname' value='$r3[ContactFirstName]' size='20'/>
</label>

<label for='lname'>
<span>Επίθετο εκπροσώπου:</span>
<input id='lname' type='text' name='blname' value='$r3[ContactLastName]' size='20'/>
</label>


<label for='adrstrname'>
<span>Οδός:</span>
<input id='adrstrname' type='text' name='badrstrname' value='$r3[AddrStreetName]' size='20'/>
</label>

<label for='adrstrno'>
<span>Αριθμός:</span>
<input id='' type='text' name='badrstrno' value='$r3[AddrStreetNo]' size='20'/>
</label>

<label for='adrpcode'>
<span>Ταχυδρομικός κώδικας:</span>
<input id='adrpcode' type='text' name='badrpcode' value='$r3[AddrPostalCode]' size='20'/>
</label>

<label for='submit1' id='submit'>
<input id='submit1' class='submit' type='submit' name='change2' value='Μεταβολή'/>
</label>

</fieldset>
</form>";}

if(isset($_POST['change1'])){
	mysql_query("SET AUTOCOMMIT=0;");
	mysql_query("START TRANSACTION;");
	$updateQuery1="UPDATE Owners
	SET AddrStreetName='$_POST[adrstrname]', AddrStreetNo='$_POST[adrstrno]',AddrPostalCode='$_POST[adrpcode]'
	WHERE AFM='$_POST[hiddena]'";
	$c1=mysql_query($updateQuery1,$con);
	$updateQuery2="UPDATE PrivateOwners
	SET FirstName='$_POST[fname]', LastName='$_POST[lname]'
	WHERE AFM='$_POST[hiddena]'";
	$c2=mysql_query($updateQuery2,$con);
	if($c1 and $c2){
		mysql_query("COMMIT;");}
		else {mysql_query("ROLLBACK;"); echo"<h4>Αποτυχία μεταβολής των στοιχείων της φόρμας.</h4>";}
		mysql_query("SET AUTOCOMMIT=1;");
}
if(isset($_POST['change2'])){
	mysql_query("SET AUTOCOMMIT=0;");
	mysql_query("START TRANSACTION;");
	$updateQuery3="UPDATE Owners
	SET AddrStreetName='$_POST[badrstrname]', AddrStreetNo='$_POST[badrstrno]',AddrPostalCode='$_POST[badrpcode]'
	WHERE AFM='$_POST[hiddenb]'";
	$c3=mysql_query($updateQuery3,$con);
	$updateQuery4="UPDATE BusinessOwners
	SET BusinessName='$_POST[bname]',BusinessType='$_POST[kind]', ContactFirstName='$_POST[bfname]', ContactLastName='$_POST[blname]'
	WHERE AFM='$_POST[hiddenb]'";
	$c4=mysql_query($updateQuery4,$con);
	if($c3 and $c4){
		mysql_query("COMMIT;");}
		else {mysql_query("ROLLBACK;"); echo"<h4>Αποτυχία μεταβολής των στοιχείων της φόρμας.</h4>";}
		mysql_query("SET AUTOCOMMIT=1;");
}



?>
</div>
</body>
</div>
<div id="foot"><footer><p>Copyright © 2015 Ομάδα 4, Βάσεις Δεδομένων</p></footer></div>
</html>