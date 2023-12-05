<?php


require_once "usernavbar.php";
require_once "helper.php";
require_once 'credentials.php';


// should we show the users posts form?:
$show_posts_form = true;
 
// variables to make the form more functional
// values entered by user (if problems) occur
$username_form="";
$password_form="";
// error messages to display about each field
$username_errors="";
$password_errors="";
// to be used for combination of all server-side errors
$errors="";
    
// message to output to user:
$message = "";

if (!isset($_SESSION['loggedIn']))//Not logged in
{
    // user isn't logged in, display a message saying they must be:
    echo "You must be logged in to view this page.<br>";
}else //Logged in 
{ 
    // connect directly to our database (notice 4th argument):
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);


    // if the connection fails, we need to know, so allow this exit:
    if (!$connection)
    {
        die("Connection failed: " . $mysqli_connect_error);
    }

    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    $userid = $_SESSION['uid'];
        
    // Attempt to connect. Return an error if not.
    if (!$connection)
    {
        die("Connection failed: " . $mysqli_connect_error);
    }

    if ($show_posts_form)
    {
        if(isset($_POST['asc']))
        {
            // find the users posts
            $query = "SELECT * FROM posts WHERE uid = $userid ORDER BY postid ASC";
            //echo $query;
        }elseif(isset($_POST['desc']))
        {
            // find the users posts
            $query = "SELECT * FROM posts WHERE uid = $userid ORDER BY postid DESC";
            //echo $query;
        } else
        {
            // find the users posts
            $query = "SELECT * FROM posts WHERE uid = $userid";
        }

        // this query can return data ($result is an identifier):
        $result = mysqli_query($connection, $query);
        // how many rows came back?:
        $n = mysqli_num_rows($result);
        
        // $row = mysqli_fetch_assoc($result);

        // if we got some results then show them in a table:
        if ($n > 0)
        {
            //  CSS 
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

            echo '<form action="view_posts.php" method="POST">
            <button type="submit" class="signButton btn btn-primary" name="asc">Ascending</button></form>';
            echo '<form action="view_posts.php" method="POST">
            <button type="submit" class="signButton btn btn-primary" name="desc">Descending</button></form>';
            echo "<table class='container' cellpadding='2' cellspacing='2'>";
            echo "<tr><th>Title</th><th>Created</th><th>Content</th><th>Image</th><th>Edit Post</th><th>Delete Post</th></tr>";
            // loop over all rows, adding them into the table:
            for ($i=0; $i<$n; $i++)
            {
                // fetch one row as an associative array (elements named after columns):
                $row = mysqli_fetch_assoc($result);
                // add it as a row in our table:
                echo '<tr>';
                echo '<td>'.$row['title'].'</td><td>'.$row['created'].'</td><td>'.$row['content'].'</td><td><img alt="'.$row['image'].'" src="'.$row['image'].'"></td><td><form action="update_post.php" method="POST"><button type="submit" class="signButton" name="pid" value="'.$row['postid'].'">Edit</button></form></td><td><form action="delete_posts.php" method="POST"><button type="submit" class="signButton" name="pid" value="'.$row['postid'].'">Delete</button></form></td>';
                echo "</tr>";
            }
            echo "</table>";

        }
        else
        {
            // no posts found...:
            echo "no posts found<br>";
        }

        // we're finished with the database, close the connection:
        mysqli_close($connection);
    }
}


require_once "footer.php";

?>