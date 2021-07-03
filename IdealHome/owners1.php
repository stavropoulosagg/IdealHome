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
<li><a href="owners1.php" style="background-color:#E0E0E0">Συγκεντρωτικός πίνακας</a></li>
<li><a href="owners2.php">Τηλεφωνικός κατάλογος</a></li>
<li><a href='owners3.php'>Προσθήκη εκμισθωτή</a></li>
<li><a href ="owners4.php">Μεταβολή στοιχείων εκμισθωτή</a></li>
</ul>
</div>
</br></br>
<?php
if(isset($_POST['delete'])){
	$deleteQuery1="DELETE FROM Owners WHERE AFM='$_POST[hidden]'";
	mysql_query($deleteQuery1,$con);
}
if(isset($_POST['delete2'])){
	$deleteQuery2="DELETE FROM Owners WHERE AFM='$_POST[hidden2]'";
	mysql_query($deleteQuery2,$con);
}

$sql="SELECT * FROM Owners natural join PrivateOwners";
$data=mysql_query($sql,$con);
echo"
<table width='70%'>
<caption><h3>Συγκεντρωτικός πίνακας ιδιωτών ιδιοκτητών</h3></caption>
<tr style='background-color:#FFFFF0'>
<th width='10%'>ΑΦΜ</th>
<th width='30%'>Ονοματεπώνυμο</th>
<th width='40%'>Στοιχεία κατοικίας</th>
</tr>";

while ($record=mysql_fetch_array($data)){
	echo"<form action='owners1.php' method='POST'>
	<tr>
	<td>$record[AFM]</td>
	<td>".$record['FirstName']." ". $record['LastName']."</td>
	<td>".$record['AddrStreetName']." ". $record['AddrStreetNo'].", ".$record['AddrPostalCode']."</td>
	<td width='15%'><input type='hidden' name='hidden' value= '$record[AFM]'/>
		<input type='submit' name='delete' value='διαγραφή'/></td>
    </tr>
	</form>";
	}
	
	echo"</table>";

$sql1="SELECT * FROM Owners natural join BusinessOwners";
$data1=mysql_query($sql1,$con);
echo"</br></br>
<table width='95%'>
<caption><h3>Συγκεντρωτικός πίνακας επαγγελματιών ιδιοκτητών</h3></caption>
<tr style='background-color:#FFFFF0'>
<th width='10%'>ΑΦΜ</th>
<th width='20%'>Επωνυμία</th>
<th width='20%'>Είδος</th>
<th width='20%'>Στοιχεία εκπροσώπου</th>
<th width='20%'>Στοιχεία έδρας</th>
</tr>";

while ($record1=mysql_fetch_array($data1)){
	echo"<form action='owners1.php' method='POST'>
	<tr>
	<td>$record1[AFM]</td>
	<td>$record1[BusinessName]</td>
	<td>$record1[BusinessType]</td>
	<td>".$record1['ContactFirstName']." ". $record1['ContactLastName']."</td>
	<td>".$record1['AddrStreetName']." ". $record1['AddrStreetNo'].", ".$record1['AddrPostalCode']."</td>
	<td width='15%'><input type='hidden' name='hidden2' value= '$record1[AFM]'/>
		<input type='submit' name='delete2' value='διαγραφή'/></td>
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