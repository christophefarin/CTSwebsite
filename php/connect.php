<?php

/*
    This PHP code snippet includes a database connection class and establishes a connection to a MySQL database. Here's a breakdown of the documentation for this code:

    Purpose:
    - The code is used to create and instantiate an instance of a Database class for connecting to a MySQL database.
    Dependencies:
    - This code requires the presence of the "class_conn.php" file, which likely contains the Database class definition.
    - It relies on credentials to connect to a MySQL database running on "localhost" with the username "root" and password "root".
    Usage:
    - After including the "class_conn.php" file, an instance of the Database class is created by passing the necessary parameters: hostname, database name, username, and password.
    Database Connection Details:
    - Hostname: localhost
    - Database Name: ods_db
    - Username: root
    - Password: root
    Resource:
    - A link to a resource (https://devjunky.com/PHP-OOP-Database-Class-Example/) has been provided as a reference. This link may contain relevant information about implementing an Object-Oriented Programming (OOP) approach for database interactions in PHP.
*/

//Create-Instantiate the Database Class
require_once("class_conn.php");
$db = new Database(
    "localhost",
    "ods_db",
    "root",
    "root"
);
?>