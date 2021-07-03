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
<li><a href="clients3.php" style="background-color:#E0E0E0">Προσθήκη τηλεφώνου</a></li>
<li><a href ="clients5.php">Μεταβολή στοιχείων μισθωτή</a></li>
</ul>
</div>
</br></br>

<?php
if(isset($_POST['add1'])){
	if(empty($_POST['list'])or(empty($_POST['aPhoneNumber'])))
	{
		echo "</br><h4><font color='red'> Δεν έχετε συμπληρώσει όλα τα υποχρεωτικά πεδία! </h4></font></br>";
    }
	else{
	$addQuery1="INSERT INTO ClientPhones VALUES ('$_POST[list]','$_POST[aPhoneNumber]')";
	mysql_query($addQuery1,$con);
}}
$sql2="SELECT Clients.ClientRegistrationNo, Clients.LastName, Clients.FirstName FROM Clients";
	$mydata2=mysql_query($sql2,$con);
	echo "<table width='50%'>
	<caption style='text-align:left'><h3>Προσθήκη νέου τηλεφώνου<h3></caption>
	<tr style='background-color:#FFFFF0'>
	<th>Ονοματεπώνυμο μισθωτή</th>
	<th>Τηλέφωνο</th>
	</tr>";
    echo "<form action ='clients3.php' method='POST'>
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
?>
</div>
</body>
</div>
<div id="foot"><footer><p>Copyright © 2015 Ομάδα 4, Βάσεις Δεδομένων</p></footer></div>
</html>