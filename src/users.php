<?php 

include("header.php");
include("db/users.php");
ini_set("display_errors", 1);

$users = new Users();

if (isset($_GET["id"])) {
    
    $user = $users->getUserAndPostsById($_GET["id"]);
    //print_r($user);
    if (count($user) >= 1) {
        $html = "<article><h1>" . $user[0]["name"] . " " . $user[0]["surname"] . "</h1>";
        $html .= "<p>Email: " . $user[0]["email"] . "</p>";
        $html .= "<p>Member since: " . $user[0]["created"]. "</p>";
        $count = $users->countPostsByUser($user[0]["userId"]);
        $nr = $count[0]["posts"]; 
        $html .= "<h2>Written blogposts: ($nr) </h2>";
        
        foreach ($user as $field) {
            $html .= '<h3><a href="blogposts.php?blog=' . $field["id"] . '">' . $field["title"] . '</a></h3> ';
        }
        $html .= "</article>";
    } else {
        $html = "<h1>No user found</h1>";
    }
    
} else {
    $allUsers = $users->getAllUsers();
    $html = "<div class='content'><h1>Users</h1><hr><p>This list displays all users</p>";
    foreach ($allUsers as $user) {
        $html .= '<a href="users.php?id=' . $user["id"] . '">' . $user["name"] . " " . $user["surname"] . '</a></br> ';
    }
    $html .= "</div>";
    //print_r($allUsers);
}

?>

<ul>
<li><a href="index.php">Home</a></li>
<li><a href="weeks.php">Weeks</a></li>
<li><a href="authors.php">Authors</a></li>
<li><a href="blogposts.php">Blogposts</a></li>
<li><a class="active" href="users.php">Users</a></li>
</ul>
<?php
echo $html;
