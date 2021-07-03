<?php 
header('Content-type: text/html; charset:utf8');
include('inc/header.inc.php');
include('inc/connect.inc.php');
?>
<div id="menu">
<ul>
<li><a href="index.php">ΑΡΧΙΚΗ ΣΕΛΙΔΑ</a></li>
<li><a href="employees1.php">ΥΠΑΛΛΗΛΟΙ</a></li>
<li><a href='properties1.php'>ΑΚΙΝΗΤΑ</a></li>
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
<li><a href="owners2.php" >Τηλεφωνικός κατάλογος</a></li>
<li><a href="owners3.php" style="background-color:#E0E0E0">Προσθήκη εκμισθωτή</a></li>
<li><a href ="owners4.php">Μεταβολή στοιχείων εκμισθωτή</a></li>
</ul>
</div>
</br></br>
<?php
echo"</br></br><form id='form1' method='post' action='owners3.php'>
<fieldset>
<legend>Προσθήκη μισθωτή</legend>
<label for='find'>
<span>Ο εκμισθωτής είναι:</span>
<select name='find'>
<option value='' disabled selected>Επιλέξτε</option>
<option value='1'>Ιδιώτης</option>
<option value='2'>Επιχείρηση</option>
</select>
</label>
	 
<label for='submit1' id='submit'>
<input id='submit1' class='submit' type='submit' name='choose' value='εμφάνιση'/>
</label>
</fieldset></form></br>";


if(isset($_POST['add1'])){
	if(empty($_POST['afm']) or empty($_POST['adrstrname']) or empty($_POST['adrstrno'])or empty($_POST['adrpcode'])or empty($_POST['fname'])or empty($_POST['lname'])){
	echo"<h4>Δεν έχετε συμπληρώσει όλα τα απαραίτητα πεδία. Προσπαθήστε ξανά.";
	}
	else{
		mysql_query("SET AUTOCOMMIT=0;");
		mysql_query("START TRANSACTION;");
		$addQuery1="INSERT INTO Owners (AFM,AddrStreetName,AddrStreetNo,AddrPostalCode)		
		VALUES ('$_POST[afm]','$_POST[adrstrname]','$_POST[adrstrno]','$_POST[adrpcode]')";
		$a1=mysql_query($addQuery1,$con);
		$addQuery2="INSERT INTO PrivateOwners (AFM,FirstName,LastName)		
		VALUES ('$_POST[afm]','$_POST[fname]','$_POST[lname]')" ;
		$a2=mysql_query($addQuery2,$con);
		if($a1 and $a2){
		mysql_query("COMMIT;");}
		else {mysql_query("ROLLBACK;"); echo"<h3>Αποτυχία εγγραφής,υπάρχει ήδη πελάτης με αυτό τον ΑΦΜ.</h3>";}
		mysql_query("SET AUTOCOMMIT=1;");
		if(!empty($_POST['tel1'])){
		$addQuery3="INSERT INTO OwnerPhones(AFM,PhoneNumber) VALUES ('$_POST[afm]','$_POST[tel1]')";
		mysql_query($addQuery3,$con);}
		if(!empty($_POST['tel2'])){
			$addQuery4="INSERT INTO OwnerPhones(AFM,PhoneNumber) VALUES ('$_POST[afm]','$_POST[tel2]')";
			mysql_query($addQuery4,$con);
		}
	}
}

if(isset($_POST['add2'])){
	if(empty($_POST['bafm']) or empty($_POST['badrstrname']) or empty($_POST['badrstrno'])or empty($_POST['badrpcode'])or empty($_POST['bfname'])
		or empty($_POST['blname'])or empty($_POST['kind'])or empty($_POST['bname'])){
	echo"<h4>Δεν έχετε συμπληρώσει όλα τα απαραίτητα πεδία. Προσπαθήστε ξανά.";
	}
	else{
		mysql_query("SET AUTOCOMMIT=0;");
		mysql_query("START TRANSACTION;");
		$addQuery4="INSERT INTO Owners (AFM,AddrStreetName,AddrStreetNo,AddrPostalCode)		
		VALUES ('$_POST[bafm]','$_POST[badrstrname]','$_POST[badrstrno]','$_POST[badrpcode]')";
		$b1=mysql_query($addQuery4,$con);
		$addQuery5="INSERT INTO BusinessOwners (AFM,BusinessName,BusinessType,ContactFirstName,ContactLastName)		
		VALUES ('$_POST[bafm]','$_POST[bname]','$_POST[kind]','$_POST[bfname]','$_POST[blname]')" ;
		$b2=mysql_query($addQuery5,$con);
		if($b1 and $b2){
		mysql_query("COMMIT;");}
		else {mysql_query("ROLLBACK;"); echo"<h3>Αποτυχία εγγραφής</h3>";}
		mysql_query("SET AUTOCOMMIT=1;");
		if(!empty($_POST['btel1'])){
		$addQuery6="INSERT INTO OwnerPhones(AFM,PhoneNumber) VALUES ('$_POST[bafm]','$_POST[btel1]')";
		mysql_query($addQuery6,$con);
		}
		if(!empty($_POST['btel2'])){
		$addQuery7="INSERT INTO OwnerPhones(AFM,PhoneNumber) VALUES ('$_POST[bafm]','$_POST[btel2]')";
		mysql_query($addQuery7,$con);
			}
		}
}

if (isset($_POST['choose'])){
	if($_POST['find']==1){
		echo"<form id='form1' method='post' action='owners3.php'>
<fieldset>
<legend>Προσθήκη νέου ιδιώτη εκμισθωτή</legend>

<label for='fname'>
<span>ΑΦΜ:</span>
<input id='fname' type='text' name='afm' size='20'/>
</label>

<label for='fname'>
<span>Όνομα:</span>
<input id='fname' type='text' name='fname' size='20'/>
</label>

<label for='lname'>
<span>Επίθετο:</span>
<input id='lname' type='text' name='lname' size='20'/>
</label>

<label for='adrstrname'>
<span>Οδός:</span>
<input id='adrstrname' type='text' name='adrstrname' size='20'/>
</label>

<label for='adrstrno'>
<span>Αριθμός:</span>
<input id='' type='text' name='adrstrno' size='20'/>
</label>

<label for='adrpcode'>
<span>Ταχυδρομικός κώδικας:</span>
<input id='adrpcode' type='text' name='adrpcode' size='20'/>
</label>

<label for='tel'>
<span>Τηλέφωνο1:</span>
<input id='tel' type='text' name='tel1' size='20'/>
</label>

<label for='tel'>
<span>Τηλέφωνο2:</span>
<input id='tel' type='text' name='tel2' size='20'/>
</label>

<label for='submit1' id='submit'>
<input id='submit1' class='submit' type='submit' name='add1' value='Προσθήκη'/>
</label>

</fieldset>
</form>";
}
else{
	echo"<form id='form1' method='post' action='owners3.php'>
<fieldset>
<legend>Προσθήκη νέου επαγγελματία εκμισθωτή</legend>

<label for='fname'>
<span>ΑΦΜ:</span>
<input id='fname' type='text' name='bafm' size='20'/>
</label>

<label for='fname'>
<span>Επωνυμία:</span>
<input id='fname' type='text' name='bname' size='20'/>
</label>

<label for='fname'>
<span>Είδος:</span>
<input id='fname' type='text' name='kind' size='20'/>
</label>

<label for='fname'>
<span>Όνομα εκπροσώπου:</span>
<input id='fname' type='text' name='bfname' size='20'/>
</label>

<label for='lname'>
<span>Επίθετο εκπροσώπου:</span>
<input id='lname' type='text' name='blname' size='20'/>
</label>


<label for='adrstrname'>
<span>Οδός:</span>
<input id='adrstrname' type='text' name='badrstrname' size='20'/>
</label>

<label for='adrstrno'>
<span>Αριθμός:</span>
<input id='' type='text' name='badrstrno' size='20'/>
</label>

<label for='adrpcode'>
<span>Ταχυδρομικός κώδικας:</span>
<input id='adrpcode' type='text' name='badrpcode' size='20'/>
</label>

<label for='tel'>
<span>Τηλέφωνο1:</span>
<input id='tel' type='text' name='btel1' size='20'/>
</label>

<label for='tel'>
<span>Τηλέφωνο2:</span>
<input id='tel' type='text' name='btel2' size='20'/>
</label>
<label for='submit1' id='submit'>
<input id='submit1' class='submit' type='submit' name='add2' value='Προσθήκη'/>
</label>

</fieldset>
</form>";}
}
?>
</div>
</body>
</div>
<div id="foot"><footer><p>Copyright © 2015 Ομάδα 4, Βάσεις Δεδομένων</p></footer></div>
</html>