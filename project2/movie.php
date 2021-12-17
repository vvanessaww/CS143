<!DOCTYPE html>
<html>
<head><title>Movie Information</title></head>
<body>

<?php
 include('./sqlconnect.php');
?>

<?php

echo "<p>Movie Info:</p>" ;

    if($_GET["id"]){
      $statement = $db->prepare("SELECT id, title, year, rating, company FROM Movie WHERE id= ? ");
      $statement->bind_param('s', $_GET["id"]);
      $statement->execute();
      $statement->bind_result($returned_id, $returned_title, $year, $rating, $company);
      while ($statement->fetch()) {
        echo "Movie Title: $returned_title<br>";
        echo "Year: $year <br>";
        echo "Movie Rating: $rating <br>";
        echo "Company: $company <br><br>";
      }}

echo "<p>Actors Appearing in Movie:</p>" ;
    $statement = $db->prepare("SELECT first, last, aid FROM MovieActor, Actor WHERE mid= ? AND aid = Actor.id ");
    $statement->bind_param('s', $_GET["id"]);
    $statement->execute();
    $statement->bind_result($first, $last, $aid );
    while ($statement->fetch()) {
        echo "<a href='actor.php?id=$aid'>$first $last <br></a>";}


    $rev_link = "./review.php?id=$mid";
    echo "<br>";
    echo "<a href='$rev_link'>Add Comment</a><br>";
 ?>



 </body>
 </html>