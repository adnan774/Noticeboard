<?php

if(isset($_POST['pid']))
{ 
    
    require_once 'credentials.php';
    $pid = $_POST['pid'];
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    
    // Attempt to connect. Return an error if not.
    if (!$connection)
    {
        die("Connection failed: " . $mysqli_connect_error);
    }

    $query = "DELETE FROM posts WHERE postid = '$pid' ";
    echo $query;
    $result = mysqli_query($connection,$query);

    
    // no data returned, we just test for true(success)/false(failure):
    if ($result)
    {
        // navigate back to the view post page:
        header('Location: admin_manage_posts.php');
    }
    else
    {    
        // show an unsuccessful delete message:
        $message = "Delete post failed, please try again<br>";
    }
    
    echo $message;
    mysqli_close($connection);
}
?>