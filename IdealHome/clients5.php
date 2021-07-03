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
<li><a href="clients1.php" style="background-color:#E0E0E0">ΜΙΣΘΩΤΕΣ</a></li>
<li><a href="owners1.php">ΕΚΜΙΣΘΩΤΕΣ</a></li>
<li><a href="contracts1.php">ΣΥΜΒΟΛΑΙΑ</a></li>
</ul>
</div>
</br>
<div id="main">

<div id="menu2">
<ul>
<li><a href="clients1.php">Συγκεντρωτικός πίνακας</a></li>
<li><a href="clients2.php" >Τηλεφωνικός κατάλογος</a></li>
<li><a href="clients3.php">Προσθήκη τηλεφώνου</a></li>
<li><a href ="clients5.php" style="background-color:#E0E0E0">Μεταβολή στοιχείων μισθωτή</a></li>
</ul>
</div>
</br></br>

<?php

$sql5="SELECT * FROM Clients";
$mydata5=mysql_query($sql5,$con);
echo"<form id='form1' method='post' action='clients5.php'>
<fieldset>
<legend>Αναζήτηση μισθωτή</legend>
<label for='find'>
<span>Μισθωτής</span>
<select name='find'>
<option value='' disabled selected>Επιλέξτε</option>";
	while ($record5 = mysql_fetch_assoc($mydata5)) {
		$regno= $record5['ClientRegistrationNo'];
		$fname2=$record5['FirstName'];
		$lname2=$record5['LastName'];
		echo "<option value='$regno'>".$fname2." ".$lname2. "</option>";
	}
echo"</select>
	 </label>
	 <label for='submit1' id='submit'>
     <input id='submit1' class='submit' type='submit' name='add3' value='αναζήτηση'/>
     </label></fieldset></form>";
	
	
if (isset($_POST['add3'])){
	$sql6="SELECT * FROM Clients where ClientRegistrationNo='$_POST[find]'";
	$mydata6=mysql_query($sql6,$con);
	$record6=mysql_fetch_assoc($mydata6);
	echo"<form id='form1' method='post' action='clients5.php'>
	<fieldset>
	<legend>Μεταβολή στοιχείων μισθωτή</legend>

	<input type='hidden' name='hidden4' value= '$record6[ClientRegistrationNo]'/>";
	
	$sql8="SELECT Employees.AFM,Employees.FirstName,Employees.LastName FROM Employees WHERE AFM = '$record6[RegisteredBy]'";
	$mydata8=mysql_query($sql8,$con);
	$record8=mysql_fetch_array($mydata8);
	echo"
	<label for='registeredBy'>
	<span>Έχει γίνει εγγραφή από:</span>
	$record8[FirstName] $record8[LastName]
	</label>";
	
	echo"
	<label for='fname'>
	<span>Όνομα:</span>
	<input id='fname' type='text' name='fname2' value='$record6[FirstName]' size='20'/>
	</label>

	<label for='lname'>
	<span>Επίθετο:</span>
	<input id='lname' type='text' name='lname2' value='$record6[LastName]' size='20'/>
	</label>
	
	<label for='adstrname'>
	<span>Οδός:</span>
	<input id='adstrname' type='text' name='adstrname2' value='$record6[AddrStreetName]' size='20'/>
	</label>
	
	<label for='adstrno'>
	<span>Αριθμός:</span>
	<input id='adstrno' type='text' name='adstrno2' value='$record6[AddrStreetNo]' size='20'/>
	</label>
	
	<label for='adspc'>
	<span>Τ. Κ:</span>
	<input id='adpc' type='text' name='adpc2' value='$record6[AddrPostalCode]' size='20'/>
	</label>
	
	<label for='maxrent'>
	<span>Μέγιστο μίσθωμα:</span>
	<input id='maxrent' type='text' name='maxrent2' value='$record6[MaxRent]' size='20'/>
	</label>
	
	<label for='active'>
	<span>Ενεργός/ή:</span>
	<select name='active2'>
	<option value='$record6[Active]' selected>";
	if($record6['Active']=='1'){
	echo "ναι";}
	else {echo "όχι";}
	echo" </option>
	<option value='1' >ναι</option>
	<option value='0'>όχι</option>
	</select>
	</label>";
	
	 
	$sql9="SELECT * FROM PropertyTypes WHERE PropertyTypeId = '$record6[PreferedTypeId]'";
	$mydata9=mysql_query($sql9,$con);
	$record9=mysql_fetch_array($mydata9);
	echo"
	<label for='preferedTypeId'>
	<span>Προτιμώμενος τύπος ακινήτου:</span>
	<select name='preferedTypeId2'>
	<option value='$record6[PreferedTypeId]' selected>"."(".$record6['PreferedTypeId'].") ". $record9['Description']. " - ".$record9['Rooms']."</option>";
	$sql10="SELECT * FROM PropertyTypes";
	$mydata10=mysql_query($sql10,$con);
	while ($record10 = mysql_fetch_assoc($mydata10)) {
		$ptid= $record10['PropertyTypeId'];
		$desc=$record10['Description'];
		$ro=$record10['Rooms'];
		echo " <option value='$ptid'>"."(".$ptid.") ".$desc." - ".$ro.  "</option>";
	}
echo"</select>
	</label>

	<label for='submit1' id='submit'>
	<input id='submit1' class='submit' type='submit' name='update2' value='μεταβολή'/>
	</label>

	</fieldset>
	</form>";
}
if(isset($_POST['update2'])){
	$updateQuery2="UPDATE Clients
	SET FirstName='$_POST[fname2]', LastName='$_POST[lname2]',AddrStreetName='$_POST[adstrname2]', AddrStreetNo='$_POST[adstrno2]',AddrPostalCode='$_POST[adpc2]',MaxRent='$_POST[maxrent2]',Active='$_POST[active2]',RegisteredBy='$_POST[registeredBy2]',PreferedTypeId='$_POST[preferedTypeId2]'
	WHERE ClientRegistrationNo='$_POST[hidden4]'";
	mysql_query($updateQuery2,$con);
}

?>

</div>
</body>
</div>
<div id="foot"><footer><p>Copyright © 2015 Ομάδα 4, Βάσεις Δεδομένων</p></footer></div>
</html>