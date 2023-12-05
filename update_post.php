<?php

require_once "usernavbar.php";
require_once "helper.php"; 
require_once 'credentials.php';

// should we show the set post form?
$show_post_form = true;
$is_update = true;
$postid = "";
$title="";
$created = "";
$content = "";

$title_errors = "";
$created_errors = "";
$content_errors = ""; 

// message to output to user:
$message = "";

if (!isset($_SESSION['loggedIn']))//Not logged in
{
    // user isn't logged in, display a message saying they must be:
    echo "You must be logged in to view this page.<br>";
}
else //Logged in 
{ 
    // connect directly to our database (notice 4th argument):
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    // if the connection fails, we need to know, so allow this exit:
    if (!$connection)
    { 
        die("Connection failed: " . $mysqli_connect_error);
    }
    

    if(isset($_POST['pid']))    
    {
        if ($is_update) {
            $pid=$_POST['pid'];
            // SELECT the data based on pid
            // find their posts
            $query = "SELECT * FROM posts WHERE postid = $pid";
            //$query = "SELECT * FROM posts";
            // this query can return data ($result is an identifier):
            $result = mysqli_query($connection, $query);
            //echo $query;
            
            $n = mysqli_num_rows($result);
            
            $row = mysqli_fetch_assoc($result);
        
        
            // if we got some results then show them in a table:
            if ($n > 0)
            {
                // Create your form as above but with the values relating to what you got from the database
                // show the form that allows users to create post
                echo <<<_END
                <form action="update_post.php" method="POST">
                <div class="container">
                <h1 class="title_form">Update Post</h1>
        
                <p class="title_form">Please create your post below</p><br>
        
                <br><hr>
                <div class="container1">
                <label for="title"><b>Title</b></label>
                <input type="text"  placeholder="Enter Title"  value="{$row['title']}" name="title" required>
                <br>
        
                <label for="created"><b>Created</b></label>
                <input type="text" placeholder="Enter Created Date" value="{$row['created']}" name="created" required>
                <br>
               
                <label for="content"><b>Content</b></label>
                <input type="text" placeholder="Enter Content" value="{$row['content']}" name="content" required>
                <br>
        
                <label for="image"><b>Image</b></label>
                <input type="text" placeholder="Enter Image Source" value="{$row['image']}" name="image">
                <input type="hidden" value="{$row['postid']}" name="update_postid" required>         
                <br>
                </div>
        
                <div class="buttons btn-group" role="group">
                <button type="submit" class="signButton btn btn-primary">Update Post</button>
                <button type="button" class="cancelButton"><a href='delete_post.php'>Delete Post</a></button>         
                   
                </div>
                </form>	
                _END;
            } 
        }
    }

    if (isset($_POST['title'])) 
    {
    
       $pid = $_POST['update_postid'];
       $title = $_POST['title'];
       $created = $_POST['created'];
       $content = $_POST['content'];
       $image = $_POST['image'];
        // Attempt to connect. Return an error if not.
        if (!$connection)
        {
            die("Connection failed: " . $mysqli_connect_error);
        }

        // sanitise the user input 
        $title = sanitise($title, $connection);
        //$content = $_POST['content'];
        $created = date("Y-m-d H:i:s");
        $image = sanitise($image, $connection);
        //validate the user input 
        $title_errors = validateString($title, 1, 100);
        $created_errors = validateString($created, 1, 100);
        // concatenate the errors from both validation calls
        $errors = $title_errors . $created_errors;

        if ($errors == "") 
        {
            // try to insert the new details:
            $query = "UPDATE posts SET title = '$title', created = '$created', content = '$content', image = '$image' WHERE postid = $pid";
            $result = mysqli_query($connection, $query);
            echo $query;
            
            if ($result)
            {
                // navigate back to the profile page:
                header('Location: view_posts.php');
            }else
            {
                // show the form:
                $show_profile_form = true;
                // show an unsuccessful update message:
                $message = "Update failed, please try again<br>";
            }
                
            // we're finished with the database, close the connection:
            mysqli_close($connection);
        }
    }else 
    {
        echo "<b>Update Failed";
        echo "<br><br></b>";
        $show_post_form = true;
        echo $message;
    }
}

?>