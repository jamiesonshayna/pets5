<?php

require_once("config-database.php");

class Database
{
    // PDO object
    private $_dbh;

    /*
     * Constructs a database object.
     */
    function __construct()
    {
        try {
            // Create a new PDO connection
            $this->_dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    /*
     * This function gets all of the pets stored in the database and returns as associative array.
     *
     * @return Associative array of pets in db.
     */
    function getAllPets()
    {
        // define the query
        $sql = "SELECT * FROM pets ORDER BY id";

        // prepare the statement
        $statement = $this->_dbh->prepare($sql);

        // no params to bind

        // execute the statement
        $statement->execute();

        // get the result
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}