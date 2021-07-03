<?php 
header('Content-type: text/html; charset:utf8');
include('inc/header.inc.php');
include('inc/connect.inc.php');
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
<li><a href="employees1.php" style="background-color:#E0E0E0" >Συγκεντρωτικός πίνακας</a></li>
<li><a href="employees8.php" >Στατιστικά στοιχεία υπαλλήλων</a></li>
<li><a href="employees2.php" >Προσωποποιημένη πληροφόρηση</a></li>
</ul>
</div>
</br></br>
<?php

if(isset($_POST['submit20'])){
$query="UPDATE emp_contacts SET WorkPhoneNumber='$_POST[wpn20]' where AFM='$_POST[hidden20]'";
mysql_query($query,$con);}
	
$sql20="SELECT * from emp_contacts";
$data20=mysql_query($sql20,$con);
echo "<table width='80%'>
<caption><h3>Στοιχεία επικοινωνίας εργαζομένων</h3></caption>
	<tr style='background-color:#FFFFF0'>
	<th width='15%'>Εργαζόμενος</th>
	<th width='20%'>Διεύθυνση κατοικίας</th>
	<th width='15%'>Τηλέφωνο κινητό</th>
	<th width='15%'>Τηλέφωνο εργασίας</th>
	</tr>";
	while($record20= mysql_fetch_assoc($data20)){
		echo"<form action='employees1.php' method='POST'>
		<tr>
		<td style='text-align:left'>$record20[FirstName] $record20[LastName]</td>
		<td>$record20[AddrStreetName] $record20[AddrStreetNo] $record20[AddrPostalCode]</td>
		<td>$record20[MobilePhoneNumber]</td>
		<td><input type='text' name='wpn20' value='$record20[WorkPhoneNumber]'/></td>
		<td width='10%'><input type='hidden' name='hidden20' value='$record20[AFM]'/>
		<input type='submit' name='submit20' value='ενημέρωση'/></td>
		</tr></form>";
	}
		echo"</table>";

	
$a="SELECT * FROM Employees";
$b=mysql_query($a,$con);
echo"</br></br><form id='form1' method='post' action='employees1.php'>
<fieldset>
<legend>Αναζήτηση προϊσταμένου βάσει υπαλλήλου</legend>
<label for='find'>
<span>Υπάλληλος:</span>
<select name='fin'>
<option value='' disabled selected>Επιλέξτε</option>";
	while($rec= mysql_fetch_assoc($b)) {
		$afm1= $rec['AFM'];
		$fname=$rec['FirstName'];
		$lname=$rec['LastName'];
		echo "<option value='$afm1'>".$fname." ".$lname. "</option>";
	}
echo"</select>
	 </label>
	 <label for='submit1' id='submit'>
     <input id='submit1' class='submit' type='submit' name='find2' value='αναζήτηση'/>
     </label>";
 
if (isset($_POST['find2'])){
$c="SELECT  e1.FirstName,e1.LastName,e2.FirstName as fname, e2.LastName as lname from Employees as e1,Employees as e2 where e1.AFM='$_POST[fin]' and e2.AFM=e1.SupervisorAFM";
$d=mysql_query($c);
$row=mysql_fetch_array($d);
$fn1=$row['FirstName'];
$ln1=$row['LastName'];
$fn2=$row['fname'];
$ln2=$row['lname'];
echo"</br><b>Επιλέξατε τον/ην εργαζόμενο/η:</b> $fn1 $ln1 </br><b> Ο προϊστάμενος/η είναι:</b>";
echo" $fn2 $ln2</br>";
echo"</fieldset></form>";
}		 
else{echo"</fieldset></form>";}
	
	
$sql1="select e1.SupervisorAFM,e2.AFM, e2.FirstName, e2.LastName, count(*) as total
from employees as e1, employees as e2
where e1.SupervisorAFM=e2.AFM
group by e1.SupervisorAFM
order by e2.AFM";
$data1=mysql_query($sql1,$con);
echo"</br></br><form id='form1' method='post' action='employees1.php'>
<fieldset>
<legend>Αναζήτηση υπαλλήλου βάσει προϊσταμένου</legend>
<label for='find'>
<span>Προϊστάμενος:</span>
<select name='find'>
<option value='' disabled selected>Επιλέξτε</option>";
	while($rec= mysql_fetch_assoc($data1)) {
		$afm= $rec['AFM'];
		$fname2=$rec['FirstName'];
		$lname2=$rec['LastName'];
		echo "<option value='$afm'>".$fname2." ".$lname2. "</option>";
	}
echo"</select>
	 </label>
	 <label for='submit1' id='submit'>
     <input id='submit1' class='submit' type='submit' name='find1' value='αναζήτηση'/>
     </label></br>"; 
	 
if (isset($_POST['find1'])){
$sql2="SELECT * from Employees where SupervisorAFM='$_POST[find]' and !(SupervisorAFM=AFM)";
$data2=mysql_query($sql2,$con);	
$sql3="SELECT * from Employees where Employees.AFM='$_POST[find]'";
$data3=mysql_query($sql3,$con);
$rec2=mysql_fetch_array($data3);
$fn=$rec2['FirstName'];
$ln=$rec2['LastName'];
echo"<b>Επιλέξατε προϊστάμενο/η:</b> $fn $ln </br><b>Οι υφιστάμενοι είναι:</b></br>";
while($rec1= mysql_fetch_array($data2)){
echo" $rec1[FirstName] $rec1[LastName] </br>";
}
echo"</fieldset></form>";
}
else {echo"</fieldset></form></br>";}




?>
</div>
</body>
</div>
<div id="foot"><footer><p>Copyright © 2015 Ομάδα 4, Βάσεις Δεδομένων</p></footer></div>
</html>