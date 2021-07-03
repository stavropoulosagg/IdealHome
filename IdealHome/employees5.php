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
<li><a href="employees5.php" style="background-color:#E0E0E0" >Τα ακίνητά μου</a></li>
<li><a href="employees6.php"  >Οι Μισθωτές μου</a></li>
</ul>
</div>
</br></br>
<?php


if(isset($_POST['add2'])){
	if(empty($_POST['adrstrname'])or empty($_POST['adrstrno']) or empty($_POST['adrpcode']) or empty($_POST['size'])or empty($_POST['floor'])
	or empty($_POST['rent'])or empty($_POST['prTypeId'])or empty($_POST['owner'])){
	echo"<h4>Δεν έχετε συμπληρώσει όλα τα απαραίτητα πεδία στη φόρμα. Προσπαθήστε ξανά.";
	}
	else{
		$addQuery2="INSERT INTO Properties (AddrStreetName,AddrStreetNo,AddrPostalCode,Size,Floor,Rent,PropertyTypeID,OwnerAFM,ManagerAFM)		
		VALUES ('$_POST[adrstrname]','$_POST[adrstrno]','$_POST[adrpcode]','$_POST[size]','$_POST[floor]','$_POST[rent]','$_POST[prTypeId]','$_POST[owner]','$_SESSION[afm]')";
		mysql_query($addQuery2,$con);
}}

$sql1="SELECT Properties.PropertyRegistrationNo,Properties.AddrStreetName,Properties.AddrStreetNo,
Properties.Floor,Contracts.Rent,Clients.FirstName,Clients.LastName,Contracts.ContractNo
 from Properties, Contracts, Clients 
 where Properties.ManagerAFM='$_SESSION[afm]' and Properties.PropertyRegistrationNo=Contracts.PropertyRegistrationNo and 
Clients.ClientRegistrationNo = Contracts.ClientRegistrationNo";
$data = mysql_query($sql1,$con);
if($count=mysql_num_rows($data)){
	echo "<table width='90%'><caption style='text-align:left'><h3>Μισθωμένα ακίνητα<h3></caption>
	<tr style='background-color:#FFFFF0'>
	<th width='10%'>Κωδικός ακινήτου</th>
	<th width='15%'>Διεύθυνση</th>
	<th width='5%'>Όροφος</th>
	<th width='20%'>Στοιχεία μισθωτή</th>
	<th width='10%'>Μίσθωμα</th>
	<th width='10%'>Αριθμός συμβολαίου</th>
	</tr>";
	while ($record1 = mysql_fetch_array($data)){
		echo "
		<tr>
		<td>$record1[PropertyRegistrationNo]</td>
		<td>$record1[AddrStreetName] $record1[AddrStreetNo]</td>
		<td>$record1[Floor]</td>
		<td>$record1[FirstName] $record1[LastName]</td>
		<td>$record1[Rent]</td>
		<td>$record1[ContractNo]</td>";
	}
	echo"</tr></table></br>";
}else{echo"<h4>Δεν έχετε μισθωμένα ακίνητα</h4>";}

$sql2="SELECT PropertyTypes.*,Properties.* FROM PropertyTypes natural join Properties  LEFT JOIN Contracts
on Properties.PropertyRegistrationNo=Contracts.PropertyRegistrationNo
where Contracts.PropertyRegistrationNo is null and Properties.ManagerAFM='$_SESSION[afm]'";
$data2=mysql_query($sql2,$con);
if($count1=mysql_num_rows($data2)){
	echo "<table width='90%'><caption style='text-align:left'><h3>Ακίνητα σε ανάθεση<h3></caption>
	<tr style='background-color:#FFFFF0'>
	<th width='10%'>Κωδικός ακινήτου</th>
	<th width='15%'>Διεύθυνση</th>
	<th width='5%'>Όροφος</th>
	<th width='5%'>Περιγραφή</th>
	<th width='10%'>Πλήθος δωματίων</th>
	<th width='10%'>Μίσθωμα</th>
	<th width='15%'>Στοιχεία εκμισθωτή</th>
	</tr>";
	while ($record = mysql_fetch_array($data2)){
		$sql3="SELECT PrivateOwners.FirstName,PrivateOwners.LastName,null as col from PrivateOwners
		where PrivateOwners.AFM='$record[OwnerAFM]' ";
		$sql4="SELECT BusinessOwners.ContactFirstName,BusinessOwners.ContactLastName,BusinessOwners.BusinessName from BusinessOwners
		where BusinessOwners.AFM='$record[OwnerAFM]'";
		$data3=mysql_query($sql3,$con);
		$data4=mysql_query($sql4,$con);
		if($count2=mysql_num_rows($data3)){
		$rec=mysql_fetch_array($data3);
		echo "
		<tr>
		<td>$record[PropertyRegistrationNo]</td>
		<td>$record[AddrStreetName] $record[AddrStreetNo]</td>
		<td>$record[Floor]</td>
		<td>$record[Description]</td>
		<td>$record[Rooms]</td>
		<td>$record[Rent]</td>
		<td>$rec[FirstName] $rec[LastName]</td></tr>";
	}
	else{
		$re=mysql_fetch_array($data4);
		echo "
		<tr>
		<td>$record[PropertyRegistrationNo]</td>
		<td>$record[AddrStreetName] $record[AddrStreetNo]</td>
		<td>$record[Floor]</td>
		<td>$record[Description]</td>
		<td>$record[Rooms]</td>
		<td>$record[Rent]</td>
		<td>($re[BusinessName]) $re[ContactFirstName] $re[ContactLastName]</td>
		</tr>";
		}
	}echo"</table>";
}else{echo"<h4>Δε σας έχουν ανατεθεί νέα ακίνητα για μίσθωση.</h4>";}



echo"</br><form id='form1' method='post' action='employees5.php'>
<fieldset>
<legend>Προσθήκη νέου ακινήτου</legend>


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

<label for='size'>
<span>Επιφάνεια:</span>
<input id='size' type='text' name='size' size='20'/>
</label>

<label for='floor'>
<span>Όροφος:</span>
<input id='floor' type='text' name='floor' size='20'/>
</label>

<label for='rent'>
<span>Μίσθωμα:</span>
<input id='rent' type='text' name='rent' size='20'/>
</label>

</label>
<label for='prTypeId'>
<span>Tύπος ακινήτου:</span>
<select name='prTypeId'>
<option value='' disabled selected>Επιλέξτε</option>";

$sql10="SELECT * FROM PropertyTypes";
	$mydata10=mysql_query($sql10,$con);
	while ($record10 = mysql_fetch_assoc($mydata10)) {
		$ptid= $record10['PropertyTypeId'];
		$desc=$record10['Description'];
		$ro=$record10['Rooms'];
		echo " <option value='$ptid'>".$ptid.". ".$desc." - ".$ro. "</option>";
	}
echo"</select>
	</label>
	
<label for='owner'>
<span>ΑΦΜ εκμισθωτή:</span>
<select name='owner'>
<option value='' disabled selected>Επιλέξτε</option>";
$sql11="SELECT * FROM Owners";
	$mydata11=mysql_query($sql11,$con);
	while ($record11 = mysql_fetch_assoc($mydata11)) {
		$afm= $record11['AFM'];
		echo " <option value='$afm'> $afm </option>";
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