PRAGMA foreign_keys=OFF;

DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS PlaceLocation;
DROP TABLE IF EXISTS Country;
DROP TABLE IF EXISTS Place;
DROP TABLE IF EXISTS Reservation;
DROP TABLE IF EXISTS UserNotification;
DROP TABLE IF EXISTS Rating;
DROP TABLE IF EXISTS UserMessage;

DROP VIEW IF EXISTS PlaceComplete;

CREATE TABLE User (
    id INTEGER PRIMARY KEY,
    username VARCHAR UNIQUE NOT NULL,
    passwordHash VARCHAR NOT NULL,
    displayname VARCHAR NOT NULL,
    country REFERENCES Country,
    city VARCHAR
);

CREATE TABLE Country (
    id INTEGER PRIMARY KEY,
    countryName VARCHAR UNIQUE NOT NULL
);

CREATE TABLE PlaceLocation (
    id INTEGER PRIMARY KEY,
    country INTEGER REFERENCES Country NOT NULL,
    city VARCHAR NOT NULL,
    address VARCHAR NOT NULL
);

CREATE TABLE Place (
    id INTEGER PRIMARY KEY,
    location REFERENCES PlaceLocation UNIQUE NOT NULL,
    owner REFERENCES User NOT NULL,
    title VARCHAR NOT NULL,
    description VARCHAR NOT NULL,
    pricePerDay REAL NOT NULL,
    capacity INTEGER NOT NULL,
    numRooms INTEGER NOT NULL,
    numBeds INTEGER NOT NULL,
    numBathrooms INTEGER NOT NULL,
    CONSTRAINT CHK_people CHECK (capacity > 0),
    CONSTRAINT CHK_rooms CHECK (numRooms > 0),
    CONSTRAINT CHK_beds CHECK (numBeds > 0),
    CONSTRAINT CHK_bathrooms CHECK (numBathrooms > 0),
    CONSTRAINT CHK_price CHECK (pricePerDay > 0)
);

CREATE VIEW PlaceComplete AS 
    SELECT Place.id AS id, countryName, PlaceLocation.city AS city, address, username AS ownerUsername, displayname AS ownerName, title, description, pricePerDay, capacity, numRooms, numBeds, numBathrooms
    FROM Place JOIN PlaceLocation ON Place.location = PlaceLocation.id JOIN Country ON PlaceLocation.country = Country.id JOIN User ON Place.owner = User.id;

CREATE TABLE Reservation (
    id INTEGER PRIMARY KEY,
    pricePerDay REAL NOT NULL,
    dateStart DATE NOT NULL,
    dateEnd DATE NOT NULL,
    user REFERENCES User NOT NULL,
    place REFERENCES Place NOT NULL,
    CONSTRAINT CHK_range CHECK (dateStart < dateEnd)
);

CREATE TABLE UserNotification (
    id INTEGER PRIMARY KEY,
    link VARCHAR,
    content VARCHAR,
    dateTime DATE NOT NULL,
    user REFERENCES User NOT NULL,
    seen INTEGER,
    CONSTRAINT CHK_seen CHECK (seen = 0 OR seen = 1)
);

CREATE TABLE Rating (
    reservation PRIMARY KEY REFERENCES Reservation,
    rating INTEGER NOT NULL,
    comment VARCHAR NOT NULL,
    reply VARCHAR,
    CONSTRAINT CHK_inbounds CHECK (rating >= 1 AND rating <= 5),
    CONSTRAINT CHK_comments CHECK (comment != "" AND reply != "")
);

CREATE TABLE UserMessage (
    id INTEGER PRIMARY KEY,
    content VARCHAR NOT NULL,
    sendTime DATE NOT NULL,
    seen INTEGER,
    sender REFERENCES User NOT NULL,
    receiver REFERENCES User NOT NULL,
    CONSTRAINT CHK_seen CHECK (seen = 0 OR seen = 1),
    CONSTRAINT CHK_fromNotTo CHECK (sender != receiver)
);

PRAGMA foreign_keys=ON;

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
INSERT INTO User VALUES(2,"Polo","7110eda4d09e062aa5e4a390b0a572ac0d2c0220","Polo123",1,"Lisbon");

INSERT INTO PlaceLocation VALUES (NULL, 1, "Porto", "Rua Joao Carlos, 123");
INSERT INTO PlaceLocation VALUES (NULL, 1, "Faro", "Rua Lelelelele, 898");
INSERT INTO PlaceLocation VALUES (NULL, 1, "Faro", "Rua Falso 332");
INSERT INTO PlaceLocation VALUES (NULL, 1, "Faro", "Rua do lixo, 2");
INSERT INTO PlaceLocation VALUES (NULL, 1, "Faro", "Rua debaixo da praia, 1");

INSERT INTO Place VALUES (NULL, 1, 1, "The good place", "When I was just a little boy, my parents would take me to a cozy house in Porto in the cold Winter. I have many fond memories of sitting around the fireplace with my parents, drinking whiskey and getting extra close to my uncle for warmth. And now you can too!", 96.25, 5, 2, 3, 2);
INSERT INTO Place VALUES (NULL, 2, 1, "Cute house near the beach", "But this one's cuter", 50.00, 5, 1, 3, 2);
INSERT INTO Place VALUES (NULL, 3, 1, "Cute house near the beach", "But this one's nearer", 1000.00, 10, 3, 6, 3);
INSERT INTO Place VALUES (NULL, 4, 1, "Awful house on the beach", "A great place", 75.00, 5, 1, 1, 1);
INSERT INTO Place VALUES (NULL, 5, 1, "The perfect house under the beach", "You won't enjoy this", 4.00, 2, 1, 1, 1);

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

- login signup c/ JS
- responsive
- rest API
*/
