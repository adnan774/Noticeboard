<?php
  

require_once "usernavbar.php";
require_once 'credentials.php';



    // connect directly to our database (notice 4th argument):
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    // if the connection fails, we need to know, so allow this exit:
    if (!$connection)
    {
        die("Connection failed: " . $mysqli_connect_error);
    }

    if(isset($_POST['desc']))
    {
        // find all posts
        $query = "SELECT * FROM posts ORDER BY postid DESC";
         
    } elseif(isset($_POST['asc']))
    {
        // find all posts
        $query = "SELECT * FROM posts ORDER BY postid ASC";
    } else 
    {
        // find all posts
        $query = "SELECT * FROM posts";
    }


    $result = mysqli_query($connection, $query);

    $n = mysqli_num_rows($result);

    if ($n > 0)
    {
        echo <<<_END
        <style>
            table, th, td {border: 1px solid black; align: center;}
                
                th, td {
                text-align: left;
                padding: 8px;
            }
            
            tr:nth-child(even){background-color: #f2f2f2}
            
            th {
                background-color: #b3e6ff;
                color: black;
            }
            
            
        </style>
_END;

        echo '<form action="user_all_posts.php" method="POST">
        <button type="submit" class="signButton btn btn-primary" name="asc">Ascending</button></form>';
        echo '<form action="user_all_posts.php" method="POST">
        <button type="submit" class="signButton btn btn-primary" name="desc">Descending</button></form>';
        echo "<table class='container' cellpadding='2' cellspacing='2'>";
        echo "<tr><th>Title</th><th>Created</th><th>Content</th><th>Image</th></tr>";
        // loop over all rows, adding them into the table:
        for ($i=0; $i<$n; $i++)
        {
            // fetch one row as an associative array (elements named after columns):
            $row = mysqli_fetch_assoc($result);
            // add it as a row in our table:
            echo '<tr>';
            echo '<td>'.$row['title'].'</td><td>'.$row['created'].'</td><td>'.$row['content'].'</td><td><img alt="'.$row['image'].'" src="'.$row['image'].'"></td>';
            echo "</tr>";
        }
        echo "</table>";

    }
    else
    {
        // no posts found...
        echo "no posts found<br>";
    }

    // we're finished with the database, close the connection:
    mysqli_close($connection);

require_once "footer.php";

?>