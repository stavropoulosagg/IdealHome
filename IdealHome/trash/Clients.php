<?php 
header('Content-type: text/html; charset:utf8');
include('inc/header.inc.php');
include('inc/connect.inc.php');
?>
<div id="menu">
<ul>
<li id="1"><a href="index.php">ΑΡΧΙΚΗ ΣΕΛΙΔΑ</a></li>
<li id="2"><a href="#">ΥΠΑΛΛΗΛΟΙ</a></li>
<li id="3"><a href='#'>ΑΚΙΝΗΤΑ</a></li>
<li id="4"><a href="Clients.php" style="background-color:#E0E0E0">ΜΙΣΘΩΤΕΣ</a></li>
<li id="5"><a href="#">ΕΚΜΙΣΘΩΤΕΣ</a></li>
<li id="6"><a href="#">ΣΥΜΒΟΛΑΙΑ</a></li>
</ul>
</div>
</br>
<div id="main">

<div id="menu2">
<ul>
<li><a href="clients1.php">Συγκεντρωτικός πίνακας</a></li>
<li><a href="clients2.php">Τηλεφωνικός κατάλογος</a></li>
<li><a href="clients3.php">Προσθήκη τηλεφώνου</a></li>
<li><a href ="clients4.php">Προσθήκη μισθωτή</a></li>
<li><a href ="clients5.php">Μεταβολή στοιχείων μισθωτή</a></li>
</ul>
</div>

<?php
$Displayform=True;
/*ενημέρωση,διαγραφή,μεταβολή πινάκων */

if(isset($_POST['update1'])){
	$updateQuery1="UPDATE ClientPhones SET PhoneNumber='$_POST[PhoneNumber]' WHERE ClientRegistrationNo='$_POST[hidden1]' AND PhoneNumber='$_POST[hidden2]'";
	mysql_query($updateQuery1,$con);
}

if(isset($_POST['delete1'])){
	$deleteQuery1="DELETE FROM ClientPhones WHERE ClientRegistrationNo='$_POST[hidden1]' AND PhoneNumber='$_POST[hidden2]'";
	mysql_query($deleteQuery1,$con);
}

if(isset($_POST['delete2'])){
	$deleteQuery2="DELETE FROM Clients WHERE ClientRegistrationNo='$_POST[hidden3]'";
	mysql_query($deleteQuery2,$con);
}

if(isset($_POST['add1'])){
	$addQuery1="INSERT INTO ClientPhones VALUES ('$_POST[list]','$_POST[aPhoneNumber]')";
	mysql_query($addQuery1,$con);
}
	
$Displayform=True;
if(isset($_POST['add2'])){
		$dat=date("Y-m-d");
		$addQuery2="INSERT INTO clients (FirstName,LastName,AddrStreetName,AddrStreetNo,AddrPostalCode,RegistrationDate,MaxRent,Active,RegisteredBy,PreferedTypeID)		
		VALUES ('$_POST[fname]','$_POST[lname]','$_POST[adrstrname]','$_POST[adrstrno]','$_POST[adrpcode]',now(),'$_POST[maxrent]','$_POST[active]','$_POST[registeredBy]','$_POST[preferedTypeId]')";
		mysql_query($addQuery2,$con);
}
if($Displayform){
	
/*ΠΡΩΤΟΣ ΠΙΝΑΚΑΣ*/
	$sql3="SELECT * FROM Clients";
	$mydata3 = mysql_query($sql3,$con);
	echo "<table><caption style='text-align:left'><h3>Συγκεντρωτικός πίνακας μισθωτών<h3></caption>
	<tr style='background-color:#FFFFF0'>
	<th width='5%'>Αριθμός Εγγραφής</th>
	<th width='25%'>Ονοματεπώνυμο</th>
	<th width='20%'>Διεύθυνση</th>
	<th width='10%'>Ημερομηνία εγγραφής</th>
	<th width='5%'>Μέγιστο μίσθωμα</th>
	<th width='5%'>Ενεργός</th>
	<th width='5%'>Ανάληψη από</th>
	<th width='5%'>Προτιμώμενη στέγη</th>
	</tr>";
	while ($record3 = mysql_fetch_array($mydata3)){
		echo "<form action='clients.php' method='POST'>
		<tr>
		<td>$record3[ClientRegistrationNo]</td>
		<td>$record3[FirstName] $record3[LastName]</td>
		<td>$record3[AddrStreetName] $record3[AddrStreetNo] $record3[AddrPostalCode]</td>
		<td>$record3[RegistrationDate]</td>
		<td>$record3[MaxRent]</td>
		<td>";if($record3['Active']=='1'){echo "ναι";} else {echo "όχι";} echo"</td>
		<td>$record3[RegisteredBy]</td>
		<td>$record3[PreferedTypeId]</td>
		<td width='15%'><input type='hidden' name='hidden3' value= '$record3[ClientRegistrationNo]'/><input type='submit' name='delete2' value='διαγραφή'/></td>";
	}
	echo"</tr></form></table>";
	
	
	
/*ΔΕΥΤΕΡΟΣ ΠΙΝΑΚΑΣ*/
	$sql1="SELECT Clients.ClientRegistrationNo, Clients.FirstName, Clients.LastName, ClientPhones.PhoneNumber FROM Clients natural join ClientPhones";
	$mydata1 = mysql_query($sql1,$con);
	echo "<table width='70%'>
	<caption style='text-align:left'><h3>Συγκεντρωτικός πίνακας τηλεφώνων<h3></caption>
	<tr style='background-color:#FFFFF0'>
	<th width='15%'>Αριθμός Εγγραφής</th>
	<th width='30%'>Ονοματεπώνυμο</th>
	<th width='25%'>Τηλέφωνο</th>
	</tr>";
	while ($record1 = mysql_fetch_array($mydata1)){
	echo "<form action='clients.php' method='POST'>
	<tr>
	<td>$record1[ClientRegistrationNo]</td>
	<td>$record1[FirstName] $record1[LastName]</td>
	<td><input type='text' name='PhoneNumber' value='$record1[PhoneNumber]'/></td>
	<td width='15%'><input type='hidden' name='hidden1' value= '$record1[ClientRegistrationNo]'/>
	<input type='hidden' name='hidden2' value= '$record1[PhoneNumber]'/>
	<input type='submit' name='update1' value='ενημέρωση'/></td>
	<td width='15%'><input type='submit' name='delete1' value='διαγραφή'/>
	</td>
	</tr>
	</form>";
	}
	echo "</table></br>";
	
/*ΤΡΙΤΟΣ ΠΙΝΑΚΑΣ*/
	$sql2="SELECT Clients.ClientRegistrationNo, Clients.LastName, Clients.FirstName FROM Clients";
	$mydata2=mysql_query($sql2,$con);
	echo "<table width='50%'>
	<caption style='text-align:left'><h3>Προσθήκη νέου τηλεφώνου<h3></caption>
	<tr style='background-color:#FFFFF0'>
	<th>Ονοματεπώνυμο μισθωτή</th>
	<th>Τηλέφωνο</th>
	</tr>";
    echo "<form action ='clients.php' method='POST'>
	<tr>
	<td><select name='list'><option value='' disabled selected>Επιλέξτε</option>";
    while ($record2 = mysql_fetch_array($mydata2)) {
		$RNo= $record2['ClientRegistrationNo'];
		$lname=$record2['LastName'];
		$fname=$record2['FirstName'];
		echo " <option value='$RNo'>".$fname." ".$lname."</option>";
	}	 
	echo "</select></td>
	<td><input type='text' name='aPhoneNumber'/></td>
	<td width='20%'><input type='submit' name='add1' value='προσθήκη'/></td>
	</tr>
	</form>
	</table>
	</br></br>";


	
/*φορμα προσθήκης*/

echo"<form id='form1' method='post' action='clients.php'>
<fieldset>
<legend>Προσθήκη νέου μισθωτή</legend>

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

<label for='maxrent'>
<span>Μέγιστο μίσθωμα:</span>
<input id='maxrent' type='text' name='maxrent' size='20'/>
</label>

<label for='active'>
<span>Ενεργός/ή:</span>
<select name='active'>
<option value='' disabled selected>Επιλέξτε</option>
<option value='1'>ναι</option>
<option value='0'>όχι</option>
</select>
</label>

<label for='registeredBy'>
<span>Έχει γίνει εγγραφή από:</span>
<select name='registeredBy'>
<option value='' disabled selected>Επιλέξτε</option>";

$sql3="SELECT Employees.AFM,Employees.FirstName,Employees.LastName FROM Employees";
	$mydata3=mysql_query($sql3,$con);
	while ($record3 = mysql_fetch_assoc($mydata3)) {
		$afm= $record3['AFM'];
		$fname=$record3['FirstName'];
		$lname=$record3['LastName'];
		echo "<option value='$afm'>" .$afm ." ".$fname." ".$lname. "</option>";
	}
echo"</select>

</label>
<label for='preferedTypeId'>
<span>Προτιμώμενος τύπος ακινήτου:</span>
<select name='preferedTypeId'>
<option value='' disabled selected>Επιλέξτε</option>";

$sql4="SELECT * FROM PropertyTypes";
	$mydata4=mysql_query($sql4,$con);
	while ($record4 = mysql_fetch_assoc($mydata4)) {
		$ptid= $record4['PropertyTypeId'];
		$desc=$record4['Description'];
		$ro=$record4['Rooms'];
		echo " <option value='$ptid'>".$ptid.". ".$desc." - ".$ro. "</option>";
	}
echo"</select>
	</label>

<label for='submit1' id='submit'>
<input id='submit1' class='submit' type='submit' name='add2' value='Προσθήκη'/>
</label>

</fieldset>
</form>";
}
/* φόρμα μεταβολής στοιχείων πελατών*/

$sql5="SELECT * FROM Clients";
$mydata5=mysql_query($sql5,$con);
echo"<form id='form1' method='post' action='Clients.php'>
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
	echo"<form id='form1' method='post' action='Clients.php'>
	<fieldset>
	<legend>Μεταβολή στοιχείων μισθωτή</legend>

	<input type='hidden' name='hidden4' value= '$record6[ClientRegistrationNo]'/>
	
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
	
	$sql8="SELECT Employees.AFM,Employees.FirstName,Employees.LastName FROM Employees WHERE AFM = '$record6[RegisteredBy]'";
	$mydata8=mysql_query($sql8,$con);
	$record8=mysql_fetch_array($mydata8);
	echo"
	<label for='registeredBy'>
	<span>Έχει γίνει εγγραφή από:</span>
	<select name='registeredBy2'>
	<option value='$record6[RegisteredBy]' selected>".$record6['RegisteredBy']." ".$record8['FirstName']." ".$record8['LastName']."</option>";
	$sql7="SELECT Employees.AFM,Employees.FirstName,Employees.LastName FROM Employees";
	$mydata7=mysql_query($sql7,$con);
	while ($record7 = mysql_fetch_assoc($mydata7)){
		$afm= $record7['AFM'];
		$fname=$record7['FirstName'];
		$lname=$record7['LastName'];
		echo "<option value='$afm'>" .$afm ." ".$fname." ".$lname. "</option>";
	}
echo"</select>
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
</div>
</body>
<footer></br></br></br></footer>
</html>