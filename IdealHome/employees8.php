<?php 
header('Content-type: text/html; charset:utf8');
include('inc/header.inc.php');
include('inc/connect.inc.php');
session_start();
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
<li><a href="employees8.php" style="background-color:#E0E0E0" >Στατιστικά στοιχεία υπαλλήλων</a></li>
<li><a href="employees2.php" >Προσωποποιημένη πληροφόρηση</a></li>
</ul>
</div>
</br></br>
<?php

$sql1="select e.FirstName, e.LastName,e.AFM,e.SupervisorAFM
from employees as e
where not exists (select *
                 from properties as p
                 where p.managerAFM=e.AFM)";
$data1=mysql_query($sql1,$con);
echo "<table width='50%'>
<caption style='text-align:left'><h3>Εργαζόμενοι δίχως αναθέσεις ακινήτων.<h3></caption>
	<tr style='background-color:#FFFFF0'>
	<th width='15%'>Ονοματεπώνυμο</th>
	<th width='10%'>Προϊστάμενος/η</th>
	</tr>";
	while ($record1 = mysql_fetch_array($data1)){
		echo "
		<tr>
		<td>$record1[FirstName] $record1[LastName]</td>";
		if($record1['AFM']==$record1['SupervisorAFM']){echo"
		<td>ναι</td>";}
		else{echo"<td>όχι</td>";}
	}
	echo"</tr></table>";
				

				
$sql2="select Employees.FirstName,Employees.LastName, count(*) as sumOfContracts
from Employees,Properties, Contracts
where Employees.AFM=Properties.ManagerAFM and Properties.PropertyRegistrationNo=Contracts.PropertyRegistrationNo
group by Employees.AFM 
order by sumOfContracts";
$data2=mysql_query($sql2,$con);
echo "<table width='50%'>
<caption style='text-align:left'><h3>Πλήθος συμβολαίων ανά εργαζόμενο<h3></caption>
	<tr style='background-color:#FFFFF0'>
	<th width='15%'>Ονοματεπώνυμο</th>
	<th width='10%'>Πλήθος συμβολαίων</th>
	</tr>";
	while ($record2 = mysql_fetch_array($data2)){
		echo "
		<tr>
		<td>$record2[FirstName] $record2[LastName]</td>
		<td>$record2[sumOfContracts]</td>";
	}
	echo"</tr></table>";	
	
$sql3="select Employees.FirstName,Employees.LastName, count(*) as sumOfProperties
from Employees,Properties
where Employees.AFM=Properties.ManagerAFM
group by Employees.AFM";
$data3=mysql_query($sql3,$con);
echo "<table width='50%'>
<caption style='text-align:left'><h3>Πλήθος αναθέσεων ανά εργαζόμενο<h3></caption>
	<tr style='background-color:#FFFFF0'>
	<th width='15%'>Ονοματεπώνυμο</th>
	<th width='10%'>Πλήθος αναθέσεων</th>
	</tr>";
	while ($record3 = mysql_fetch_array($data3)){
		echo "
		<tr>
		<td>$record3[FirstName] $record3[LastName]</td>
		<td>$record3[sumOfProperties]</td>";
	}
	echo"</tr></table>";



?>
</div>
</body>
</div>
<div id="foot"><footer><p>Copyright © 2015 Ομάδα 4, Βάσεις Δεδομένων</p></footer></div>
</html>