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
<li><a href="employees4.php" style="background-color:#E0E0E0" >Οι Υφιστάμενοί μου</a></li>
<li><a href="employees5.php" >Τα ακίνητά μου</a></li>
<li><a href="employees6.php"  >Οι Μισθωτές μου</a></li>
</ul>
</div>
</br></br>
<?php
if(isset($_POST['submit1'])){
	$sql2="UPDATE employees 
	SET Salary='$_POST[salary]' 
	where AFM='$_POST[hidden1]'";
	mysql_query($sql2,$con);
	}

	if(isset($_POST['submit2'])){
	$sql3="DELETE from employees 
	where AFM='$_POST[hidden1]'";
	$data3=mysql_query($sql3,$con);
	}

	if(isset($_POST['submit5'])){
	if(empty($_POST['af']) or empty($_POST['adrstrname']) or empty($_POST['adrstrnο'])or empty($_POST['adrpc'])or empty($_POST['name'])or empty($_POST['surname']) 
		or empty($_POST['salary'])or empty($_POST['wpn'])or empty($_POST['mpn'])){
	echo"<h4>Δεν έχετε συμπληρώσει όλα τα απαραίτητα πεδία. Προσπαθήστε ξανά.</h4>";
	}
	else{$sql4="INSERT INTO Employees (AFM, FirstName,LastName,AddrStreetName,AddrStreetNo,AddrPostalCode,Salary,WorkPhoneNumber,MobilePhoneNumber,SupervisorAFM)
	VALUES ('$_POST[af]','$_POST[name]','$_POST[surname]','$_POST[adrstrname]','$_POST[adrstrnο]','$_POST[adrpc]','$_POST[salary]','$_POST[wpn]','$_POST[mpn]','$_SESSION[afm]')";
	mysql_query($sql4,$con);
	}
}

echo"
<form id='form1' method='post' action='employees4.php'>
<fieldset>
<legend>Προσθήκη νέου εργαζόμενου</legend>

<label for='1'>
<span>ΑΦΜ:</span>
<input id='1' type='text' name='af' size='20'/>
</label>

<label for='2'>
<span>Όνομα:</span>
<input id='2' type='text' name='name' size='20'/>
</label>

<label for='3'>
<span>Επίθετο:</span>
<input id='3' type='text' name='surname' size='20'/>
</label>

<label for='4'>
<span>Όδος:</span>
<input id='4' type='text' name='adrstrname' size='20'/>
</label>

<label for='5'>
<span>Αριθμός:</span>
<input id='5' type='text' name='adrstrnο' size='20'/>
</label>

<label for='6'>
<span>T. K:</span>
<input id='6' type='text' name='adrpc' size='20'/>
</label>

<label for='7'>
<span>Μισθός:</span>
<input id='7' type='text' name='salary' size='20'/>
</label>

<label for='8'>
<span>Τηλέφωνο εργασίας:</span>
<input id='8' type='text' name='wpn' size='20'/>
</label>

<label for='9'>
<span>Κινητό τηλέφωνο:</span>
<input id='9' type='text' name='mpn' size='20'/>
</label>


<label for='submit5' id='submit'>
<input id='submit5' class='submit' type='submit' name='submit5' value='προσθήκη'/>
</label>

</fieldset>
</form>";
	
$sql1="SELECT * FROM Employees where SupervisorAFM='$_SESSION[afm]' and !(AFM=SupervisorAFM)";
$data1=mysql_query($sql1,$con);
if($count=mysql_num_rows($data1)){
echo"<table width='50%'>
<caption><h3>Υφιστάμενοι</h3></caption>
	<tr style='background-color:#FFFFF0'>
	<th width='15%'>Εργαζόμενος</th>
	<th width='15%'>Μισθός</th>
	</tr>";
		while($record1=mysql_fetch_array($data1)){
		echo"<form action='employees4.php' method='POST'>
		<tr>
		<td style='text-align:left'>$record1[FirstName] $record1[LastName]</td>
		<td><input type='text' name='salary' value='$record1[Salary]'/></td>
		<td width='10%'><input type='hidden' name='hidden1' value='$record1[AFM]'/>
		<input type='submit' name='submit1' value='ενημέρωση'/></td>
		<td width='10%'><input type='submit' name='submit2' value='διαγραφή'/></td>
		</tr></form>";
	}
		echo"</table><p>Σημείωση:Δε μπορείτε να διαγράψετε τους/ις υπαλλήλους που έχουν ανάθεση κάποιου ακινήτου.</p>";
}






?>

</div>
</body>
</div>
<div id="foot"><footer><p>Copyright © 2015 Ομάδα 4, Βάσεις Δεδομένων</p></footer></div>
</html>