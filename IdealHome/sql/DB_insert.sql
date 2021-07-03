insert into IdealHome.Employees 
(AFM,FirstName,LastName,AddrStreetName,AddrStreetNo,AddrPostalCode,Salary,WorkPhoneNumber,MobilePhoneNumber,SupervisorAFM)
values
('069805478','Ιωάννα','Γεωργίου','Σόλωνος',59,'16325',1500,'2115868645','6940232429','069805478'),
('091234567','Μαργαρίτα','Βιτοροπούλου','Ιπποκράτους',52,'15532',910,'2115868644','6958234169','069805478'),
('091546258','Μαρία','Παπαδοπούλου','Ασκληπιού',32,'15236',1020,'2115868643','6940232426','069805478'),
('061234567','Ιωάννης','Παναγιώτου','Ποσειδώνος',86,'13648',860,'2115868640','6942255632','061234567');

insert into IdealHome.Newspapers
(NewspaperName)
values
('Χρυσή Ευκαιρία'),
('Καθημερινή'),
('Το Βήμα'),
('Αγγελίες'),
('Τα Νέα');

insert into IdealHome.PropertyTypes
(Description,Rooms)
values
('γκαρσονιέρα',1),
('δώμα',1),
('αποθήκη',1),
('αποθήκη', 2),
('διαμέρισμα',2),
('διαμέρισμα',3),
('διαμέρισμα',4),
('οροφοδιαμέρισμα',2),
('οροφοδιαμέρισμα',3),
('οροφοδιαμέρισμα',4),
('οροφοδιαμέρισμα',5),
('μεζονέτα',3),
('μεζονέτα',4),
('μεζονέτα',5),
('μεζονέτα',6),
('μονοκατοικία', 2),
('μονοκατοικία',3),
('μονοκατοικία',4),
('μονοκατοικία',5),
('μονοκατοικία',6),
('κατάστημα',1),
('κατάστημα',2),
('γραφείο',1),
('γραφείο',2),
('γραφείο',3);

insert into IdealHome.Owners
(AFM,AddrStreetName,AddrStreetNo,AddrPostalCode)
values
('012345678','Αθηνάς',1,'12345'),
('123456789','Σίνα',2,'13456'),
('234567890','Πραξιτέλους',4,'19854'),
('345678912','Νοταρά',5,'17015');
('567891011','Κολοκοτρώνη' 70,'17258');

insert into IdealHome.PrivateOwners
(AFM,FirstName,LastName)
values	
('012345678', 'Γιάννης','Αθανασίου'),
('123456789','Αγγελική','Πετράκη'),
('567891011','Νίκος','Ευγενίου');

insert into IdealHome.BusinessOwners
(AFM,BusinessName,BusinessType,ContactFirstName,ContactLastName)
values
('234567890', 'ΑΝΕΓΕΡΣΗ','κατασκευαστική','Νικόλαος','Μίδας'),
('345678912','ΕΝΕΡΓΕΙΑ','μηχανολόγος μηχανικός','Ειρήνη','Λάλα');

insert into IdealHome.OwnerPhones
(PhoneNumber,AFM)
values
('2101234567','012345678'),
('6944123456','012345678'),
('2117894563','345678912');

insert into IdealHome.Clients
(FirstName,LastName,AddrStreetName,AddrStreetNo,AddrPostalCode,RegistrationDate,MaxRent,Active,RegisteredBy,PreferedTypeID)
values
('Νίκη','Καρέζη','Ήρας',5,'12016',now(),600,1,'069805478',9),
('Αθανάσιος','Παπανικολάου','Νυμφών',23,'16098',now(),550,1,'061234567',12),
('Άννα','Τuring','Δεξαμενής',8,'11698',now(),600,1,'091234567',18);

insert into IdealHome.Properties
(AddrStreetName,AddrStreetNo,AddrPostalCode,Size,Floor,Rent,PropertyTypeId,OwnerAFM,ManagerAFM)
values
('Στουρνάρη',44,'15234',69,2,310,5,'123456789','091546258'),
('Άρεως',12,'16017',148,3,600,14,'012345678','091234567'),
('Ηρώων Πολυτεχνείου',58,'17025',25,6,250,2,'345678912','091546258');

insert into IdealHome.Advertisments
(DateofPublish,PropertyRegistrationNo,NewspaperID,Cost,Duration)
values
(now(),5,3,20,10),
(now(),4,4,13,7),
(now(),6,4,30,21);

insert into IdealHome.Visits
(ClientRegistrationNo,PropertyRegistrationNo,DateofVisit)
values
(1,2,"2015-2-14"),
(1,2,"2015-2-1"),
(2,2,"2015-2-2"),
(3,1,"2014-12-22"),
(3,2,"2015-1-14");

insert into IdealHome.Contracts
(PaymentType,Rent,RentStart,RentFinish,ClientRegistrationNo,PropertyRegistrationNo)
values
("κατάθεση σε τραπεζικό λογαριασμό",500,"2015-2-25","2018-2-26",1,2),
("μετρητά επί αποδείξει",210,"2015-2-2","2018-2-3",3,1);

insert into IdealHome.ClientPhones
(ClientRegistrationNo,PhoneNumber)
values
(1,"2105696325"),
(1,"6982365987"),
(2,"2116985216"),
(2,"6985647932"),
(3,"2113246974");
