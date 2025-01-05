CREATE DATABASE IF NOT EXISTS restaurantDB;
USE restaurantDB;

CREATE TABLE reservations (
    firstName VARCHAR(30) NOT NULL, -- Customer's first name
    lastName VARCHAR(30) NOT NULL, -- Customer's last name
    emailAddress VARCHAR(320) PRIMARY KEY NOT NULL, -- Customer's email address
    numberOfPeople INT NOT NULL, -- Number of people attending
    dateOfReservation DATE NOT NULL, -- Date of the reservation
    timeSlot TIME NOT NULL -- Reserved time slot
);

CREATE TABLE staffAccount (
    staffUsername VARCHAR(30) PRIMARY KEY NOT NULL, -- Username for the staff account
    staffPassword VARCHAR(30) NOT NULL -- Password for the staff account
);