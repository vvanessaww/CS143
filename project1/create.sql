CREATE TABLE Movie(id int PRIMARY KEY, title varchar(100), year int, rating varchar(10), company varchar(50));

CREATE TABLE Actor(id int PRIMARY KEY, last varchar(20), first varchar(20), sex varchar(6), dob date, dod date);

CREATE TABLE MovieGenre(mid int, genre varchar(20));

CREATE TABLE MovieActor(mid int, aid int, role VARCHAR(50));

CREATE TABLE Review(name VARCHAR(20), time DATETIME, mid INT, rating INT, comment TEXT); 