Create Database if not exists  IdealHome;
Use [IdealHome]
Go
Create Table if not exists Employees
(
AFM char(9) not null,
FirstName varchar(20) not null,
LastName varchar(20) not null,
AddrStreetName varchar(20) not null,
AddrStreetNo int(3) unsigned not null,
AddrPostalCode char(5) not null,
Salary int(6) unsigned not null,
WorkPhoneNumber char(10),
MobilePhoneNumber char(10) not null,
SupervisorAFM char(9) not null,
primary key(AFM),
foreign key(SupervisorAFM) references Employees (AFM) ON DELETE RESTRICT ON UPDATE CASCADE 
)
ENGINE=InnoDB ;

Create Table if not exists Newspapers
(
NewspaperID int (3) UNSIGNED auto_increment not null,
NewspaperName varchar(20) not null,
primary key(NewspaperID)
)
ENGINE=InnoDB ;

Create Table if not exists Advertisments
(
DateOfPublish  date not null,
PropertyRegistrationNo int(3) not null,
NewspaperID int (3) UNSIGNED not null,
Cost int(3) unsigned not null,
Duration int(3) unsigned not null,
primary key(DateOfPublish,PropertyRegistrationNo,NewspaperID),
foreign key(PropertyRegistrationNo) references Properties (PropertyRegistrationNo) ON DELETE CASCADE ON UPDATE CASCADE,
foreign key(NewspaperID) references  Newspapers(NewspaperID) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE=InnoDB;

Create table if not exists  Properties
(
PropertyRegistrationNo int(3) UNSIGNED AUTO_INCREMENT not null,
AddrStreetName varchar(20) not null,
AddrStreetNo int(3) unsigned not null,
AddrPostalCode char(5) not null,
Size numeric(5,2) not null,
Floor int(2) unsigned not null,
Rent int(6) unsigned not null,
PropertyTypeId int(2) unsigned not null,
OwnerAFM char(9) not null,
ManagerAFM char(9) not null,
primary key(PropertyRegistrationNo),
foreign key(PropertyTypeId) references PropertyTypes(PropertyTypeId) on update cascade on delete cascade,
foreign key(OwnerAFM) references Owners (AFM) on update cascade on delete cascade,
foreign key(ManagerAFM) references Employees (AFM) on update cascade on delete restrict
)
ENGINE = InnoDB;

Create table if not exists Visits
(
ClientRegistrationNo int(3) unsigned not null,
PropertyRegistrationNo int(3)UNSIGNED not null,
DateofVisit date not null,
primary key (ClientRegistrationNo,PropertyRegistrationNo,DateofVisit),
foreign key (ClientRegistrationNo) references Clients (ClientRegistrationNo) on update cascade on delete cascade,
foreign key (PropertyRegistrationNo) references Properties (PropertyRegistrationNo) on update cascade on delete cascade
)
ENGINE = InnoDB;

Create table if not exists PropertyTypes
(
PropertyTypeId int(2) unsigned auto_increment not null,
Description varchar(30) not null,
Rooms int(2) unsigned not null,
primary key(PropertyTypeId)
)
ENGINE = InnoDB;

Create table if not exists Clients
(
ClientRegistrationNo int(3) unsigned auto_increment not null,
FirstName varchar(20) not null,
LastName varchar(20) not null,
AddrStreetName varchar(20) not null,
AddrStreetNo int(3) unsigned not null,
AddrPostalCode char(5) not null,
RegistrationDate date not null,
MaxRent int(6) unsigned not null,
Active tinyint(1) not null,
RegisteredBy char(9) not null,
PreferedTypeId int(2) unsigned not null,
primary key (ClientRegistrationNo),
foreign key (RegisteredBy) references Employees (AFM) on update cascade on delete restrict,
foreign key (PreferedTypeId) references PropertyTypes (PropertyTypeId) on update cascade on delete cascade
)
ENGINE = InnoDB;

Create table if not exists Contracts
(
ContractNo int(3) unsigned auto_increment not null,
Rent int(6) unsigned not null,
PaymentType varchar(50) not null,
RentStart date not null,
RentFinish date not null,
ClientRegistrationNo int(3) unsigned not null,
PropertyRegistrationNo int(3)UNSIGNED  not null,
primary key (ContractNo),
foreign key(ClientRegistrationNo) references Clients (ClientRegistrationNo) on update cascade on delete cascade,
foreign key(PropertyRegistrationNo) references  Properties (PropertyRegistrationNo) on update cascade on delete cascade
)
ENGINE = InnoDB;

create table if not exists Owners
(
AFM char(9) not null,
AddrStreetName varchar(20) not null,
AddrStreetNo int(3) unsigned not null,
AddrPostalCode char(5) not null,
primary key (AFM)
)
ENGINE = InnoDB;

create table if not exists ClientPhones
(
ClientRegistrationNo int(3) unsigned not null,
PhoneNumber char(10) not null,
primary key (ClientRegistrationNo,PhoneNumber),
foreign key (ClientRegistrationNo) references Clients (ClientRegistrationNo) on update cascade on delete cascade
)
ENGINE = InnoDB;

create table if not exists OwnerPhones
(
PhoneNumber char(10) not null,
AFM char(9) not null,
primary key (PhoneNumber,AFM),
foreign key (AFM) references Owners(AFM) on update cascade on delete cascade
)
ENGINE = InnoDB;

create table if not exists PrivateOwners
(
AFM char(9) not null,
FirstName varchar(20) not null,
LastName varchar(20) not null,
primary key (AFM),
foreign key (AFM) references Owners(AFM)  on update cascade on delete cascade
)
ENGINE = InnoDB;

create table if not exists BusinessOwners
(
AFM char(9) not null,
BusinessName varchar(20) not null,
BusinessType varchar(30),
ContactFirstName varchar(20) not null,
ContactLastName varchar(20) not null,
primary key (AFM),
foreign key (AFM) references Owners(AFM) on update cascade on delete cascade
)
ENGINE = InnoDB;