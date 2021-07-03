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
<li><a style="background-color:#E0E0E0" href="clients1.php">ΜΙΣΘΩΤΕΣ</a></li>
<li><a href="owners1.php">ΕΚΜΙΣΘΩΤΕΣ</a></li>
<li><a href="contracts1.php">ΣΥΜΒΟΛΑΙΑ</a></li>
</ul>
</div>
</br>
<div id="main">

<div id="menu2">
<ul>
<li><a href="clients1.php" style="background-color:#E0E0E0">Συγκεντρωτικός πίνακας</a></li>
<li><a href="clients2.php">Τηλεφωνικός κατάλογος</a></li>
<li><a href='clients3.php'>Προσθήκη τηλεφώνου</a></li>
<li><a href ="clients5.php">Μεταβολή στοιχείων μισθωτή</a></li>
</ul>
</div>
</br></br>
<?php
if(isset($_POST['delete2'])){
	$deleteQuery2="DELETE FROM Clients WHERE ClientRegistrationNo='$_POST[hidden3]'";
	mysql_query($deleteQuery2,$con);
}
	$sql3="SELECT * FROM Clients";
	$mydata3 = mysql_query($sql3,$con);
	echo "<table width='90%'>
	<tr style='background-color:#FFFFF0'>
	<th width='5%'>Αριθμός Εγγραφής</th>
	<th width='25%'>Ονοματεπώνυμο</th>
	<th width='25%'>Διεύθυνση</th>
	<th width='10%'>Ημερομηνία εγγραφής</th>
	<th width='5%'>Μέγιστο μίσθωμα</th>
	<th width='5%'>Ενεργός</th>
	<th width='5%'>Προτιμώμενη στέγη</th>
	</tr>";
	while ($record3 = mysql_fetch_array($mydata3)){
		echo "<form action='clients1.php' method='POST'>
		<tr>
		<td>$record3[ClientRegistrationNo]</td>
		<td>$record3[FirstName] $record3[LastName]</td>
		<td>$record3[AddrStreetName] $record3[AddrStreetNo] $record3[AddrPostalCode]</td>
		<td>$record3[RegistrationDate]</td>
		<td>$record3[MaxRent]</td>
		<td>";if($record3['Active']=='1'){echo "ναι";} else {echo "όχι";} echo"</td>
		<td>$record3[PreferedTypeId]</td>
		<td width='10%'><input type='hidden' name='hidden3' value= '$record3[ClientRegistrationNo]'/><input type='submit' name='delete2' value='διαγραφή'/></td>
		</tr></form>";
	}
	echo"</table>";
	
		
$sql1="select e.FirstName,e.LastName,e.RegisteredBy
from clients as e";
$data1=mysql_query($sql1,$con);
echo"</br></br><form id='form1' method='post' action='clients1.php'>
<fieldset>
<legend>Αναζήτηση μεσίτη</legend>
<label for='find'>
<span>Μισθωτής:</span>
<select name='find'>
<option value='' disabled selected>Επιλέξτε</option>";
	while($rec= mysql_fetch_assoc($data1)) {
		$crn= $rec['RegisteredBy'];
		$fname2=$rec['FirstName'];
		$lname2=$rec['LastName'];
		echo "<option value='$crn'>".$fname2." ".$lname2. "</option>";
	}
echo"</select>
	 </label>
	 <label for='submit1' id='submit'>
     <input id='submit1' class='submit' type='submit' name='find1' value='αναζήτηση'/>
     </label></br>";
	 if (isset($_POST['find1'])){
$c="SELECT  e1.FirstName,e1.LastName,e2.FirstName as fname, e2.LastName as lname from Clients as e1 join Employees as e2 where e1.RegisteredBy='$_POST[find]' and e1.RegisteredBy=e2.AFM";
$d=mysql_query($c);
$row=mysql_fetch_array($d);
$fn1=$row['FirstName'];
$ln1=$row['LastName'];
$fn2=$row['fname'];
$ln2=$row['lname'];
echo"</br><b>Επιλέξατε τον/ην μισθωτή/τρια:</b> $fn1 $ln1 </br><b> Εγγράφηκε από τον/ην:</b>";
echo" $fn2 $ln2</br>";
echo"</fieldset></form>";
}		 
else{echo"</fieldset></form>";}
?>
</div>
</body>
</div>
<div id="foot"><footer><p>Copyright © 2015 Ομάδα 4, Βάσεις Δεδομένων</p></footer></div>
</html>