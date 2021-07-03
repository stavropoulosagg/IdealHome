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
<li><a href="properties1.php" >Συγκεντρωτικός πίνακας ακινήτων</a></li>
<li><a href="properties2.php" style="background-color:#E0E0E0">Είδη ακινήτων</a></li>
<li><a href="properties3.php" >Έντυπα προβολής ακινήτων</a></li>
<li><a href="properties4.php"> Επισκέψεις ακινήτων</a></li>
</ul>
</div></br>
<?php
if(isset($_POST['update'])){
		$updateQuery="UPDATE PropertyTypes SET Description='$_POST[desc]', Rooms='$_POST[rooms]'  WHERE PropertyTypeId='$_POST[hidden1]'";
		mysql_query($updateQuery,$con);
	}
	if(isset($_POST['delete'])){
		$deleteQuery="DELETE FROM PropertyTypes WHERE PropertyTypeId='$_POST[hidden1]'";
		mysql_query($deleteQuery,$con);
	}
	if(isset($_POST['add'])){
		$addQuery="INSERT INTO PropertyTypes(Description,Rooms) VALUES ('$_POST[adesc]','$_POST[arooms]')";
		mysql_query($addQuery,$con);
	}


$sql1="select * from PropertyTypes ";
$data1=mysql_query($sql1,$con);
echo "<table width='50%'><caption style='text-align:left'><h3>Τύποι ακινήτων<h3></caption>
	<tr style='background-color:#FFFFF0'>
	<th width='5%'>Κωδικός αριθμός είδους</th>
	<th width='15%'>Περιγραφή</th>
	<th width='10%'>Πλήθος δωματίων</th>
	</tr>";
	while ($record1 = mysql_fetch_array($data1)){
		echo "<form action='properties2.php' method='POST'>
		<tr>
		<td><input type='text' name='pti' value='$record1[PropertyTypeId]'/></td>
		<td><input type='text' name='desc' value='$record1[Description]'/></td>
		<td><input type='text' name='rooms' value='$record1[Rooms]'/></td>
		<td width='10%'>
		<input type='hidden' name='hidden1' value='$record1[PropertyTypeId]'/>
		<input type='submit' name='update' value='μεταβολή'/></td>
		<td width='10%'><input type='submit' name='delete' value='διαγραφή'/></td>
		</tr>
		</form>";
	}
	echo "<form action='properties2.php' method='post'>
	<tr>
	<td></td>
	<td><input type='text' name='adesc'/></td>
	<td><input type='text' name='arooms'/></td>
	<td></td>
	<td>
	<input type='submit' name='add' value='προσθήκη'/></td>
	</tr>
	</form>";
	
	echo "</table>";
	
$sql2="select avg(Properties.Rent) as avgrent,Properties.PropertyTypeId,PropertyTypes.Description,PropertyTypes.Rooms
from PropertyTypes natural join Properties
group by Properties.PropertyTypeId";
$data2=mysql_query($sql2,$con);
echo "<table width='50%'><caption style='text-align:left'><h3>Μέσο μίσθωμα ανά ακίνητο<h3></caption>
	<tr style='background-color:#FFFFF0'>
	<th width='5%'>Κωδικός αριθμός είδους</th>
	<th width='15%'>Περιγραφή</th>
	<th width='10%'>Πλήθος δωματίων</th>
	<th width='10%'>Μέσο μίσθωμα</th>
	</tr>";
while ($record2 = mysql_fetch_array($data2)){
		echo "<tr>
		<td>$record2[PropertyTypeId]</td>
		<td>$record2[Description]</td>
		<td>$record2[Rooms]</td>
		<td>".round($record2['avgrent'],2)."</td>";}
		
		echo"</tr></table>";


?>

</div>
</body>
</div>
<div id="foot"><footer><p>Copyright © 2015 Ομάδα 4, Βάσεις Δεδομένων</p></footer></div>
</html>