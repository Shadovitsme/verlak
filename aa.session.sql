-- CREATE TABLE contract (contractNumber integer PRIMARY KEY AUTOINCREMENT, dateStart varchar(50), dateEnd varchar(50), town varchar(100), organization boolean, manager BIGINT,
-- foreign key (manager) references users (id)
-- )

-- CREATE  TABLE adressData (id integer PRIMARY key AUTOINCREMENT,
-- adminDistrict varchar(100),townDistrict varchar(100), adress varchar(100), buildingSerial varchar(10), projectType varchar(100), dateStart varchar(50),dateEnd varchar(50), contractId integer, price decimal, foreign key (contractId) references contract (id))

-- CREATE TABLE building (name VARCHAR(100), value VARCHAR(100),comment varchar(100), adressId integer, foreign key (adressId) references adressData (id));

-- CREATE TABLE contactList (id integer PRIMARY KEY AUTOINCREMENT, name varchar(100), adressId integer,foreign key (adressId) references adressData (id) );

-- CREATE TABLE contactPerson (name varchar(100), phone varchar(100), adress varchar(100), contactListId integer, foreign key (contactListId) references contactList (id));

-- CREATE TABLE adressDocument (pathToDirectory text, adressId integer, foreign key (adressId) references adressData (id));

-- CREATE TABLE EED (pathToDirectory text, adressId integer, foreign key (adressId) references adressData (id));

-- CREATE TABLE adressPhotoUserFolders (id integer PRIMARY KEY AUTOINCREMENT, name varchar(100), adressId integer,foreign key (adressId) references adressData (id) );

-- CREATE TABLE adressPhoto (pathToDirectory text, adressPhotoUserFoldersId integer, foreign key (adressPhotoUserFoldersId) references adressPhotoUserFolders (id));

-- CREATE TABLE worker (id integer PRIMARY KEY AUTOINCREMENT, adressId integer, name varchar(100), phone varchar(100), fullPrice decimal, comment varchar(100),foreign key (adressId) references adressData (id));

-- CREATE TABLE avances (workerId integer, value decimal, date varchar(50), comment varchar(100),foreign key (workerId) references worker (id));

-- CREATE TABLE buildingMaterials (adressId integer, name varchar(100), summ varchar(100), comment varchar(100),foreign key (adressId) references adressData (id))
