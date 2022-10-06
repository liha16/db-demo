<?php 

include("header.php");
include("db/blogpost.php");
ini_set("display_errors", 1);

if (isset($_GET["blog"])) {
    $Blogpost = new Blogpost($_GET["blog"]);
    $post = $Blogpost->getBlogPost();  
    //print_r($post);
    if (count($post) == 1) {
        $title = $post[0]["title"];
        $content = $post[0]["content"];
        $created = $post[0]["created"];
        $week = $post[0]["week"];
        $html = "<article><h1>$title</h1> <p>$content</p> <p>Created $created</p> ";
        $html .= "Written by " . '<a href="users.php?id=' . $post[0]["userId"] . '">' .  $post[0]["name"] . " " . $post[0]["surname"] .  '</a> ';
        $html .= "<br>About week " . '<a href="weeks.php?week=' . $post[0]["week"] . '">' .  $post[0]["week"] .  '</a> ';
        $html .= "</article>";
    } else {
        $html = "<h1>No blogpost found</h1>";
    }
    
} else {
    $html = "<div class='content'><h1>Blogposts</h1><hr><p>This list displays all blogposts ordered by weeks, ascending</p>";
    $Blogpost = new Blogpost();
    $allPosts = $Blogpost->getAllBlogPosts();
    //print_r($allPosts);
    foreach ($allPosts as $post) {
        
        $html .= '<h2><a href="blogposts.php?blog=' . $post["blogpostId"] . '">' . $post["title"]  .  '</a> </h2>';
        $html .= 'Week <a href="weeks.php?week=' . $post["week"] . '">' .  $post["week"] .  '</a> ';
        $html .= 'By ' .  $post["name"] . " " . $post["surname"] .  '<br> <hr>';

    }
    $html .= "</div>";
}

?>

<ul>
<li><a href="index.php">Home</a></li>
<li><a href="weeks.php">Weeks</a></li>
<li><a href="authors.php">Authors</a></li>
<li><a class="active" href="blogposts.php">Blogposts</a></li>
<li><a href="users.php">Users</a></li>
</ul>

<?php
echo $html;
?>
