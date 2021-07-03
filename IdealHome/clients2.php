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
<li><a href="clients2.php" style="background-color:#E0E0E0">Τηλεφωνικός κατάλογος</a></li>
<li><a href='clients3.php'>Προσθήκη τηλεφώνου</a></li>
<li><a href ="clients5.php">Μεταβολή στοιχείων μισθωτή</a></li>
</ul>
</div>
</br></br>

<?php
$sql5="SELECT * FROM Clients";
$mydata5=mysql_query($sql5,$con);
echo"</br></br><form id='form1' method='post' action='clients2.php'>
<fieldset>
<legend>Αναζήτηση τηλεφώνου</legend>
<label for='find'>
<span>Μισθωτής:</span>
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
     </label>";
	 
if (isset($_POST['add3'])){
	$sql7="SELECT Clients.FirstName from Clients where Clients.ClientRegistrationNo='$_POST[find]'";
	$data1=mysql_query($sql7,$con);
	$record=mysql_fetch_array($data1);
	$sql8="SELECT Clients.LastName from Clients where Clients.ClientRegistrationNo='$_POST[find]'";
	$data2=mysql_query($sql8,$con);
	$record1=mysql_fetch_array($data2);
$sql6="SELECT * FROM Clients natural join ClientPhones where Clients.ClientRegistrationNo='$_POST[find]'";
$mydata6=mysql_query($sql6,$con);
echo"<label for='lname'>
	<span>".$record['FirstName']." ".$record1['LastName'].":</span>";
while($myrecord=mysql_fetch_array($mydata6)){
echo"<input type='text' name='pn' value='$myrecord[PhoneNumber]' size='20'/>";
}}
echo"</label></fieldset></form>";



if(isset($_POST['update1'])){
	$updateQuery1="UPDATE ClientPhones SET PhoneNumber='$_POST[PhoneNumber]' WHERE ClientRegistrationNo='$_POST[hidden1]' AND PhoneNumber='$_POST[hidden2]'";
	mysql_query($updateQuery1,$con);
}

if(isset($_POST['delete1'])){
	$deleteQuery1="DELETE FROM ClientPhones WHERE ClientRegistrationNo='$_POST[hidden1]' AND PhoneNumber='$_POST[hidden2]'";
	mysql_query($deleteQuery1,$con);
}

$sql1="SELECT Clients.ClientRegistrationNo, Clients.FirstName, Clients.LastName, ClientPhones.PhoneNumber FROM Clients natural join ClientPhones";
	$mydata1 = mysql_query($sql1,$con);
	echo "</br></br><table width='70%'>
	<caption style='text-align:left'><h3>Συγκεντρωτικός πίνακας τηλεφώνων<h3></caption>
	<tr style='background-color:#FFFFF0'>
	<th width='15%'>Αριθμός Εγγραφής</th>
	<th width='30%'>Ονοματεπώνυμο</th>
	<th width='25%'>Τηλέφωνο</th>
	</tr>";
	while ($record1 = mysql_fetch_array($mydata1)){
	echo "<form action='clients2.php' method='POST'>
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
	
	

?>
</div>
</body>
</div>
<div id="foot"><footer><p>Copyright © 2015 Ομάδα 4, Βάσεις Δεδομένων</p></footer></div>
</html>