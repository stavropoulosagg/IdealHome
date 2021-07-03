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
<li><a href="contracts1.php" style="background-color:#E0E0E0">Συγκεντρωτικός πίνακας</a></li>
<li><a href="contracts2.php">Προσθήκη συμβολαίου</a></li>
</ul>
</div>
</br>

<?php

if(isset($_POST['update'])){
	$updateQuery1="UPDATE Contracts 
	SET Rent='$_POST[rent]', PaymentType='$_POST[pt]', RentStart='$_POST[rs]',RentFinish='$_POST[rf]'
	WHERE ContractNo='$_POST[hidden]'";
	mysql_query($updateQuery1,$con);
}

if(isset($_POST['delete'])){
	$deleteQuery1="DELETE FROM Contracts WHERE ContractNo='$_POST[hidden]'";
	mysql_query($deleteQuery1,$con);
}

$sql="SELECT Contracts.*,Clients.FirstName,Clients.LastName,Properties.AddrStreetName, Properties.AddrStreetNo 
FROM Contracts,Clients,Properties 
WHERE Contracts.ClientRegistrationNo = Clients.ClientRegistrationNo AND 
	  Contracts.PropertyRegistrationNo=Properties.PropertyRegistrationNo";
$data=mysql_query($sql,$con);
echo"
<table width='95%'>
<tr style='background-color:#FFFFF0'>
<th width='5%'>#</th>
<th width='12%'>Μισθωτής</th>
<th width='20%'>Στέγη</th>
<th width='7%'>Μίσθωμα</th>
<th width='30%'>Τρόπος πληρωμής</th>
<th width='7%'>Έναρξη</th>
<th width='7%'>Λήξη</th>
</tr>";

while ($record=mysql_fetch_array($data)){
	echo"<form action='contracts1.php' method='POST'>
	<tr>
	<td>$record[ContractNo]</td>
	<td>".$record['FirstName']." ". $record['LastName']."</td>
	<td>".$record['AddrStreetName']." ". $record['AddrStreetNo']."</td>
	<td><input type='text' name='rent' value='$record[Rent]'/></td>
	<td><input type='text' name='pt' value='$record[PaymentType]'/></td>
	<td><input type='date' name='rs' value='$record[RentStart]'/></td>
	<td><input type='date' name='rf' value='$record[RentFinish]'/></td>
	<td width='15%'><input type='hidden' name='hidden' value= '$record[ContractNo]'/>
		<input type='submit' name='update' value='ενημέρωση'/>
		<input type='submit' name='delete' value='διαγραφή'/></td>
    </tr>
	</form>";
	}
	
	echo"</table>";
?>
</div>
</body>
</div>
<div id="foot"><footer><p>Copyright © 2015 Ομάδα 4, Βάσεις Δεδομένων</p></footer></div>
</html>