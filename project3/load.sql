DROP TABLE IF EXISTS People;
DROP TABLE IF EXISTS Organizations;
DROP TABLE IF EXISTS Prizes;
DROP TABLE IF EXISTS Affiliations;

CREATE TABLE People(id INT, givenName VARCHAR(255), familyName VARCHAR(255), gender VARCHAR(10), birthDate DATETIME, birthCity VARCHAR(255), birthCountry VARCHAR(255));
LOAD DATA LOCAL INFILE './People.del' INTO TABLE People FIELDS TERMINATED BY ';' OPTIONALLY ENCLOSED BY '"';

CREATE TABLE Organizations(id INT, orgName VARCHAR(255), orgDate DATETIME, orgCity VARCHAR(255), orgCountry VARCHAR(255));
LOAD DATA LOCAL INFILE './Organizations.del' INTO TABLE Organizations FIELDS TERMINATED BY ';' OPTIONALLY ENCLOSED BY '"';

CREATE TABLE Prizes(id INT, prizeKey VARCHAR(255), awardYear INT, category VARCHAR(255), sortOrder INT);
LOAD DATA LOCAL INFILE './Prizes.del' INTO TABLE Prizes FIELDS TERMINATED BY ';' OPTIONALLY ENCLOSED BY '"';

CREATE TABLE Affiliations(prizeKey VARCHAR(255), affilKey VARCHAR(255), name VARCHAR(255), city VARCHAR(255), country VARCHAR(255));
LOAD DATA LOCAL INFILE './Affiliations.del' INTO TABLE Affiliations FIELDS TERMINATED BY ';' OPTIONALLY ENCLOSED BY '"';
