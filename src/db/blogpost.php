<?php

include("db.php");

class Blogpost {

    private $db;
    private $blogId;

    public function __construct($id = 0) {
        $this->db = new Db();
        $this->setpost($id);
    }

    function setpost($id) {
        if (is_numeric($id)) {
            $this->blogId = $this->test_input($id);
        } else {
            throw new \Exception('Not a valid week number');
        }
    }

    function getBlogPost() {
        return $this->db->getBlogPostById($this->blogId);
    }

    function getAllBlogPosts() {
        return $this->db->getJoinedPostsUsers();
    }

    function test_input($data) { //Validation and security
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }


}