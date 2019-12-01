PRAGMA foreign_keys = OFF;

DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS PlaceLocation;
DROP TABLE IF EXISTS Country;
DROP TABLE IF EXISTS Place;
DROP TABLE IF EXISTS Reservation;
DROP TABLE IF EXISTS UserNotification;

CREATE TABLE User (
    id INTEGER PRIMARY KEY,
    username VARCHAR UNIQUE NOT NULL,
    passwordHash VARCHAR NOT NULL,
    displayname VARCHAR NOT NULL,
    country INTEGER REFERENCES Country,
    city VARCHAR
);

CREATE TABLE Country (
    id INTEGER PRIMARY KEY,
    countryName VARCHAR UNIQUE NOT NULL
);

CREATE TABLE PlaceLocation (
    id INTEGER PRIMARY KEY,
    country REFERENCES Country,
    city VARCHAR,
    address VARCHAR
);

CREATE TABLE Place (
    id INTEGER PRIMARY KEY,
    location REFERENCES PlaceLocation UNIQUE NOT NULL,
    owner REFERENCES User NOT NULL,
    title VARCHAR,
    description VARCHAR,
    price REAL,
    minPeople INTEGER,
    maxPeople INTEGER,
    CONSTRAINT CHK_people CHECK (minPeople <= maxPeople),
    CONSTRAINT CHK_price CHECK (price >= 0)
);


CREATE TABLE Reservation (
    id INTEGER PRIMARY KEY,
    dateStart DATE NOT NULL,
    dateEnd DATE NOT NULL,
    user REFERENCES User NOT NULL,
    place REFERENCES Place NOT NULL
);

CREATE TABLE UserNotification (
    id INTEGER PRIMARY KEY,
    content VARCHAR,
    dateTime DATE NOT NULL,
    user REFERENCES User NOT NULL,
    seen INTEGER,
    CONSTRAINT CHK_seen CHECK (seen = 0 OR seen = 1)
);

PRAGMA foreign_keys = ON;

INSERT INTO Country VALUES (NULL, 'Portugal');
INSERT INTO Country VALUES (NULL, 'France');
INSERT INTO Country VALUES (NULL, 'Spain');
INSERT INTO Country VALUES (NULL, 'Italy');
INSERT INTO Country VALUES (NULL, 'Denmark');
INSERT INTO Country VALUES (NULL, 'United Kingdom');
INSERT INTO Country VALUES (NULL, 'Ireland');
INSERT INTO Country VALUES (NULL, 'IKEA Land');
INSERT INTO Country VALUES (NULL, 'Finland');
INSERT INTO Country VALUES (NULL, 'Norway');
INSERT INTO Country VALUES (NULL, 'Germany');
INSERT INTO Country VALUES (NULL, 'Poland');
INSERT INTO Country VALUES (NULL, 'Croatia');
INSERT INTO Country VALUES (NULL, 'Latvia');
INSERT INTO Country VALUES (NULL, 'Estonia');
INSERT INTO Country VALUES (NULL, 'Lithuania');
INSERT INTO Country VALUES (NULL, 'Austria');
INSERT INTO Country VALUES (NULL, 'Switzerland');
INSERT INTO Country VALUES (NULL, 'Netherlands');
INSERT INTO Country VALUES (NULL, 'Belgium');
INSERT INTO Country VALUES (NULL, 'Russia');
INSERT INTO Country VALUES (NULL, 'Ukraine');
INSERT INTO Country VALUES (NULL, 'Bulgaria');
INSERT INTO Country VALUES (NULL, 'Belarus');
INSERT INTO Country VALUES (NULL, 'Greece');
INSERT INTO Country VALUES (NULL, 'Turkey');

INSERT INTO User VALUES(1,"Marco","7110eda4d09e062aa5e4a390b0a572ac0d2c0220","Marco321",1,"Lisbon");

INSERT INTO PlaceLocation VALUES (NULL, 1, "Porto", "Rua Joao Carlos, 123");
INSERT INTO PlaceLocation VALUES (NULL, 1, "Faro", "Rua Lelelelele, 898");
INSERT INTO PlaceLocation VALUES (NULL, 1, "Faro", "Rua Falso 332");
INSERT INTO PlaceLocation VALUES (NULL, 1, "Faro", "Rua do lixo, 2");
INSERT INTO PlaceLocation VALUES (NULL, 1, "Faro", "Rua debaixo da praia, 1");

INSERT INTO Place VALUES (NULL, 1, 1, "The good place", "When I was just a little boy, my parents would take me to a cozy house in Porto in the cold Winter. I have many fond memories of sitting around the fireplace with my parents, drinking whiskey and getting extra close to my uncle for warmth. And now you can too!", 96.25, 3, 5);
INSERT INTO Place VALUES (NULL, 2, 1, "Cute house near the beach", "But this one's cuter", 50.00, 3, 5);
INSERT INTO Place VALUES (NULL, 3, 1, "Cute house near the beach", "But this one's nearer", 1000.00, 8, 10);
INSERT INTO Place VALUES (NULL, 4, 1, "Awful house on the beach", "A great place", 75.00, 3, 5);
INSERT INTO Place VALUES (NULL, 5, 1, "The perfect house under the beach", "You won't enjoy this", 4.00, 1, 2);

-- All passwords are 1234 in SHA-1 format
/*
INSERT INTO User VALUES ("dommyWoods", "7110eda4d09e062aa5e4a390b0a572ac0d2c0220", "Dominic Woods");
INSERT INTO User VALUES ("zaccOld", "7110eda4d09e062aa5e4a390b0a572ac0d2c0220", "Zachary Young");
INSERT INTO User VALUES ("alHammy", "7110eda4d09e062aa5e4a390b0a572ac0d2c0220", "Alicia Hamilton");
INSERT INTO User VALUES ("coolApril", "7110eda4d09e062aa5e4a390b0a572ac0d2c0220", "Abril Cooley");
*
INSERT INTO PlaceLocation VALUES (1, "PORTUGAL", "Porto", "Rua Joao Carlos, 123");
INSERT INTO PlaceLocation VALUES (2, "PORTUGAL", "Faro", "Rua Lelelelele, 898");
INSERT INTO PlaceLocation VALUES (3, "PORTUGAL", "Faro", "Rua Falso 332");
INSERT INTO PlaceLocation VALUES (4, "PORTUGAL", "Faro", "Rua do lixo, 2");
INSERT INTO PlaceLocation VALUES (5, "PORTUGAL", "Faro", "Rua debaixo da praia, 1");

INSERT INTO Place VALUES (1, 1, "zaccOld", "The good place", "A great place", 96.25);
INSERT INTO Place VALUES (2, 2, "alHammy", "Cute house near the beach", "But this one's cuter", 50.00);
INSERT INTO Place VALUES (3, 3, "coolApril", "Cute house near the beach", "But this one's nearer", 1000.00);
INSERT INTO Place VALUES (4, 4, "coolApril", "Awful house on the beach", "A great place", 75.00);
INSERT INTO Place VALUES (5, 5, "coolApril", "The perfect house under the beach", "You won't enjoy this", 4.00);

INSERT INTO Reservation VALUES (1, "2019-11-07", "2019-11-11", "dommyWoods", 1);
INSERT INTO Reservation VALUES (2, "2019-11-07", "2019-11-12", "zaccOld", 4);
*/
