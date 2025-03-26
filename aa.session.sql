DROP TABLE contract;
DROP TABLE adressData;
DROP TABLE building;
DROP TABLE contactList;
DROP TABLE contactPerson;
DROP TABLE adressDocument;
DROP TABLE EED;
DROP TABLE adressPhotoUserFolders;
DROP TABLE adressPhoto;
DROP TABLE worker;
DROP TABLE avances;
DROP TABLE workerAdress;
DROP TABLE buildingMaterials;
DROP TABLE elevator;
DROP TABLE montazh;
DROP TABLE accountancy;
DROP TABLE acceptTable;
DROP TABLE disgardTable;
DROP TABLE ODSH;
DROP TABLE ODSHTable;
CREATE TABLE contract (
    id integer PRIMARY KEY AUTOINCREMENT,
    contractNumber integer unique,
    date varchar(50),
    town varchar(100),
    organization varchar(30),
    manager BIGINT,
    state varchar(30),
    foreign key (manager) references users (id)
);
CREATE TABLE adressData (
    id integer PRIMARY key AUTOINCREMENT,
    adminDistrict varchar(100),
    townDistrict varchar(100),
    adress varchar(100),
    buildingSerial varchar(10),
    projectType varchar(100),
    dateStart varchar(50),
    dateEnd varchar(50),
    contractId integer,
    price decimal,
    foreign key (contractId) references contract (id) on Delete cascade
);
CREATE TABLE building (
    name VARCHAR(100),
    value VARCHAR(100),
    comment varchar(100),
    adressId integer,
    foreign key (adressId) references adressData (id) on Delete cascade
);
CREATE TABLE contactList (
    id integer PRIMARY KEY AUTOINCREMENT,
    name varchar(100),
    adressId integer,
    work varchar(100),
    foreign key (adressId) references adressData (id) on Delete cascade
);
CREATE TABLE contactPerson (
    id integer PRIMARY KEY AUTOINCREMENT,
    name varchar(100),
    phone varchar(100),
    adress varchar(100),
    work varchar(100),
    contactListId integer,
    foreign key (contactListId) references contactList (id) on Delete cascade
);
CREATE TABLE adressDocument (
    pathToDirectory text,
    fatherId integer,
    foreign key (fatherId) references adressData (id) on Delete cascade
);
CREATE TABLE EED (
    pathToDirectory text,
    fatherId integer,
    foreign key (fatherId) references adressData (id) on Delete cascade
);
CREATE TABLE adressPhotoUserFolders (
    id integer PRIMARY KEY AUTOINCREMENT,
    name varchar(100),
    fatherId integer,
    foreign key (fatherId) references adressData (id) on Delete cascade
);
CREATE TABLE adressPhoto (
    id integer PRIMARY KEY AUTOINCREMENT,
    pathToDirectory text,
    fatherId integer,
    foreign key (fatherId) references adressPhotoUserFolders (id) on Delete cascade
);
CREATE TABLE worker (
    id integer PRIMARY KEY AUTOINCREMENT,
    name varchar(100),
    town varchar(100)
);
CREATE TABLE avances (
    id integer PRIMARY KEY AUTOINCREMENT,
    workerAdressId integer,
    value decimal,
    date varchar(100),
    comment varchar(100),
    foreign key (workerAdressId) references workerAdress (id) on Delete cascade
);
CREATE TABLE workerAdress (
    id integer PRIMARY KEY AUTOINCREMENT,
    workerId integer,
    name varchar(100),
    fullPrice decimal,
    foreign key (workerId) references worker (id) on Delete cascade
);
CREATE TABLE buildingMaterials (
    id integer PRIMARY KEY AUTOINCREMENT,
    adressId integer,
    name varchar(100),
    summ varchar(100),
    comment varchar(100),
    foreign key (adressId) references adressData (id) on Delete cascade
);
CREATE TABLE elevator (
    adressId integer,
    name varchar(100),
    descriptionName varchar(100),
    descriptionValue varchar(100),
    commentValue varchar(100),
    entrance varchar(100),
    foreign key (adressId) references adressData (id) on Delete cascade
);
CREATE TABLE montazh (
    id integer PRIMARY KEY AUTOINCREMENT,
    adressId integer,
    name varchar(100),
    comment varchar(100),
    phone varchar(100),
    foreign key (adressId) references adressData (id) on Delete cascade
);
CREATE TABLE accountancy (
    id integer PRIMARY KEY AUTOINCREMENT,
    pathToDirectory text
);
CREATE TABLE acceptTable (
    id integer PRIMARY KEY AUTOINCREMENT,
    userId integer,
    accountancyId integer,
    foreign key (userId) references users (id) on Delete cascade,
    foreign key (accountancyId) references accountancy (id) on Delete cascade
);
CREATE TABLE disgardTable (
    id integer PRIMARY KEY AUTOINCREMENT,
    userId integer,
    accountancyId integer,
    comment varchar(100),
    foreign key (userId) references users (id) on Delete cascade,
    foreign key (accountancyId) references accountancy (id) on Delete cascade
);
CREATE TABLE ODSH (
    id integer PRIMARY KEY AUTOINCREMENT,
entrance integer,
adressId integer,
customer varchar(100),
sizeT varchar(100),
foreign key (adressId) references adressData (id) on Delete cascade
);
CREATE TABLE ODSHTable (
    id integer PRIMARY KEY AUTOINCREMENT,
ODSHid integer,
level integer,
topEnter varchar(100),
topN varchar(100),
topV varchar(100),
leftN varchar(100),
leftV varchar(100),
rightN varchar(100),
rightV varchar(100),
summ varchar(100),
color varchar(100),
foreign key (ODSHid) references ODSH (id) on Delete cascade
)
