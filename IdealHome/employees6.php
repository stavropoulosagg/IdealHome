<?php 
header('Content-type: text/html; charset:utf8');
include('inc/header.inc.php');
include('inc/connect.inc.php');
session_start();
if(!isset($_SESSION['afm'])){
}
?>
<div id="menu">
<ul>
<li><a href="index.php">ΑΡΧΙΚΗ ΣΕΛΙΔΑ</a></li>
<li><a href="employees1.php" style="background-color:#E0E0E0">ΥΠΑΛΛΗΛΟΙ</a></li>
<li><a href="properties1.php">ΑΚΙΝΗΤΑ</a></li>
<li><a href="clients1.php">ΜΙΣΘΩΤΕΣ</a></li>
<li><a href="owners1.php">ΕΚΜΙΣΘΩΤΕΣ</a></li>
<li><a href="contracts1.php">ΣΥΜΒΟΛΑΙΑ</a></li>
</ul>
</div>
</br>
<div id="main">

<div id="menu2">
<ul>
<li><a href="employees1.php" >Συγκεντρωτικός πίνακας</a></li>
<li><a href="employees8.php" >Στατιστικά στοιχεία υπαλλήλων</a></li>
<li><a href="employees2.php" style="background-color:#E0E0E0">Προσωποποιημένη πληροφόρηση</a></li>
<li><a href="logout.php">Έξοδος από προσωποποιημένη πληροφόρηση</a></li>
</ul>
</div></br>
<div id="menu3">
<ul>
<li><a href="employees3.php" >Μεταβολή προσωπικών στοιχείων</a></li>
<li><a href="employees4.php"  >Οι Υφιστάμενοί μου</a></li>
<li><a href="employees5.php"  >Τα ακίνητά μου</a></li>
<li><a href="employees6.php" style="background-color:#E0E0E0" >Οι Μισθωτές μου</a></li>
</ul>
</div>
</br></br>
<?php

if(isset($_POST['add2'])){
		$dat=date("Y-m-d");
		$addQuery2="INSERT INTO clients (FirstName,LastName,AddrStreetName,AddrStreetNo,AddrPostalCode,RegistrationDate,MaxRent,Active,RegisteredBy,PreferedTypeID)		
		VALUES ('$_POST[fname]','$_POST[lname]','$_POST[adrstrname]','$_POST[adrstrno]','$_POST[adrpcode]',now(),'$_POST[maxrent]','$_POST[active]','$_SESSION[afm]','$_POST[preferedTypeId]')";
		mysql_query($addQuery2,$con);
}

$sql1="SELECT Clients.FirstName,Clients.LastName, Clients.MaxRent, PropertyTypes.Description,PropertyTypes.Rooms
 from PropertyTypes,Clients
 where Clients.RegisteredBy='$_SESSION[afm]' and Clients.PreferedTypeId=PropertyTypes.PropertyTypeId and Clients.Active=1;";
$data = mysql_query($sql1,$con);
if($count=mysql_num_rows($data)){
	echo "<table width='70%'><caption style='text-align:left'><h3>Μισθωτές<h3></caption>
	<tr style='background-color:#FFFFF0'>
	<th width='20%'>Ονοματεπώνυμο</th>
	<th width='15%'>Ακίνητο που επιθυμεί</th>
	<th width='15%'>Πλήθος δωματίων</th>
	<th width='10%'>Μέγιστο μίσθωμα</th>
	</tr>";
	while ($record1 = mysql_fetch_array($data)){
		echo "
		<tr>
		<td>$record1[FirstName] $record1[LastName]</td>
		<td>$record1[Description]</td>
		<td>$record1[Rooms]</td>
		<td>$record1[MaxRent]</td>";
	}
	echo"</tr></table></br>";
}else{echo"<h3>Δεν έχετε μισθωτές.</h3>";}


echo"<form id='form1' method='post' action='employees6.php'>
<fieldset>
<legend>Προσθήκη νέου μισθωτή</legend>

<label for='fname'>
<span>Όνομα:</span>
<input id='fname' type='text' name='fname' size='20'/>
</label>

<label for='lname'>
<span>Επίθετο:</span>
<input id='lname' type='text' name='lname' size='20'/>
</label>

<label for='adrstrname'>
<span>Οδός:</span>
<input id='adrstrname' type='text' name='adrstrname' size='20'/>
</label>

<label for='adrstrno'>
<span>Αριθμός:</span>
<input id='' type='text' name='adrstrno' size='20'/>
</label>

<label for='adrpcode'>
<span>Ταχυδρομικός κώδικας:</span>
<input id='adrpcode' type='text' name='adrpcode' size='20'/>
</label>

<label for='maxrent'>
<span>Μέγιστο μίσθωμα:</span>
<input id='maxrent' type='text' name='maxrent' size='20'/>
</label>

<label for='active'>
<span>Ενεργός/ή:</span>
<select name='active'>
<option value='' disabled selected>Επιλέξτε</option>
<option value='1'>ναι</option>
<option value='0'>όχι</option>
</select>
</label>


</label>
<label for='preferedTypeId'>
<span>Προτιμώμενος τύπος ακινήτου:</span>
<select name='preferedTypeId'>
<option value='' disabled selected>Επιλέξτε</option>";

$sql4="SELECT * FROM PropertyTypes";
	$mydata4=mysql_query($sql4,$con);
	while ($record4 = mysql_fetch_assoc($mydata4)) {
		$ptid= $record4['PropertyTypeId'];
		$desc=$record4['Description'];
		$ro=$record4['Rooms'];
		echo " <option value='$ptid'>".$ptid.". ".$desc." - ".$ro. "</option>";
	}
echo"</select>
	</label>

<label for='submit1' id='submit'>
<input id='submit1' class='submit' type='submit' name='add2' value='Προσθήκη'/>
</label>

</fieldset>
</form>";

?>

</div>
</body>
</div>
<div id="foot"><footer><p>Copyright © 2015 Ομάδα 4, Βάσεις Δεδομένων</p></footer></div>
</html>