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
<li><a href="owners2.php" style="background-color:#E0E0E0">Τηλεφωνικός κατάλογος</a></li>
<li><a href='owners3.php'>Προσθήκη εκμισθωτή</a></li>
<li><a href ="owners4.php">Μεταβολή στοιχείων εκμισθωτή</a></li>
</ul>
</div>
</br></br>
<?php

echo"</br></br><form id='form1' method='post' action='owners2.php'>
<fieldset>
<legend>Αναζήτηση τηλεφώνου</legend>
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
</label>";

if (isset($_POST['choose'])){
	if($_POST['find']==1){
		$sql1="SELECT PrivateOwners.FirstName,PrivateOwners.LastName,PrivateOwners.AFM
		FROM PrivateOwners";
		$data1=mysql_query($sql1,$con);
		echo"</br><label for='name'>
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
</label>";}
	else{
	$sql4="SELECT BusinessOwners.BusinessName, BusinessOwners.ContactFirstName,BusinessOwners.ContactLastName,BusinessOwners.AFM from BusinessOwners";
	$data4=mysql_query($sql4,$con);
	echo"</br><label for='name'>
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
</label>";}
	
}
	if (isset($_POST['choose1'])){
	$sql2="SELECT PrivateOwners.FirstName,PrivateOwners.LastName from PrivateOwners where PrivateOwners.AFM='$_POST[pfind]'";
	$data2=mysql_query($sql2,$con);
	$rec2=mysql_fetch_array($data2);
	
	$sql3="SELECT * FROM OwnerPhones where OwnerPhones.AFM='$_POST[pfind]'";
	$data3=mysql_query($sql3,$con);
	
	echo"<label for='lname'>
	<span>".$rec2['FirstName']." ".$rec2['LastName'].":</span>";
	while($rec3=mysql_fetch_array($data3)){
	echo"<input type='text' name='pn' value='$rec3[PhoneNumber]' size='20'/>";
	}
	echo"</label></fieldset></form>";}
	elseif(isset($_POST['choose2'])){
		$sql5="SELECT BusinessOwners.BusinessName, BusinessOwners.ContactFirstName,BusinessOwners.ContactLastName from BusinessOwners where BusinessOwners.AFM ='$_POST[bfind]'";
		$data5=mysql_query($sql5,$con);
		$rec5=mysql_fetch_array($data5);
		
		$sql6="SELECT * FROM OwnerPhones where OwnerPhones.AFM='$_POST[bfind]'";
		$data6=mysql_query($sql6,$con);
		
		echo"<label for='lname'>
	<span>".$rec5['BusinessName']."</br>".$rec5['ContactFirstName']." ".$rec5['ContactLastName'].":</span>";
	while($rec6=mysql_fetch_array($data6)){
		$tno=$rec6['PhoneNumber'];
	echo"<input type='text' name='pn' value='$tno' size='20'/>";
	}}
echo"</label></fieldset></form></br>";


if(isset($_POST['delete'])){
	$deleteQuery1="DELETE FROM OwnerPhones WHERE PhoneNumber='$_POST[hidden1]' AND AFM='$_POST[hidden]'";
mysql_query($deleteQuery1,$con);}


if(isset($_POST['update'])){
	$updateQuery1="UPDATE OwnerPhones SET PhoneNumber='$_POST[PhoneNumber]' WHERE AFM='$_POST[hidden]' AND PhoneNumber='$_POST[hidden1]'";
	mysql_query($updateQuery1,$con);
}

if(isset($_POST['add'])){
	if(empty($_POST['lista'])or(empty($_POST['tel']))){
	echo "</br><h4><font color='red'> Δεν έχετε συμπληρώσει όλα τα υποχρεωτικά πεδία! </h4></font></br>";
    }
	else{
	$add="INSERT INTO OwnerPhones VALUES ('$_POST[tel]','$_POST[lista]')";
	mysql_query($add,$con);
	}
}

$sql7="select BusinessOwners.AFM,BusinessOwners.BusinessName, BusinessOwners.ContactFirstName,BusinessOwners.ContactLastName,OwnerPhones.PhoneNumber
from BusinessOwners natural join OwnerPhones
union
select PrivateOwners.AFM,null as col, PrivateOwners.FirstName,PrivateOwners.LastName,OwnerPhones.PhoneNumber
from PrivateOwners natural join OwnerPhones;";
$data7=mysql_query($sql7,$con);
echo"</br></br>
<table width='80%'>
<caption><h3>Τηλεφωνικός κατάλογος εκμισθωτών</h3></caption>
<tr style='background-color:#FFFFF0'>
<th width='25%'>Επωνυμία επιχείρησης (κενό σε ιδιώτες)</th>
<th width='15%'>Oνοματεπώνυμο</th>
<th width='10%'>Τηλέφωνο</th>
</tr>";

while ($re=mysql_fetch_array($data7)){
	echo"<form action='owners2.php' method='POST'>
	<tr>
	<td>$re[BusinessName]</td>
	<td>".$re['ContactFirstName']." ". $re['ContactLastName']."</td>
	<td><input type='text' name='PhoneNumber' value='$re[PhoneNumber]'/></td>
	<td width='10%'><input type='hidden' name='hidden' value= '$re[AFM]'/>
	<input type='hidden' name='hidden1' value= '$re[PhoneNumber]'/>
	<input type='submit' name='update' value='ενημέρωση'/></td>
	<td width='10%'><input type='submit' name='delete' value='διαγραφή'/></td>
    </tr>
	</form>";
	}
	

	$sql8="select BusinessOwners.AFM,BusinessOwners.BusinessName, BusinessOwners.ContactFirstName,BusinessOwners.ContactLastName
	from BusinessOwners
	union
	select PrivateOwners.AFM,null as col, PrivateOwners.FirstName,PrivateOwners.LastName
	from PrivateOwners";
	$data8=mysql_query($sql8,$con);
	echo"<form action='owners2.php' method='post'>
	<tr>
	<td></td>
	<td><select name='lista'><option value='' disabled selected></option>";
    while ($r = mysql_fetch_array($data8)) {
		$a= $r['AFM'];
		$b=$r['BusinessName'];
		$c=$r['ContactFirstName'];
		$d=$r['ContactLastName'];
		echo " <option value='$a'>".$b." ".$c." ".$d."</option>";
	}	 
	echo "</select></td>
	<td><input type='text' name='tel'/></td>
	<td><input type='submit' name='add' value='προσθήκη'/></td>
	</tr>
	</form>
	</table>";


?>
</div>
</body>
</div>
<div id="foot"><footer><p>Copyright © 2015 Ομάδα 4, Βάσεις Δεδομένων</p></footer></div>
</html>