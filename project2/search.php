<!DOCTYPE html>
<html>
<head><title>Search</title></head>
<body>

<?php
include('./sqlconnect.php');
echo "<p>Search Page:</p>" ;
?>


<form action="search.php", method="get">
Movie Title: <input type="text" name="movie">
<input type="submit">
</form>
<form action="search.php", method="get">
Actor: <input type="text" name="actor">
<input type="submit">
</form>

<?php
    if (isset($_GET["movie"])) {
        $movie_names = explode(" ", $_GET['movie']);
        $search_phrases = array();
        foreach ($movie_names as $movie_name) {
            array_push($search_phrases, "(title LIKE '%$movie_name%')");
        }
        $search_phrase = implode(" AND ", $search_phrases);
        $query = $db -> query("SELECT * FROM Movie WHERE ($search_phrase)");
      
        $movies = array();
        while ($row = $query->fetch_assoc()) {
            $movies[$row['id']] = array($row['title']);
        }
        
        if (count($movies) < 1)
        {
            print "No movies found  <br>";
        }
        else
        {
            print "Movie Search Results <br>";
            foreach($movies as $id => $title) {
                echo "
                <a href='movie.php?id=$id'>$title[0]</a>
                <a href='movie.php?id=$id'>$title[1]</a>
                <br>";
            }
          
        }
        $query->free();
        $db -> close();
    }


    if (isset($_GET["actor"])) {
        $actor_names = explode(" ", $_GET['actor']);
        $search_phrases = array();
        foreach ($actor_names as $actor_name) {
            array_push($search_phrases, "((first LIKE '%$actor_name%') OR (last LIKE '%$actor_name%'))");
        }
        $search_phrase = implode(' AND ', $search_phrases);
        $query = $db -> query("SELECT * FROM Actor WHERE ($search_phrase)");
      
        $actors = array();

        while ($row = $query->fetch_assoc()) {
            $actors[$row['id']] = array($row['first'], $row['last']);
        }
        
        if (count($actors) < 1)
        {
            print "No actors found <br>";
        }
        else
        {
            print "Actor Search Results <br>";
            foreach($actors as $id => $name) {
                echo "
                <a href='actor.php?id=$id'>$name[0] $name[1]</a>
                <br>";
            }
          
        }
        $query->free();
        $db -> close();
    }

   
    
?>


</body>
</html> 
