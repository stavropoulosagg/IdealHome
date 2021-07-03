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
<li><a href="properties1.php" style="background-color:#E0E0E0">Συγκεντρωτικός πίνακας ακινήτων</a></li>
<li><a href="properties2.php" >Είδη ακινήτων</a></li>
<li><a href="properties3.php" >Έντυπα προβολής ακινήτων</a></li>
<li><a href="properties4.php"> Επισκέψεις ακινήτων</a></li>
</ul>
</div></br>
<?php
if(isset($_POST['update'])){
	$updateQuery1="UPDATE Properties
	SET Rent='$_POST[rent]'
	WHERE PropertyRegistrationNo='$_POST[hidden]'";
	mysql_query($updateQuery1,$con);
}

if(isset($_POST['delete'])){
	$deleteQuery1="DELETE FROM Properties WHERE PropertyRegistrationNo='$_POST[hidden]'";
	mysql_query($deleteQuery1,$con);
}



echo"<form id='form1' method='post' action='properties1.php'>
<fieldset>
<legend>Αναζήτηση διαθέσιμου ακινήτου</legend>

<label for='minrent'>
<span>Ελάχιστο μηνιαίο μίσθωμα:</span>
<input id='minrent' type='text' name='minrent' size='20'/>
</label>

<label for='maxrent'>
<span>Μέγιστο μηνιαίο μίσθωμα:</span>
<input id='maxrent' type='text' name='maxrent' size='20'/>
</label>

<label for='rooms'>
<span>Πλήθος δωματίων:</span>
<input id='rooms' type='text' name='rooms' size='20'/>
</label>

<label for='pt'>
<span>Τύπος ακινήτου:</span>
<select name='pt'>
<option value='' disabled selected>Επιλέξτε:</option>";	
$sql1="SELECT distinct PropertyTypes.Description FROM PropertyTypes";
$data1=mysql_query($sql1,$con);
while ($record1=mysql_fetch_assoc($data1)){
	$de=$record1['Description'];
	echo "<option value='$de'>$de</option>";
}	
echo"</select>
	 </label>

<label for='submit1' id='submit'>
<input id='submit1' class='submit' type='submit' name='search' value='αναζήτηση'/>
</label>

</fieldset>
</form>";


if(isset($_POST['search'])){
	if(empty($_POST['minrent']) or empty($_POST['maxrent']) or empty($_POST['rooms'])or empty($_POST['pt'])){
	echo"<h4>Δεν έχετε συμπληρώσει όλα τα απαραίτητα πεδία. Προσπαθήστε ξανά.";
	}
	else{
$sql2="select Properties.PropertyRegistrationNo as p,Properties.Rent, PropertyTypes.Rooms,PropertyTypes.Description, 
Properties.Floor, Properties.AddrStreetName,Properties.AddrStreetNo
from Properties join PropertyTypes on Properties.PropertyTypeId=PropertyTypes.PropertyTypeId LEFT JOIN Contracts
on Properties.PropertyRegistrationNo=Contracts.PropertyRegistrationNo
where Contracts.PropertyRegistrationNo is null
group by Properties.PropertyRegistrationNo
having PropertyTypes.Rooms='$_POST[rooms]' and Properties.Rent>'$_POST[minrent]' and Properties.Rent<'$_POST[maxrent]' and PropertyTypes.Description='$_POST[pt]'";
$data2=mysql_query($sql2,$con);
if($count=mysql_num_rows($data2)){
echo" 
<table width='70%'>
<tr style='background-color:#FFFFF0'>
<th width='10%'>Κωδικός ακινήτου</th>
<th width='10%'>Ενοίκιο</th>
<th width='10%'>Δωμάτια</th>
<th width='15%'>Είδος</th>
<th width='10%'> Όροφος</th>
<th width='15%'>Διεύθυνση</th>
</tr>";

while($record=mysql_fetch_array($data2)){
	echo"
	<tr>
	<td>$record[p]</td>
	<td>$record[Rent]</td>
	<td>$record[Rooms]</td>
	<td>$record[Description]</td>
	<td>$record[Floor]</td>
	<td>".$record['AddrStreetName'] ." ".$record['AddrStreetNo']."</td>
    </tr>";
	}
	
	echo"</table>";	
}else{echo"Δεν υπάρχει διαθέσιμο ακίνητο με τα χαρακτηριστικά που αναζητάτε.</br>";}
}}

$sql9="select properties.* ,propertyTypes.*,Contracts.PropertyRegistrationNo as cprn
from properties natural join PropertyTypes left outer join Contracts on Properties.PropertyRegistrationNo = Contracts.PropertyRegistrationNo
order by properties.ManagerAFM";
$data9=mysql_query($sql9,$con);
if($count=mysql_num_rows($data9)){
echo" 
<table width='95%'>
<tr style='background-color:#FFFFF0'>
<th width='5%'>Κωδικός ακινήτου</th>
<th width='15%'>Διεύθυνση</th>
<th width='10%'>Επιφάνεια</th>
<th width='5%'>Όροφος</th>
<th width='10%'> Μίσθωμα</th>
<th width='10%'>Είδος ακινήτου</th>
<th width='10%'> ΑΦΜ εκμισθωτή</th>
<th width='15%'>Μεσίτης</th>
<th width='5%'>Αριθμός Συμβολαίου</th>
</tr>";

while($record9=mysql_fetch_array($data9)){
	echo"<form method='post' action='properties1.php'>
	<tr>
	<td>$record9[PropertyRegistrationNo]</td>
	<td>".$record9['AddrStreetName'] ." ".$record9['AddrStreetNo']." ". $record9['AddrPostalCode']."</td>
	<td>$record9[Size]</td>
	<td>$record9[Floor]</td>
	<td><input type='text' name='rent' value='$record9[Rent]'/></td>";
	$sql11="SELECT Description,Rooms from PropertyTypes where PropertyTypeId='$record9[PropertyTypeId]'";
	$data11=mysql_query($sql11,$con);
	$record11=mysql_fetch_Array($data11);
	echo"
	<td>" .$record11['Description']." ".$record11['Rooms']." δωματίου/ων"."</td>
	<td>$record9[OwnerAFM]</td>";
	$sql10="SELECT FirstName,LastName from Employees where AFM='$record9[ManagerAFM]'";
	$data10=mysql_query($sql10,$con);
	$record10=mysql_fetch_Array($data10);
	echo"
	<td>".$record10['FirstName'] ." ".$record10['LastName']."</td>
	<td>$record9[cprn]</td>
	<td width='15%'><input type='hidden' name='hidden' value= '$record9[PropertyRegistrationNo]'/>
	<input type='submit' name='delete' value='διαγραφή'/>
	<input type='submit' name='update' value='ενημέρωση'/></td>
    </tr></form>";
	}
	
	echo"</table>";	
}else{echo"Δεν υπάρχουν καταχωρημένα ακίνητα.";}


?>

</div>
</body>
</div>
<div id="foot"><footer><p>Copyright © 2015 Ομάδα 4, Βάσεις Δεδομένων</p></footer></div>
</html>