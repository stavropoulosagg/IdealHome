<?php 
header('Content-type: text/html; charset:utf8');
include('inc/header.inc.php');
include('inc/connect.inc.php');
?>
<div id="menu">
<ul>
<li><a href="index.php">ΑΡΧΙΚΗ ΣΕΛΙΔΑ</a></li>
<li><a href="employees1.php" >ΥΠΑΛΛΗΛΟΙ</a></li>
<li><a href="properties1.php" style="background-color:#E0E0E0">ΑΚΙΝΗΤΑ</a></li>
<li><a href="clients1.php">ΜΙΣΘΩΤΕΣ</a></li>
<li><a href="owners1.php">ΕΚΜΙΣΘΩΤΕΣ</a></li>
<li><a href="contracts1.php">ΣΥΜΒΟΛΑΙΑ</a></li>
</ul>
</div>
</br>
<div id="main">

<div id="menu2">
<ul>
<li><a href="properties1.php">Συγκεντρωτικός πίνακας ακινήτων</a></li>
<li><a href="properties2.php" >Είδη ακινήτων</a></li>
<li><a href="properties3.php" >Έντυπα προβολής ακινήτων</a></li>
<li><a href="properties4.php" style="background-color:#E0E0E0">Επισκέψεις ακινήτων</a></li>
</ul>
</div></br>
<?php


if(isset($_POST['add'])){
	
	if(empty($_POST['rs'])or(empty($_POST['crn'])) or (empty($_POST['prn'])))
	{
		echo "</br><h4><font color='red'> Δεν έχετε συμπληρώσει όλα τα υποχρεωτικά πεδία! </h4></font></br>";
    }
	else{

$sql3="INSERT INTO Visits (ClientRegistrationNo,PropertyRegistrationNo,DateofVisit)
VALUES('$_POST[crn]','$_POST[prn]','$_POST[rs]')";
mysql_query($sql3,$con);
}}	

$sql4="select p.PropertyRegistrationNo,p.AddrStreetName,p.AddrStreetNo,p.Floor,p.visitsPerProperty,p.FirstName,p.LastName,null as col,p.PrFirstName,p.PrLastName 
from prop_private as p
LEFT outer JOIN Contracts
on p.PropertyRegistrationNo=Contracts.PropertyRegistrationNo
where Contracts.PropertyRegistrationNo is null
union
select b.PropertyRegistrationNo,b.AddrStreetName,b.AddrStreetNo,b.Floor,b.visitsPerProperty,b.FirstName,b.LastName,b.BusinessName,b.ContactFirstName,b.ContactLastName 
from prop_bus as b
LEFT outer JOIN Contracts
on b.PropertyRegistrationNo=Contracts.PropertyRegistrationNo
where Contracts.PropertyRegistrationNo is null";
$data4=mysql_query($sql4,$con);
if($count=mysql_num_rows($data4)){
echo" 
<table width='90%'><caption style='text-align:left'><h3>Ελεύθερα ακίνητα με επισκέψεις<h3></caption>
<tr style='background-color:#FFFFF0'>
<th width='10%'>Κωδικός ακινήτου</th>
<th width='10%'>Διεύθυνση</th>
<th width='10%'>Όροφος</th>
<th width='25%'>Ονοματεπώνυμο εκμισθωτή</th>
<th width='20%'>Ονοματεπώνυμο μεσίτη</th>
<th width='10%'>Επισκέψεις</th>
</tr>";

while($record4=mysql_fetch_array($data4)){
	echo"
	<tr>
	<td>$record4[PropertyRegistrationNo]</td>
	<td>".$record4['AddrStreetName'] ." ".$record4['AddrStreetNo']."</td>
	<td>$record4[Floor]</td>
	<td>".$record4['col']." ".$record4['PrFirstName']." ".$record4['PrLastName']."</td>
	<td>".$record4['FirstName']." ".$record4['LastName']."</td>
	<td>$record4[visitsPerProperty]</td>
	
    </tr>";
	}
	
	echo"</table>";	
}



echo"</br><form id='form1' method='post' action='properties4.php'>
<fieldset>
<legend>Προσθήκη επίσκεψης ακινήτου</legend>

<label for='dov'>
<span>Ημερομηνία επίσκεψης:</span>
<input id='dov' type='date' name='rs' size='20'/>
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