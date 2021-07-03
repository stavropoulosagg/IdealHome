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
<li><a href="properties2.php" >Είδη ακινήτων</a></li>
<li><a href="properties3.php" style="background-color:#E0E0E0">Έντυπα προβολής ακινήτων</a></li>
<li><a href="properties4.php"> Επισκέψεις ακινήτων</a></li>
</ul>
</div></br>
<?php
if(isset($_POST['update'])){
		$updateQuery="UPDATE Newspapers SET NewspaperName='$_POST[nn]'  WHERE NewspaperID='$_POST[hidden1]'";
		mysql_query($updateQuery,$con);
	}
	if(isset($_POST['delete'])){
		$deleteQuery="DELETE FROM Newspapers WHERE NewspaperID='$_POST[hidden1]'";
		mysql_query($deleteQuery,$con);
	}
	if(isset($_POST['add'])){
		$addQuery="INSERT INTO Newspapers(NewspaperName) VALUES ('$_POST[ann]')";
		mysql_query($addQuery,$con);
	}


$sql1="select * from Newspapers ";
$data1=mysql_query($sql1,$con);
echo "<table width='40%'><caption style='text-align:left'><h3>Έντυπα αγγελιών<h3></caption>
	<tr style='background-color:#FFFFF0'>
	<th width='10%'>Κωδικός εντύπου</th>
	<th width='20%'>Επωνυμία</th>
	</tr>";
	while ($record1 = mysql_fetch_array($data1)){
		echo "<form action='properties3.php' method='POST'>
		<tr>
		<td><input type='text' name='nid' value='$record1[NewspaperID]'/></td>
		<td><input type='text' name='nn' value='$record1[NewspaperName]'/></td>
		<td width='10%'>
		<input type='hidden' name='hidden1' value='$record1[NewspaperID]'/>
		<input type='submit' name='update' value='μεταβολή'/></td>
		<td width='10%'><input type='submit' name='delete' value='διαγραφή'/></td>
		</tr>
		</form>";
	}
	echo "<form action='properties3.php' method='post'>
	<tr>
	<td></td>
	<td><input type='text' name='ann'/></td>
	<td>
	<input type='submit' name='add' value='προσθήκη'/></td>
	</tr>
	</form>";
	
	echo "</table>";

$sql2="select Newspapers.NewspaperName,Newspapers.NewspaperID,count(*) as no,sum(Advertisments.Cost) as sumof
from newspapers natural join advertisments
group by Newspapers.NewspaperID";
$data2=mysql_query($sql2,$con);
echo "<table width='40%'><caption style='text-align:left'><h3>Συγκεντρωτικά στοιχεία εντύπων<h3></caption>
	<tr style='background-color:#FFFFF0'>
	<th width='15%'>Επωνυμία</th>
	<th width='10%'>Πλήθος αγγελιών</th>
	<th width='15%'>Σύνολο δαπάνης(€)</th>
	</tr>";
while ($record2 = mysql_fetch_array($data2)){
		echo "<tr>
		<td>$record2[NewspaperName]</td>
		<td>$record2[no]</td>
		<td>$record2[sumof]</td>";}
		
		echo"</tr></table>";

	
	
?>

</div>
</body>
</div>
<div id="foot"><footer><p>Copyright © 2015 Ομάδα 4, Βάσεις Δεδομένων</p></footer></div>
</html>