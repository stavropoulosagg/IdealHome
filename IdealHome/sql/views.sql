--non updatable view--
create view p_v as 
select v.PropertyRegistrationNo, count(*)as visitsPerProperty
from visits as v
group by v.PropertyRegistrationNo;

create view middle as
select Properties.PropertyRegistrationNo,Properties.AddrStreetName,Properties.AddrStreetNo,Properties.Floor, Properties.OwnerAFM, p_v.visitsPerProperty,employees.FirstName,employees.LastName
from p_v natural join Properties join Employees where Properties.ManagerAFM=employees.AFM;

--εμφανίζονται τα στοιχεία κάθε ακινήτου που ανήκει σε ιδιώτη(πλήθος επισκέψεων, αριθμός εγγραφής ακινήτου, στοιχεία μεσίτη, στοιχεία ιδιώτη ιδιοκτήτη--
CREATE VIEW Prop_Private AS  SELECT middle . * , PrivateOwners.FirstName AS PrFirstName, PrivateOwners.LastName AS PrLastName
FROM middle JOIN PrivateOwners
WHERE middle.OwnerAFM = PrivateOwners.AFM;

--εμφανίζονται τα στοιχεία κάθε ακινήτου που ανήκει σε επιχείρηση(πλήθος επισκέψεων, αριθμός εγγραφής ακινήτου, στοιχεία μεσίτη,στοιχεία επιχείρησης--
CREATE VIEW Prop_Bus AS  SELECT middle . * ,BusinessName, BusinessOwners.ContactFirstName, BusinessOwners.ContactLastName
FROM middle JOIN BusinessOwners
WHERE middle.OwnerAFM = BusinessOwners.AFM;

--updatable view--
create view emp_contacts as
select e.AFM,e.FirstName,e.LastName,e.WorkPhoneNumber,e.MobilePhoneNumber,e.AddrStreetName,e.AddrStreetNo,e.AddrPostalCode
from employees as e;

--triggers --
delimiter //
create trigger trig2
before insert on Contracts 
for each row
begin
if (New.RentFinish<New.RentStart) then
set New.RentFinish = Null;
end if;
end;//
delimiter;


delimiter //
create trigger trig1
before update on Contracts 
for each row
begin
if (New.RentFinish<New.RentStart) then
set New.RentFinish = Null;
end if;
end;//
delimiter;

delimiter //
create trigger trig3
before insert on PropertyTypes
for each row
begin
if (New.Rooms<1) then
set New.Rooms = Null;
end if;
end;//
delimiter;

delimiter //
create trigger trig4
before insert on Employees
for each row
begin
if (New.Salary<600) then
set New.Salary = Null;
end if;
end;//
delimiter;

delimiter //
create trigger trig5
before update on Employees
for each row
begin
if (New.Salary<600) then
set New.Salary = Null;
end if;
end;//
delimiter;
