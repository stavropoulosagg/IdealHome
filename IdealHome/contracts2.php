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
<li><a href="owners1.php">ΕΚΜΙΣΘΩΤΕΣ</a></li>
<li><a href="contracts1.php" style="background-color:#E0E0E0">ΣΥΜΒΟΛΑΙΑ</a></li>
</ul>
</div>
</br>
<div id="main">
<div id="menu2">
<ul>
<li><a href="contracts1.php" >Συγκεντρωτικός πίνακας</a></li>
<li><a href="contracts2.php" style="background-color:#E0E0E0">Προσθήκη συμβολαίου</a></li>
</ul>
</div>
</br>

<?php

if(isset($_POST['add'])){
	$query1="SELECT Properties.Rent from Properties where Properties.PropertyRegistrationNo =  '$_POST[prn]' ";
	$data=mysql_query($query1,$con);
	$rec=mysql_fetch_array($data);
	
	if(empty($_POST['rent'])or(empty($_POST['pt'])) or (empty($_POST['rs'])) or (empty($_POST['rf'])))
	{
		echo "</br><h4><font color='red'> Δεν έχετε συμπληρώσει όλα τα υποχρεωτικά πεδία! </h4></font></br>";
    }
	else{
		if ($rec['Rent']<$_POST['rent']){
		echo "<h4><font color='red'>To δηλωθέν μίσθωμα είναι μεγαλύτερο από αυτό της αρχικής καταχώρησης στο σύστημα! Ελέξτε τα στοιχεία της αγγελίας και προσπαθήστε ξανά.</font></h4>"."</br>";}
	else{
$sql3="INSERT INTO Contracts (Rent,PaymentType,RentStart,RentFinish,ClientRegistrationNo,PropertyRegistrationNo)
VALUES('$_POST[rent]','$_POST[pt]','$_POST[rs]','$_POST[rf]','$_POST[crn]','$_POST[prn]')";
mysql_query($sql3,$con);
}}}		

echo"<form id='form1' method='post' action='contracts2.php'>
<fieldset>
<legend>Προσθήκη νέου συμβολαίου</legend>

<label for='rent'>
<span>Μηνιαίο μίσθωμα:</span>
<input id='rent' type='text' name='rent' size='20'/>
</label>

<label for='paytype'>
<span>Τρόπος πληρωμής:</span>
<input id='paytype' type='text' name='pt' size='20'/>
</label>

<label for='rentstart'>
<span>Έναρξη μίσθωσης:</span>
<input id='rentstart' type='date' name='rs' size='20'/>
</label>

<label for='rentfinish'>
<span>Λήξη μίσθωσης:</span>
<input id='rentfinish' type='date' name='rf' size='20'/>
</label>

<label for='crn'>
<span>Στοιχεία πελάτη:</span>
<select name='crn'>
<option value='' disabled selected>Επιλέξτε:</option>";	
$sql1="SELECT Clients.ClientRegistrationNo, Clients.FirstName, Clients.LastName FROM Clients";
$data1=mysql_query($sql1,$con);
while ($record1=mysql_fetch_assoc($data1)){
	$fn=$record1['FirstName'];
	$ln=$record1['LastName'];		
	$rn=$record1['ClientRegistrationNo'];
	echo " <option value='$rn'>".$fn." ".$ln.  "</option>";
}	
echo"</select>
	 </label>

<label for='prn'>
<span>Στοιχεία ακινήτου:</span>
<select name='prn'>
<option value='' disabled selected>Επιλέξτε:</option>";
$sql2="SELECT Properties.AddrStreetName, Properties.AddrStreetNo, Properties.PropertyRegistrationNo FROM Properties  LEFT JOIN Contracts
on Properties.PropertyRegistrationNo=Contracts.PropertyRegistrationNo
where Contracts.PropertyRegistrationNo is null";
$data2=mysql_query($sql2,$con);
while ($record2=mysql_fetch_assoc($data2)){
$prno=$record2['PropertyRegistrationNo'];
$asn=$record2['AddrStreetName'];
$asno=$record2['AddrStreetNo'];
echo " <option value='$prno'>".$asn." ".$asno.  "</option>";
}
echo"</select></label>

<label for='submit1' id='submit'>
<input id='submit1' class='submit' type='submit' name='add' value='Προσθήκη'/>
</label>

</fieldset>
</form>";
			
?>
</div>
</body>
</div>
<div id="foot"><footer><p>Copyright © 2015 Ομάδα 4, Βάσεις Δεδομένων</p></footer></div>
</html>