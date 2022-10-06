<?php

include("db.php");

class Week{

    private $database;
    private $nr;
    private $weekData;
    private $authors;
    
    public function __construct($week) {
		$this->database = new Db();
        $this->database->createTableWeeks(); // If not exists
        $this->setWeek($week);
        $this->getWeekFromDb();
        $this->getAuthorsFromDb(); // TODO Is this useful?
    }
    
    function setWeek($week) {
        if (is_numeric($week)) {
            $this->nr = $this->test_input($week);
        } else {
            throw new \Exception('Not a valid week number');
        }
    }
    function getWeekFromDb() {
        $this->weekData = $this->database->getWeek($this->nr);
    }

    function getWeek() {
        return $this->weekData;
    }

    function getAuthorsFromDb() {
        $this->authors = $this->database->getAuthorsByWeek($this->nr);
    }

    function getAuthors() {
        return $this->authors;
    }

    function getAuthorsbyWeek() {
        return $this->database->getAuthorsByWeekMulti($this->nr);
    }

    function getBlogPostRelatedTo() {
        return $this->database->getBlogPostRelatedTo($this->nr);
    }


    function getAuthorById($id) {
        return $this->database->getAuthorById($id);
    }

    function test_input($data) { //Validation and security
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

}




