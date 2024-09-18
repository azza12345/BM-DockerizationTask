CREATE DATABASE myDB;

CREATE TABLE myDB.users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL
);

INSERT INTO myDB.users (firstname, lastname)
VALUES ("Eslam", "Ali");
