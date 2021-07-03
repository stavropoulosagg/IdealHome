--contracts2.php--
--επιλογή ελεύθερων ακινήτων--
SELECT Properties.AddrStreetName, Properties.AddrStreetNo, Properties.PropertyRegistrationNo FROM Properties  LEFT outer JOIN Contracts
on Properties.PropertyRegistrationNo=Contracts.PropertyRegistrationNo
where Contracts.PropertyRegistrationNo is null;

--clients2.php--
SELECT Clients.ClientRegistrationNo, Clients.FirstName, Clients.LastName, ClientPhones.PhoneNumber FROM Clients natural join ClientPhones;

--μέσο ενοίκιο ανά ταυτότητα ακινήτου--
select avg(Properties.Rent) as avg_rent,Properties.PropertyTypeId,PropertyTypes.Description,PropertyTypes.Rooms
from properties natural join PropertyTypes
group by Properties.PropertyTypeId
having avg_rent>300;

--μέσος μισθός ανά υπάλληλο, πλήθος υπαλλήλων --
select avg(employees.salary), count(*)
from employees;

--υπάλληλοι που δεν έχουν ανάθεση σε ακίνητα--
select e.FirstName, e.LastName
from employees as e
where not exists (select *
                 from properties as p
                 where p.managerAFM=e.AFM);

--όλα τα ακίνητα με την περιγραφή τους που έχουν περισσότερα από ένα δωμάτια και ενοίκιο μικρότερο των 800€ και μεγαλύτερο των 300€ και είναι σε δεύτερη & άνω εσοχή--		 
select Properties.propertyRegistrationNo,Properties.Rent, PropertyTypes.Rooms,PropertyTypes.Description, Properties.Floor, Properties.AddrStreetName,Properties.AddrStreetNo
from Properties join PropertyTypes on Properties.PropertyTypeId=PropertyTypes.PropertyTypeId
group by Properties.PropertyRegistrationNo
having PropertyTypes.Rooms>1 and Properties.Rent<800 and Properties.Rent>300 and Properties.Floor>2;	


--εργαζόμενοι που έχουν μισθώσει ακίνητα σε φθίνουσα σειρά πλήθους μισθώσεων--
select Employees.FirstName,Employees.LastName, count(*) as sumOfContracts
from Employees,Properties, Contracts
where Employees.AFM=Properties.ManagerAFM and Properties.PropertyRegistrationNo=Contracts.PropertyRegistrationNo
group by Employees.AFM 
order by sumOfContracts;

--εμφάνιση τηλεφωνικών αριθμών όλων των εκμισθωτών(ιδιώτες & επιχειρήσεις) με τα στοιχεία επικοινωνίας τους--
select BusinessOwners.AFM,BusinessOwners.BusinessName, BusinessOwners.ContactFirstName,BusinessOwners.ContactLastName,OwnerPhones.PhoneNumber
from BusinessOwners natural join OwnerPhones
union
select PrivateOwners.AFM,null as col, PrivateOwners.FirstName,PrivateOwners.LastName,OwnerPhones.PhoneNumber
from PrivateOwners natural join OwnerPhones;		 

--ΑΦΜ,όνομα & επίθετο προιστάμενου με πλήθος υφισταμενων--
select e1.SupervisorAFM,e2.AFM, e2.FirstName, e2.LastName, count(*)
from employees as e1, employees as e2
where e1.SupervisorAFM=e2.AFM
group by e1.SupervisorAFM
order by e2.AFM;			

--Υφιστάμενοι χωρίς τα στοιχεία προϊστάμενου--
SELECT * from Employees where SupervisorAFM='' and !(SupervisorAFM=AFM);

--Στοιχεία ελεύθερων ακινήτων που έχουν επισκέψεις,με το πλήθος αυτών--
select p.PropertyRegistrationNo,p.AddrStreetName,p.AddrStreetNo,p.Floor,p.visitsPerProperty,p.FirstName,p.LastName,null as col,p.PrFirstName,p.PrLastName 
from prop_private as p
LEFT outer JOIN Contracts
on p.PropertyRegistrationNo=Contracts.PropertyRegistrationNo
where Contracts.PropertyRegistrationNo is null
union
select b.PropertyRegistrationNo,b.AddrStreetName,b.AddrStreetNo,b.Floor,b.visitsPerProperty,b.FirstName,b.LastName,b.BusinessName,b.ContactFirstName,b.ContactLastName 
from prop_bus as b
LEFT outer JOIN Contracts
on b.PropertyRegistrationNo=Contracts.PropertyRegistrationNo
where Contracts.PropertyRegistrationNo is null";
				 