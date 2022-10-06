<?php

//namespace db;

class Db{

    private $host ='localhost'; // Change
    private $user ='root'; // Change
    private $password ='root'; // Change
    private $database = 'babyApp'; // Change
    private $tableWeeks = 'weeks';
    private $tableAuthors = 'authors';
    private $tableWrittenBy = 'writtenBy';
    private $tableUsers = 'users';
    private $tablePosts = 'blogposts';
    private $tableTrimester = 'trimesters';
    private $conn;
    
    public function __construct() {
		$this->connect();
        $this->checkConnection();
	}

    function connect() {
        $this->conn = mysqli_connect($this->host, $this->user, $this->password, $this->database);
    }

    function checkConnection() {
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            exit();
        } else {
           // echo "Connected to database " . $this->database;
        }
    }

    function createTableWeeks(){
        $sql =  "CREATE TABLE IF NOT EXISTS $this->tableWeeks (
        nr INT(20) NOT NULL,
        trimestre VARCHAR(20) NOT NULL,
        foto VARCHAR(20) DEFAULT NULL,
        content text,
        created date NOT NULL,
        updated date DEFAULT NULL,
        PRIMARY KEY (nr)
        )";
        $this->saveDatabase($sql);
    }

    function createTableAuthors(){
        $sql =  "CREATE TABLE IF NOT EXISTS $this->tableAuthors (
        id INT(20) NOT NULL AUTO_INCREMENT,
        name VARCHAR(50) NOT NULL,
        surname VARCHAR(50) NOT NULL,
        email VARCHAR(100) DEFAULT NULL,
        about text,
        image VARCHAR(200) DEFAULT NULL,
        PRIMARY KEY (id)
        )";
        $this->saveDatabase($sql);
    }

    function saveDatabase($sql){
        if (mysqli_query($this->conn, $sql)) {
           // echo "Saved successfully";
          } else {
            echo "Error : " . mysqli_error($this->conn) . "<br>";
        }
    }

    function getData($sql){
        $result = mysqli_query($this->conn, $sql);
        $final_data = array();
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $final_data[] = $row;
               }
             return $final_data;
        } else {
            return []; // An empty array
        }
    }

    function getWeek($week){
        $sql = "SELECT nr, content, trimestre, foto, created, updated FROM $this->tableWeeks WHERE nr= $week";
        return $this->getData($sql);
    }

    function getAuthors(){
        $sql = "SELECT * FROM $this->tableAuthors";
        return $this->getData($sql);
    }

    function getAuthorsWithView(){ // VIEW
        $sql = "CREATE OR REPLACE VIEW authorsPublic AS SELECT DISTINCT name, surname, id FROM $this->tableAuthors INNER JOIN $this->tableWrittenBy ON writtenBy.authorsId = authors.id";
        $this->saveDatabase($sql); // Save view
        $sql = "SELECT * FROM authorsPublic";
        return $this->getData($sql);
    }

    function getAuthorById($id){
        $sql = "SELECT * FROM $this->tableAuthors WHERE id= $id";
        return $this->getData($sql);
    }

    function getAuthorsByWeek($week){
        $sql = "SELECT authorsId FROM $this->tableWrittenBy WHERE weeksNr= $week";
        return $this->getData($sql);
    }

    function getAuthorsByWeekMulti($week){ // Multirelation query 1
        $sql = "SELECT name, surname, id FROM $this->tableAuthors, $this->tableWrittenBy WHERE authorsId = id AND weeksNr = $week";
        return $this->getData($sql);
    }

    function getWeeksByAuthors($id){
        $sql = "SELECT weeksNr FROM $this->tableWrittenBy WHERE authorsId= $id";
        return $this->getData($sql);
    }

    function getBlogPostRelatedTo($week){ // Multirelation query 
        $sql = "SELECT name, surname, title, blogposts.id as blogpostId, users.id as userId FROM blogposts, users WHERE blogposts.week = $week AND blogposts.userId = users.id";
        return $this->getData($sql);
    }

    function getBlogPostById($id){ // Multirelation query
        $sql = "SELECT name, surname, week, title, content, blogposts.created as created, blogposts.updated as updated, blogposts.id as blogpostId, users.id as userId FROM blogposts, users WHERE blogposts.id= $id AND blogposts.userId = users.id";
        return $this->getData($sql);
    }

    function getJoinedPostsUsers(){ // JOIN
        $sql = "SELECT week, title, name, surname, blogposts.id as blogpostId FROM (blogposts INNER JOIN users ON users.id = blogposts.userId) ORDER BY week";
        return $this->getData($sql);
    }

    function getUserById($id){
        $sql = "SELECT * from $this->tableUsers WHERE id= $id";
        return $this->getData($sql);
    }

    function getUserAndPostsById($id){ // Multirelation query 2
        $sql = "SELECT * from users, blogposts WHERE users.id= $id AND users.id = blogposts.userId";
        return $this->getData($sql);
    }

    function countPostsByUser($id){ //Aggregation
        $sql = "SELECT COUNT(userId) as posts FROM blogposts WHERE userId = $id";
        return $this->getData($sql);
    }

    function getAllUsers(){
        $sql = "SELECT id, name, surname from $this->tableUsers";
        return $this->getData($sql);
    }

    

}
