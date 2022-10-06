<?php 

include("header.php");
ini_set("display_errors", 1);
include("db/week.php");
include("modules/dueCalculator.php");

$weeks = 42;
$weeklist = "<div class='weeklist'>";

for ($i=1; $i <= $weeks; $i++) { 
    
    if (isset($_GET["week"]) && $_GET["week"] == $i) {
        $weeklist .= "<a class='activeweek' href='?week=$i'>$i</a> ";
    } else {
        $weeklist .= "<a class='weeklink' href='?week=$i'>$i</a> ";
    }
    
}
$weeklist .= "</div>";

if (isset($_GET["week"])) {
    $Week = new Week($_GET["week"]);

    $rows = $Week->getWeek();
    $authors = $Week->getAuthorsbyWeek();
    $posts = $Week->getBlogPostRelatedTo();
    if (count($rows) == 0) { // Week does not exist 
        header('Location: weeks.php');
    }

    $content = "<h1>Week " . $rows[0]["nr"] . "</h1><hr>";
    $content .= "<h3>Trimestre " . $rows[0]["trimestre"] . "</h3>";
    $content .= "<p>" . $rows[0]["content"] . "</p>";
    $img = $rows[0]["foto"];
    $content .= "<img class='weekpic' src='$img' alt='Image of this week'>";
    $content .= "<p>Created: " . $rows[0]["created"] . "</p>";
    $content .= "<p>Updated: " . $rows[0]["updated"] . "</p>";
    $content .= "<p>Written by: ";
    foreach ($authors as $author) {
        $content .= '<br><a href="author.php?aid=' . $author["id"] . '">' . $author["name"] . " " . $author["surname"] . '</a> ';
    }
    $content .= "</p>";
    $content .= "<h2>Related blogposts:</h2>";
    foreach ($posts as $post) {
        $content .= '<a href="blogposts.php?blog=' . $post["blogpostId"] . '">' . $post["title"] . '</a> by ';
        $content .= '<a href="users.php?id=' . $post["userId"] . '">' .  $post["name"] . " " . $post["surname"] .  '</a> ';
    }
   


} else {
    $content = "<h1>Weeks</h1><hr><p>Select a week or calculate due date!</p>";
    $DueCalc = new DueCalculator();
    $content .= $DueCalc->getHTMLForm();
    if (isset($_GET["lastPeriod"])) {
        $DueCalc->setDueDate($_GET["lastPeriod"]);
        $dueDate = $DueCalc->getDueDate();
        $currentWeek = $DueCalc->getCurrentWeek();
        $content .= "<h2>Due Date: $dueDate</h2>";//Calculated due date
        $content .= "<h2>You are in week <a href='?week=$currentWeek'>$currentWeek </a></h2>";
    }

    
}
?>


<ul>
  <li><a href="index.php">Home</a></li>
  <li><a class="active" href="weeks.php">Weeks</a></li>
  <li><a href="authors.php">Authors</a></li>
  <li><a href="blogposts.php">Blogposts</a></li>
  <li><a href="users.php">Users</a></li>
</ul>




<?php
echo $weeklist;
echo "<article>";
echo $content;
echo "</article>";

?>

</body>
</html>


