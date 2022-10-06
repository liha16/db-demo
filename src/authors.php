<?php 
include("header.php");
ini_set("display_errors", 1);
include("db/authors.php");

$Authors = new Authors();
$authors = $Authors->getAuthorsWithView();
$html = "";

foreach ($authors as $author => $value) {
  $html .= '<a href="author.php?aid=' . $value["id"] . '">' . $value["name"] . " " . $value["surname"] . '</a></br>';
}

?>

<ul>
  <li><a href="index.php">Home</a></li>
  <li><a href="weeks.php">Weeks</a></li>
  <li><a class="active" href="authors.php">Authors</a></li>
  <li><a href="blogposts.php">Blogposts</a></li>
  <li><a href="users.php">Users</a></li>
</ul>
<div class="content">
<h1>Authors</h1>
<hr>
<p>Authors who have participated on writing the content of the weeks. Authors that are in de database but have not participated on writing content are not listed here.</p>

<?php
echo $html;
?>
</div>
</body>
</html>
