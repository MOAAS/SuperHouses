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
    location REFERENCES PlaceLocation ON DELETE CASCADE UNIQUE NOT NULL,
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

INSERT INTO Country VALUES(NULL, 'Afghanistan');
INSERT INTO Country VALUES(NULL, 'Albania');
INSERT INTO Country VALUES(NULL, 'Algeria');
INSERT INTO Country VALUES(NULL, 'Andorra');
INSERT INTO Country VALUES(NULL, 'Angola');
INSERT INTO Country VALUES(NULL, 'Antigua and Barbuda');
INSERT INTO Country VALUES(NULL, 'Argentina');
INSERT INTO Country VALUES(NULL, 'Armenia');
INSERT INTO Country VALUES(NULL, 'Australia');
INSERT INTO Country VALUES(NULL, 'Austria');
INSERT INTO Country VALUES(NULL, 'Azerbaijan');
INSERT INTO Country VALUES(NULL, 'Bahamas');
INSERT INTO Country VALUES(NULL, 'Bahrain');
INSERT INTO Country VALUES(NULL, 'Bangladesh');
INSERT INTO Country VALUES(NULL, 'Barbados');
INSERT INTO Country VALUES(NULL, 'Belarus');
INSERT INTO Country VALUES(NULL, 'Belgium');
INSERT INTO Country VALUES(NULL, 'Belize');
INSERT INTO Country VALUES(NULL, 'Benin');
INSERT INTO Country VALUES(NULL, 'Bhutan');
INSERT INTO Country VALUES(NULL, 'Bolivia');
INSERT INTO Country VALUES(NULL, 'Bosnia and Herzegovina');
INSERT INTO Country VALUES(NULL, 'Botswana');
INSERT INTO Country VALUES(NULL, 'Brazil');
INSERT INTO Country VALUES(NULL, 'Brunei');
INSERT INTO Country VALUES(NULL, 'Bulgaria');
INSERT INTO Country VALUES(NULL, 'Burkina Faso');
INSERT INTO Country VALUES(NULL, 'Burundi');
INSERT INTO Country VALUES(NULL, "Côte d'Ivoire");
INSERT INTO Country VALUES(NULL, 'Cabo Verde');
INSERT INTO Country VALUES(NULL, 'Cambodia');
INSERT INTO Country VALUES(NULL, 'Cameroon');
INSERT INTO Country VALUES(NULL, 'Canada');
INSERT INTO Country VALUES(NULL, 'Central African Republic');
INSERT INTO Country VALUES(NULL, 'Chad');
INSERT INTO Country VALUES(NULL, 'Chile');
INSERT INTO Country VALUES(NULL, 'China');
INSERT INTO Country VALUES(NULL, 'Colombia');
INSERT INTO Country VALUES(NULL, 'Comoros');
INSERT INTO Country VALUES(NULL, 'Congo (Congo-Brazzaville)');
INSERT INTO Country VALUES(NULL, 'Costa Rica');
INSERT INTO Country VALUES(NULL, 'Croatia');
INSERT INTO Country VALUES(NULL, 'Cuba');
INSERT INTO Country VALUES(NULL, 'Cyprus');
INSERT INTO Country VALUES(NULL, 'Czechia (Czech Republic)');
INSERT INTO Country VALUES(NULL, 'Democratic Republic of the Congo');
INSERT INTO Country VALUES(NULL, 'Denmark');
INSERT INTO Country VALUES(NULL, 'Djibouti');
INSERT INTO Country VALUES(NULL, 'Dominica');
INSERT INTO Country VALUES(NULL, 'Dominican Republic');
INSERT INTO Country VALUES(NULL, 'Ecuador');
INSERT INTO Country VALUES(NULL, 'Egypt');
INSERT INTO Country VALUES(NULL, 'El Salvador');
INSERT INTO Country VALUES(NULL, 'Equatorial Guinea');
INSERT INTO Country VALUES(NULL, 'Eritrea');
INSERT INTO Country VALUES(NULL, 'Estonia');
INSERT INTO Country VALUES(NULL, 'Eswatini');
INSERT INTO Country VALUES(NULL, 'Ethiopia');
INSERT INTO Country VALUES(NULL, 'Fiji');
INSERT INTO Country VALUES(NULL, 'Finland');
INSERT INTO Country VALUES(NULL, 'France');
INSERT INTO Country VALUES(NULL, 'Gabon');
INSERT INTO Country VALUES(NULL, 'Gambia');
INSERT INTO Country VALUES(NULL, 'Georgia');
INSERT INTO Country VALUES(NULL, 'Germany');
INSERT INTO Country VALUES(NULL, 'Ghana');
INSERT INTO Country VALUES(NULL, 'Greece');
INSERT INTO Country VALUES(NULL, 'Grenada');
INSERT INTO Country VALUES(NULL, 'Guatemala');
INSERT INTO Country VALUES(NULL, 'Guinea');
INSERT INTO Country VALUES(NULL, 'Guinea-Bissau');
INSERT INTO Country VALUES(NULL, 'Guyana');
INSERT INTO Country VALUES(NULL, 'Haiti');
INSERT INTO Country VALUES(NULL, 'Holy See');
INSERT INTO Country VALUES(NULL, 'Honduras');
INSERT INTO Country VALUES(NULL, 'Hungary');
INSERT INTO Country VALUES(NULL, 'Iceland');
INSERT INTO Country VALUES(NULL, 'India');
INSERT INTO Country VALUES(NULL, 'Indonesia');
INSERT INTO Country VALUES(NULL, 'Iran');
INSERT INTO Country VALUES(NULL, 'Iraq');
INSERT INTO Country VALUES(NULL, 'Ireland');
INSERT INTO Country VALUES(NULL, 'Israel');
INSERT INTO Country VALUES(NULL, 'Italy');
INSERT INTO Country VALUES(NULL, 'Jamaica');
INSERT INTO Country VALUES(NULL, 'Japan');
INSERT INTO Country VALUES(NULL, 'Jordan');
INSERT INTO Country VALUES(NULL, 'Kazakhstan');
INSERT INTO Country VALUES(NULL, 'Kenya');
INSERT INTO Country VALUES(NULL, 'Kiribati');
INSERT INTO Country VALUES(NULL, 'Kuwait');
INSERT INTO Country VALUES(NULL, 'Kyrgyzstan');
INSERT INTO Country VALUES(NULL, 'Laos');
INSERT INTO Country VALUES(NULL, 'Latvia');
INSERT INTO Country VALUES(NULL, 'Lebanon');
INSERT INTO Country VALUES(NULL, 'Lesotho');
INSERT INTO Country VALUES(NULL, 'Liberia');
INSERT INTO Country VALUES(NULL, 'Libya');
INSERT INTO Country VALUES(NULL, 'Liechtenstein');
INSERT INTO Country VALUES(NULL, 'Lithuania');
INSERT INTO Country VALUES(NULL, 'Luxembourg');
INSERT INTO Country VALUES(NULL, 'Madagascar');
INSERT INTO Country VALUES(NULL, 'Malawi');
INSERT INTO Country VALUES(NULL, 'Malaysia');
INSERT INTO Country VALUES(NULL, 'Maldives');
INSERT INTO Country VALUES(NULL, 'Mali');
INSERT INTO Country VALUES(NULL, 'Malta');
INSERT INTO Country VALUES(NULL, 'Marshall Islands');
INSERT INTO Country VALUES(NULL, 'Mauritania');
INSERT INTO Country VALUES(NULL, 'Mauritius');
INSERT INTO Country VALUES(NULL, 'Mexico');
INSERT INTO Country VALUES(NULL, 'Micronesia');
INSERT INTO Country VALUES(NULL, 'Moldova');
INSERT INTO Country VALUES(NULL, 'Monaco');
INSERT INTO Country VALUES(NULL, 'Mongolia');
INSERT INTO Country VALUES(NULL, 'Montenegro');
INSERT INTO Country VALUES(NULL, 'Morocco');
INSERT INTO Country VALUES(NULL, 'Mozambique');
INSERT INTO Country VALUES(NULL, 'Myanmar (formerly Burma)');
INSERT INTO Country VALUES(NULL, 'Namibia');
INSERT INTO Country VALUES(NULL, 'Nauru');
INSERT INTO Country VALUES(NULL, 'Nepal');
INSERT INTO Country VALUES(NULL, 'Netherlands');
INSERT INTO Country VALUES(NULL, 'New Zealand');
INSERT INTO Country VALUES(NULL, 'Nicaragua');
INSERT INTO Country VALUES(NULL, 'Niger');
INSERT INTO Country VALUES(NULL, 'Nigeria');
INSERT INTO Country VALUES(NULL, 'North Korea');
INSERT INTO Country VALUES(NULL, 'North Macedonia');
INSERT INTO Country VALUES(NULL, 'Norway');
INSERT INTO Country VALUES(NULL, 'Oman');
INSERT INTO Country VALUES(NULL, 'Pakistan');
INSERT INTO Country VALUES(NULL, 'Palau');
INSERT INTO Country VALUES(NULL, 'Palestine State');
INSERT INTO Country VALUES(NULL, 'Panama');
INSERT INTO Country VALUES(NULL, 'Papua New Guinea');
INSERT INTO Country VALUES(NULL, 'Paraguay');
INSERT INTO Country VALUES(NULL, 'Peru');
INSERT INTO Country VALUES(NULL, 'Philippines');
INSERT INTO Country VALUES(NULL, 'Poland');
INSERT INTO Country VALUES(NULL, 'Portugal');
INSERT INTO Country VALUES(NULL, 'Qatar');
INSERT INTO Country VALUES(NULL, 'Romania');
INSERT INTO Country VALUES(NULL, 'Russia');
INSERT INTO Country VALUES(NULL, 'Rwanda');
INSERT INTO Country VALUES(NULL, 'Saint Kitts and Nevis');
INSERT INTO Country VALUES(NULL, 'Saint Lucia');
INSERT INTO Country VALUES(NULL, 'Saint Vincent and the Grenadines');
INSERT INTO Country VALUES(NULL, 'Samoa');
INSERT INTO Country VALUES(NULL, 'San Marino');
INSERT INTO Country VALUES(NULL, 'Sao Tome and Principe');
INSERT INTO Country VALUES(NULL, 'Saudi Arabia');
INSERT INTO Country VALUES(NULL, 'Senegal');
INSERT INTO Country VALUES(NULL, 'Serbia');
INSERT INTO Country VALUES(NULL, 'Seychelles');
INSERT INTO Country VALUES(NULL, 'Sierra Leone');
INSERT INTO Country VALUES(NULL, 'Singapore');
INSERT INTO Country VALUES(NULL, 'Slovakia');
INSERT INTO Country VALUES(NULL, 'Slovenia');
INSERT INTO Country VALUES(NULL, 'Solomon Islands');
INSERT INTO Country VALUES(NULL, 'Somalia');
INSERT INTO Country VALUES(NULL, 'South Africa');
INSERT INTO Country VALUES(NULL, 'South Korea');
INSERT INTO Country VALUES(NULL, 'South Sudan');
INSERT INTO Country VALUES(NULL, 'Spain');
INSERT INTO Country VALUES(NULL, 'Sri Lanka');
INSERT INTO Country VALUES(NULL, 'Sudan');
INSERT INTO Country VALUES(NULL, 'Suriname');
INSERT INTO Country VALUES(NULL, 'Sweden');
INSERT INTO Country VALUES(NULL, 'Switzerland');
INSERT INTO Country VALUES(NULL, 'Syria');
INSERT INTO Country VALUES(NULL, 'Tajikistan');
INSERT INTO Country VALUES(NULL, 'Tanzania');
INSERT INTO Country VALUES(NULL, 'Thailand');
INSERT INTO Country VALUES(NULL, 'Timor-Leste');
INSERT INTO Country VALUES(NULL, 'Togo');
INSERT INTO Country VALUES(NULL, 'Tonga');
INSERT INTO Country VALUES(NULL, 'Trinidad and Tobago');
INSERT INTO Country VALUES(NULL, 'Tunisia');
INSERT INTO Country VALUES(NULL, 'Turkey');
INSERT INTO Country VALUES(NULL, 'Turkmenistan');
INSERT INTO Country VALUES(NULL, 'Tuvalu');
INSERT INTO Country VALUES(NULL, 'Uganda');
INSERT INTO Country VALUES(NULL, 'Ukraine');
INSERT INTO Country VALUES(NULL, 'United Arab Emirates');
INSERT INTO Country VALUES(NULL, 'United Kingdom');
INSERT INTO Country VALUES(NULL, 'United States of America');
INSERT INTO Country VALUES(NULL, 'Uruguay');
INSERT INTO Country VALUES(NULL, 'Uzbekistan');
INSERT INTO Country VALUES(NULL, 'Vanuatu');
INSERT INTO Country VALUES(NULL, 'Venezuela');
INSERT INTO Country VALUES(NULL, 'Vietnam');
INSERT INTO Country VALUES(NULL, 'Yemen');
INSERT INTO Country VALUES(NULL, 'Zambia');
INSERT INTO Country VALUES(NULL, 'Zimbabwe');

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

