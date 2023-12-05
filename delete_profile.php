<?php
if(isset($_POST['uid']))
{
    require_once 'credentials.php';
    $userid = $_POST['uid'];

    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    
    // Attempt to connect. Return an error if not.
    if (!$connection)
    {
        die("Connection failed: " . $mysqli_connect_error);
    }
  
    $query = "DELETE FROM users WHERE uid = '$userid' ";
    echo $query;
    $result = mysqli_query($connection,$query);

    
    // no data returned, we just test for true(success)/false(failure):
    if ($result)
    {
        // navigate back to the index page:
        header('Location: admin_manage_user.php');
    }
    else
    {    
        // show an unsuccessful delete message:
        $message = "Delete unsuccessful, please try again<br>";
    }
    
    echo $message;
    mysqli_close($connection);
}