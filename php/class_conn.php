<?php

/**
 * A PHP class to interact with a MySQL database using PDO.
 * Source: https://devjunky.com/PHP-OOP-Database-Class-Example/
 */

class Database {

    private $connection = null;

    /**
     * Constructor for the Database class, establishes a database connection using PDO.
     *
     * @param string $dbhost - Database host
     * @param string $dbname - Database name
     * @param string $username - Database username
     * @param string $password - Database password
     */
    public function __construct($dbhost = "localhost", $dbname = "myDataBaseName", $username = "root", $password = "") {
        try {
            $this->connection = new PDO("mysql:host={$dbhost};dbname={$dbname};charset=UTF8", $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Insert a row(s) into a database table.
     *
     * @param string $statement - SQL insert statement
     * @param array $parameters - Parameters for the SQL statement
     * @return int - The last inserted ID
     * @throws Exception
     */
    public function Insert($statement = "", $parameters = []) {
        try {
            $this->executeStatement($statement, $parameters);
            return $this->connection->lastInsertId();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Select rows from a database table.
     *
     * @param string $statement - SQL select statement
     * @param array $parameters - Parameters for the SQL statement
     * @return array - Array of selected rows
     * @throws Exception
     */
    public function Select($statement = "", $parameters = []) {
        try {
            $stmt = $this->executeStatement($statement, $parameters);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Count rows in a database table based on a condition.
     *
     * @param string $statement - SQL count statement
     * @param array $parameters - Parameters for the SQL statement
     * @return int - Number of rows returned by the count query
     * @throws Exception
     */
    public function Count($statement = "", $parameters = []) {
        try {
            $stmt = $this->executeStatement($statement, $parameters);
            return $stmt->rowCount();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Update rows in a database table based on a condition.
     *
     * @param string $statement - SQL update statement
     * @param array $parameters - Parameters for the SQL statement
     * @throws Exception
     */
    public function Update($statement = "", $parameters = []) {
        try {
            $this->executeStatement($statement, $parameters);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Remove rows from a database table based on a condition.
     *
     * @param string $statement - SQL delete statement
     * @param array $parameters - Parameters for the SQL statement
     * @throws Exception
     */
    public function Remove($statement = "", $parameters = []) {
        try {
            $this->executeStatement($statement, $parameters);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Execute a SQL statement against the database.
     *
     * @param string $statement - SQL statement to execute
     * @param array $parameters - Parameters for the SQL statement
     * @return PDOStatement - The prepared statement object
     * @throws Exception
     */
    private function executeStatement($statement = "", $parameters = []) {
        try {
            $stmt = $this->connection->prepare($statement);
            $stmt->execute($parameters);
            return $stmt;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Close the database connection.
     */
    public function Close() {
        $this->connection = null;
    }
}

?>