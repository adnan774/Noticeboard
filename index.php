<?php

require_once "header.php";
require_once 'credentials.php';
require_once 'helper.php';

// should we show the signin form?
$show_signin_form = false;
$message = "";

$username_form="";
$password_form="";
$username_errors="";
$password_errors="";
$age_errors="";
$errors="";
$message = "";


if (isset($_SESSION['loggedIn']))
{
    // user is already logged in, just display a message:
    echo "You are already logged in, please log out first.<br>";
}

elseif (isset($_POST['username']))
{
    // user has just tried to log in, check form data against database:

    // take copies of the credentials the user submitted:
    $username = $_POST['username'];
    $password = $_POST['password'];

    // connect directly to our database (notice 4th argument):
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    // if the connection fails, we need to know, so allow this exit:
    if (!$connection)
    {
        die("Connection failed: " . $mysqli_connect_error);
    }



    // sanitise the user input 
    $username = sanitise($username, $connection);
    $password = sanitise($password, $connection);
    // validate the user input 
    $username_errors = validateString($username, 1, 32);
    $password_errors = validateString($password, 1, 64);
    // concatenate the errors from both validation calls
    $errors=$username_errors . $password_errors;
    
    if ($errors == "") 
    {
        // check for a row in our members table with a matching username and password:
        $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";

        // this query can return data ($result is an identifier):
        $result = mysqli_query($connection, $query);

        // how many rows came back? (can only be 1 or 0 because usernames are the primary key in our table):
        $n = mysqli_num_rows($result);

        // if there was a match then set the session variables and display a success message:
        if ($n > 0)
        {
            $row = mysqli_fetch_assoc($result);
        
            // set a session variable to record that this user has successfully logged in:
            $_SESSION['loggedIn'] = true;

            // and copy their username into the session data for use by our other scripts:
            $_SESSION['uid'] = $row['uid'];
            $_SESSION['username'] = $username;

            // If the username is admin, redirect me to the admin profile page
            if($username == 'admin') 
            {
                $_SESSION['admin'] = true;
                header('Location: admin_view_posts.php');
            } else{
                // show a successful sign in message if I am not the admin:
                header('Location: view_posts.php');
            }
        
        }else
        {
            // no matching credentials found so redisplay the sign in` form with a failure message:
            $show_signin_form = true;
            // show an unsuccessful sign in message:
            $message = "Sign in failed, please try again<br>";
        }

        // we're finished with the database, close the connection:
        mysqli_close($connection);
    
    }else
    {
        echo "<b>Sign in Failed";
        echo "<br><br></b>";
        // user has arrived at the page for the first time, just ask them to log in:
        // show signin form:
        $show_signin_form = true;
    }
}
else
{
    // just a normal visit to the page, show the signup form:
    $show_signin_form = true;

    echo $message;

}

if ($show_signin_form)
{
// show the form that allows users to log in

//wont show image next to form
    echo <<<_END
    <div class="container">
        <div class="row">
        <div class="col">
            <img class="mw-100 rounded float-left noticeImage" src="img/notice.png" alt="noticeboard height="100%" width="100%">
        </div>


        <div class="col">
            <form class="form" id="signin" action="index.php" method="post">
            <h1 class="title_form">Sign In</h1>
        
         
            <p class="title_form">Please fill in the form below</p>
        
            <br><hr>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" minlength="1" maxlength="16" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Username" required>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required>
            </div>
            <button type="submit" class="signButton btn btn-primary">Sign In</button>
            </form>
        </div>
        </div>
    </div>  

_END;
}

echo $message;

require_once "footer.php";
?>
