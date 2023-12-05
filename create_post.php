<?php

require_once "header.php";
require_once "helper.php";
require_once 'credentials.php';

// should we show the set post form? 
$show_post_form = true;
$is_update = false;

$postid = "";
$title="";
$created = "";
$content = "";

$title_errors = "";
$created_errors = ""; 
$content_errors = "";

if(isset($_POST['postid']))
{
    $is_update = true;
    $postid = $_POST['pid'];
}

$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
// if the connection fails, we need to know, so allow this exit:
if (!$connection)
{
    die("Connection failed: " . $mysqli_connect_error);
}

if(!$is_update)
{
    // message to output to user:
    $message = "";
    
    if(isset($_POST['title'])) 
    {
        require_once 'credentials.php';
        $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
        if(isset($_SESSION['uid']))
        {
            $username = $_SESSION['username'];
            $userid = $_SESSION['uid'];
        }else
        {
            $username = "";
            $userid = "";
        }
       
        $created = date("Y-m-d H:i:s");
        $title = $_POST['title'];
        //$created = $_POST['created']; 
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
        $content_errors = validateString($created, 1, 100);
        // concatenate the errors from both validation calls
        $errors = $title_errors . $created_errors . $content_errors;

        if ($errors != "") 
        {
           echo "error ".$errors;   
        }else 
        {
            //create new post
            $query = "INSERT INTO posts (title, created, content, image) VALUES ('$title', '$created', '$content', '$image')";
    
            // this query can return data ($result is an identifier):
            //echo $query;
            $result = mysqli_query($connection, $query);
                
            // if there was a match then set the session variables and display a success message:
            if ($result)
            {
                // navigate back to the all_posts page:
                header('Location: all_posts.php');
            } else
            {
                // no matching credentials found so redisplay the set post` form with a failure message:
                $show_post_form = true;
                        
                // show an unsuccessful create post message:
                $message = "create post failed, please try again<br>";
            }
                    
            // we're finished with the database, close the connection:
            mysqli_close($connection); 
            echo $message;
        
        }
        
    }
    if ($show_post_form)
        {
            // show the form that allows users to create post
            echo <<<_END
            
            <div class="container">
                <div class="row">
                    <div class="col">
                        <h1 class="title_form">Create Post</h1> 

                        <p class="title_form">Please create your post below</p><br>
                        <form action="create_post.php" method="POST">
                        <br><hr>
                        <center><div class="container1"></center>
                            <label for="title"><b>Title</b></label>
                            <input type="text" minlength="1" maxlength="16"  placeholder="Enter Title" name="title" required>
                            <br>

                            <label for="content"><b>Content</b></label>
                            <input type="text" minlength="1" maxlength="100" name="content" placeholder="Enter Content" required>
                            <br>

                            <label for="image"><b>Image</b></label>
                            <input type="text" placeholder="Enter Image Source" name="image">
                            <br>
                        <div class="buttons btn-group" role="group">
                            <button type="submit" class="signButton btn btn-primary">Create Post</button>
                        </div>
                        </form>
                        </div>

                    </div>
                </div>         	
            </div>
            
            
            _END;
        }

}
require_once "footer.php";

?>

