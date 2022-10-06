<?php

include("db.php");

class Authors{

    private $database;
    private $authors;
    
    public function __construct() {
		$this->database = new Db();
        $this->database->createTableAuthors(); // If not exists
        $this->getAuthorsFromDb();
       // $this->getWeekFromDb();
    }
    
    function setWeek() {
        if (is_numeric($_GET["week"])) {
            $this->nr = $this->test_input($_GET["week"]);
        } else {
            throw new \Exception('Not a valid week number');
        }
    }
    function getAuthorsFromDb() {
        $this->authors = $this->database->getAuthors();
    }

    function getAuthors() {
        return $this->authors;
    }
    
    function getAuthorsWithView() {
        return $this->database->getAuthorsWithView();
    }
    function getAuthorById($id) {
        return $this->database->getAuthorById($id);
    }

    function getWeeksByAuthorId($id) {
        return $this->database->getWeeksByAuthors($id);
    }

    function test_input($data) { //Validation and security
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

}




