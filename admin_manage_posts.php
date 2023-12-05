<?php

require_once "helper.php";
require_once "adminnavbar.php";
require_once 'credentials.php';


// should we show the users posts form?:
$show_all_posts_form = true;
 
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
//$postid = $_SESSION['pid'];
    
// Attempt to connect. Return an error if not.
if (!$connection)
{
    die("Connection failed: " . $mysqli_connect_error);
}

if ($show_all_posts_form)
{
    $query = "SELECT * FROM posts";
    //echo $query;

    // this query can return data ($result is an identifier):
    $result = mysqli_query($connection, $query);
    // how many rows came back?:
    $n = mysqli_num_rows($result);
    
    // $row = mysqli_fetch_assoc($result);

    // if we got some results then show them in a table:
    if ($n > 0)
    {
        // CSS  
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
        echo '<table class="flat-table">';
        echo '<h1> Manage Posts </h1>';
        echo '<tr><th><h3>Post ID</h3></th><th><h3>User ID</h3></th><th><h3>Title</h3></th><th><h3>Created</h3></th><th><h3>Content</h3><th><h3>Image</h3></th><th><h3>Update</h3></th><th><h3>Delete</h3></th></tr>';
        // loop over all rows, adding them into the table:
        for ($i=0; $i<$n; $i++)
        {
            // fetch one row as an associative array (elements named after columns):
            $row = mysqli_fetch_assoc($result);
            // add it as a row in our table:
            echo "<td>{$row['postid']}</td><td>{$row['uid']}</td><td>{$row['title']}</td><td>{$row['created']}</td><td>{$row['content']}</td><td>{$row['image']}</td>";
            // Add the Update button + form and set the value to the ID.
            echo '<td><form method="POST" action="admin_update_post.php"><button class="signButton" type=submit name="pid" value="'.$row['postid'].'">Update</button></form></td>';
            // Add the Delete button + form and set the value to the ID.
            echo '<td><form method="POST" action="admin_delete_posts.php"><button class="signButton" type=submit name="pid" value="'.$row['postid'].'">Delete</button></form></td>';
            echo '</tr>';
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