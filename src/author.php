<?php 

include("header.php");
ini_set("display_errors", 1);
include("db/authors.php");
$Authors = new Authors();
if (isset($_GET["aid"])) {
    $authorID = $_GET["aid"];
    $author = $Authors->getAuthorById($authorID);
    if (count($author) == 1) {
        $name = $author[0]["name"];
        $about = $author[0]["about"];
        $email = $author[0]["email"];
        $surname = $author[0]["surname"];
        $img = $author[0]["image"];
        $writtenPosts = $Authors->getWeeksByAuthorId($authorID);
        $posts = "";
        //
        foreach ($writtenPosts as $post => $value) {
            $posts .= "<a href='weeks.php?week=" . $value["weeksNr"] . "'>" . $value["weeksNr"] . "</a>, ";
        }
    } else {
        header('Location: authors.php');
    }

    
} else {
    header('Location: authors.php');
}

?>

<ul>
<li><a href="index.php">Home</a></li>
<li><a href="weeks.php">Weeks</a></li>
<li><a class="active" href="authors.php">Authors</a></li>
  <li><a href="blogposts.php">Blogposts</a></li>
  <li><a href="users.php">Users</a></li>
</ul>


<article>
<?php
echo "<a href='authors.php'>&#8592; All authors</a>";
echo "<h1>$name $surname</h1>";
echo "<p>$about</p>";
echo "<img class='profilepic' src='$img' alt='Image of $name $surname'>";
echo "<p><a href='mailto:$email'>$email</a></p>";
echo "Participated on creating content of weeks: $posts"

?>
</article>

</body>
</html>