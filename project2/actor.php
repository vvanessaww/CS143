<!DOCTYPE html>
<html>
<head><title>Actor Information</title></head>
<body>

<?php
 include('./sqlconnect.php');
?>

<?php

echo "<p>Actor Info:</p>" ;

if($_GET["id"]){

    $statement = $db->prepare("SELECT first, last, sex, dob, dod FROM Actor WHERE id= ? ");
    $statement->bind_param('s', $_GET["id"]);
    $statement->execute();
    $statement->bind_result($first, $last, $sex, $dob, $dod);
    while ($statement->fetch()) {
      echo "Name: $first $last <br>";
      echo "Sex: $sex <br>";
      echo "Date of Birth: $dob <br>";
      echo "Date of Death: ";
         if (empty ($dod)){
         echo "N/A";
         }
         else {
         echo $dod;
    }
    
    }
    echo "<br><br>";
    echo "Appears in movies:<br>";

    
    $statement = $db->prepare("SELECT title, mid FROM MovieActor, Movie WHERE id = mid and aid = ?");
    $statement->bind_param('s', $_GET["id"]);
    $statement->execute();
    $statement->bind_result($title, $mid);
    while ($statement->fetch()) {
      echo "<a href='movie.php?id=$mid'> $title <br></a>";
    }

    echo "<br><br>";
    echo "Appears in movies:<br>";


}



 ?>


</body>
</html>