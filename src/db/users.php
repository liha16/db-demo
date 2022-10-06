<?php

include("db.php");

class Users {

    private $db;
    private $userId;

    public function __construct() {
        $this->db = new Db();
    }

    function getUserById($id) {
        $this->setid($id);
        return $this->db->getUserById($this->userId);
    }

    function getAllUsers() {
        return $this->db->getAllUsers();
    }

    function getUserAndPostsById($id) {
        $this->setid($id);
        return $this->db->getUserAndPostsById($this->userId);
    }
    
    function countPostsByUser($id) {
        return $this->db->countPostsByUser($id);
    }

    function setid($id) {
        if (is_numeric($id)) {
            $this->userId = $this->test_input($id);
        } else {
            throw new \Exception('Not a valid id number');
        }
    }

    function test_input($data) { //Validation and security
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }


}