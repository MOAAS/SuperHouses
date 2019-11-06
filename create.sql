PRAGMA foreign_keys = OFF;

DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Location;
DROP TABLE IF EXISTS Place;
DROP TABLE IF EXISTS Reservation;

CREATE TABLE User (
  username VARCHAR PRIMARY KEY,
  password VARCHAR,
  name VARCHAR
);

CREATE TABLE Location (
    id INTEGER PRIMARY KEY,
    country VARCHAR,
    city VARCHAR,
    address VARCHAR
);

CREATE TABLE Place (
    id INTEGER PRIMARY KEY,
    location REFERENCES Location UNIQUE,
    owner REFERENCES User,
    title VARCHAR,
    description VARCHAR,
    price REAL
);


CREATE TABLE Reservation (
    id INTEGER PRIMARY KEY,
    dateStart DATE,
    dateEnd DATE,
    user REFERENCES User,
    place REFERENCES Place
);

PRAGMA foreign_keys = ON;

-- All passwords are 1234 in SHA-1 format
INSERT INTO User VALUES ("dommyWoods", "7110eda4d09e062aa5e4a390b0a572ac0d2c0220", "Dominic Woods");
INSERT INTO User VALUES ("zaccOld", "7110eda4d09e062aa5e4a390b0a572ac0d2c0220", "Zachary Young");
INSERT INTO User VALUES ("alHammy", "7110eda4d09e062aa5e4a390b0a572ac0d2c0220", "Alicia Hamilton");
INSERT INTO User VALUES ("coolApril", "7110eda4d09e062aa5e4a390b0a572ac0d2c0220", "Abril Cooley");

INSERT INTO Location VALUES (1, "PORTUGAL", "Porto", "Rua Joao Carlos, 123");
INSERT INTO Location VALUES (2, "PORTUGAL", "Faro", "Rua Lelelelele, 898");
INSERT INTO Location VALUES (3, "PORTUGAL", "Faro", "Rua Falso 332");
INSERT INTO Location VALUES (4, "PORTUGAL", "Faro", "Rua do lixo, 2");
INSERT INTO Location VALUES (5, "PORTUGAL", "Faro", "Rua debaixo da praia, 1");

INSERT INTO Place VALUES (1, 1, "zaccOld", "The good place", "A great place", 96.25);
INSERT INTO Place VALUES (2, 2, "alHammy", "Cute house near the beach", "But this one's cuter", 50.00);
INSERT INTO Place VALUES (3, 3, "coolApril", "Cute house near the beach", "But this one's nearer", 1000.00);
INSERT INTO Place VALUES (4, 4, "coolApril", "Awful house on the beach", "A great place", 75.00);
INSERT INTO Place VALUES (5, 5, "coolApril", "The perfect house under the beach", "You won't enjoy this", 4.00);


INSERT INTO Reservation VALUES (1, "2019-11-07", "2019-11-11", "dommyWoods", 1);
INSERT INTO Reservation VALUES (2, "2019-11-07", "2019-11-12", "zaccOld", 4);
