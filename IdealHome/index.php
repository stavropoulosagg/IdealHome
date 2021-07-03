<?php 
header('Content-type: text/html; charset:utf8');
include('inc/header.inc.php');
include('inc/connect.inc.php');
?>
<div id="menu">
<ul>
<li><a href="index.php" style="background-color:#E0E0E0">ΑΡΧΙΚΗ ΣΕΛΙΔΑ</a></li>
<li><a href="employees1.php">ΥΠΑΛΛΗΛΟΙ</a></li>
<li><a href='properties1.php'>ΑΚΙΝΗΤΑ</a></li>
<li><a href="clients1.php">ΜΙΣΘΩΤΕΣ</a></li>
<li><a href="owners1.php">ΕΚΜΙΣΘΩΤΕΣ</a></li>
<li><a href="contracts1.php">ΣΥΜΒΟΛΑΙΑ</a></li>
</ul>
</div>
<div id="main">
</br></br></br></br></br>
<div id="welcome"><h2>ΙΔΑΝΙΚΟ ΣΠΙΤΙ</h2><h3>Σύμβουλοι ακίνητης περιουσίας</h3></div></br></br></br>
<?PHP
$sql1="SELECT avg(employees.salary) as averageSalary,count(*) as numberOfEmp from employees";
$data=mysql_query($sql1,$con);
$rec=mysql_fetch_array($data);
$sql2="SELECT count(*) as noOfProp from Properties";
$data1=mysql_query($sql2,$con);
$rec1=mysql_fetch_array($data1);
$sql3="SELECT count(*) as noOfContr from Contracts";
$data2=mysql_query($sql3,$con);
$rec2=mysql_fetch_array($data2);

echo"
<div id='info'>
<p>Αυτή τη στιγμή η εταιρία μας απασχολεί"." ".$rec['numberOfEmp']."  υπαλλήλους με μέσο μισθό €".round($rec['averageSalary'],2)."</p>
<p>Η εταιρία έχει αναλάβει έως σήμερα τη μίσθωση"." ".$rec1['noOfProp']." ακινήτων από όλη την Ελλάδα και έχει καταφέρει την επιτυχή μίσθωση"." ".$rec2['noOfContr']." ακινήτων.</p>
<p>Η ιστοσελίδα αυτή έχει κατασκευαστεί αυστηρά για ενδοεταιρική χρήση*. </p>
<h5>*Τα στοιχεία των εργαζομένων και των πελατών αποτελούν προσωπικά δεδομένα, οποιαδήποτε χρήση πέρα της προβλεπόμενης, διώκεται ποινικά.</h5>
</div>";
?>

</div>

</body>
</div>
<div id="foot"><footer><p>Copyright © 2015 Ομάδα 4, Βάσεις Δεδομένων</p></footer></div>
</html>

