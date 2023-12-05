<?php

require_once "helper.php";
require_once "adminnavbar.php";
require_once 'credentials.php';


$show_profile_form = true;
$is_update = true;
$userid = "";
$username_form="";
$password_form="";
$username_errors="";
$password_errors="";
$firstname_errors="";
$lastname_errors="";
$email_errors="";
$age_errors="";
$errors="";
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
    
    // If user clicks update all details will be posted and updated here
    // $_POST = method or channel of communication
    // Inside the square bracket = the name or tag of the information we are sending
    if(isset($_POST['uid']))    
    {
        if ($is_update)
        {
            $userid = $_POST['uid'];
            // find their user details
             $query = "SELECT uid, username, password, firstname, lastname, email, age, city, county, country, phone FROM users WHERE uid = $userid";

            // this query can return data ($result is an identifier):
            $result = mysqli_query($connection, $query);
            // how many rows came back?:    
            $n = mysqli_num_rows($result);

            $row = mysqli_fetch_assoc($result);
    

            // if we got some results then show them in a form:
            if ($n > 0)
            {
        
                echo <<<PROFILE
                <form class="form" id="profile" action="admin_manage_profiles.php" method="POST">
                <div class="container">
                    <div class="row">
                        <div class="col">
                
                            <h1 class="title_form">Edit Profile</h1>
                
                            <p class="title_form">Please fill in the form below</p>
                
                            <br><hr>
                            <div class="container1">
                                <label for="username"><b>Username</b></label>
                                <input type="text" minlength="1" maxlength="32" placeholder="Enter Username" value="{$row['username']}" name="username" required>

                                <label for="password"><b>Password</b></label>
                                <input type="password" minlength="1" maxlength="64" placeholder="Enter Password" value="{$row['password']}" name="password" required>

                                <label for="firstname"><b>Firstname</b></label>
                                <input type="text" minlength="1" maxlength="64" placeholder="Enter Firstname" value="{$row['firstname']}" name="firstname" required>

                                <label for="lastname"><b>Lastname</b></label>
                                <input type="text" minlength="1" maxlength="64" placeholder="Enter Lastname" value="{$row['lastname']}" name="lastname" required>

                                <label for="email"><b>Email</b></label>
                                <input type="email" minlength="1" maxlength="128" placeholder="Enter Email" value="{$row['email']}" name="email" required>
                            
                                <label for="age"><b>Age</b></label>
                                <input type="text" minlength="1" maxlength="3" placeholder="Enter Age" value="{$row['age']}" name="age" required>

                                <label for="city"><b>City</b></label>
                                <input type="text" minlength="1" maxlength="32" placeholder="Enter city" value="{$row['city']}" name="city" required>

                                <label for="county"><b>County</b></label>
                                <input type="text" minlength="1" maxlength="40" placeholder="Enter County" value="{$row['county']}" name="county" required>

                                <label for="country"><b>Country</b></label>
                                <input type="text" minlength="1" maxlength="60" placeholder="Enter Country" value="{$row['country']}" name="country" required>

                                <label for="phone"><b>Phonenumber</b></label>
                                <input type="text" minlength="1" maxlength="24" placeholder="Enter Phonenumber" value="{$row['phone']}" name="phone" required>
                                <input type="hidden" value="{$row['uid']}" name="update_userid" required>
                            </div>
                
                            <div class="buttons btn-group" role="group" ariel-label="Basic example">
                                <button type="submit" class="signButton btn btn-primary">Update</button>      
                            </div>
                        </div>
                    </div>
                </div> 
                </form>
                PROFILE;
            }
        }
    }

    if (isset($_POST['username'])) 
    {
        //require_once 'credentials.php';
        //$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
        //$userid = $_SESSION['update_userid']; 
        $userid = $_POST['update_userid'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $age = $_POST['age'];
        $city = $_POST['city'];
        $county = $_POST['county'];
        $country = $_POST['country'];
        $phone = $_POST['phone'];

        
        // Attempt to connect. Return an error if not.
        if (!$connection)
        {
            die("Connection failed: " . $mysqli_connect_error);
        }

        $username = sanitise($username, $connection);
        $password = sanitise($password, $connection);
        $firstname = sanitise($firstname, $connection);
        $lastname = sanitise($lastname, $connection);
        $email = sanitise($email, $connection);
        $age = sanitise($age, $connection);
        $city = sanitise($city, $connection);
        $county = sanitise($county, $connection);
        $country = sanitise($country, $connection);
        // validate the user input 
        $username_errors = validateString($username, 1, 32);
        $password_errors = validateString($password, 1, 64);
        $firstname_errors = validateString($firstname, 1, 64);
        $lastname_errors = validateString($lastname, 1, 64);
        $email_errors = validateEmail($email, 1, 128);
        $age_errors = validateString($age, 1, 3);
        // concatenate the errors from both validation calls
        $errors = $username_errors . $password_errors . $firstname_errors . $lastname_errors . $email_errors . $age_errors;

        if ($errors == "") 
        {
            // try to insert the new details:
            $query = "UPDATE users SET username = '$username', password = '$password', firstname = '$firstname', lastname = '$lastname', email = '$email', age = '$age', city = '$city', county = '$county', country = '$country', phone = '$phone' WHERE uid = $userid";
            $result = mysqli_query($connection, $query);
            echo $query;
        
            // no data returned, we just test for true(success)/false(failure):

            if ($result)
            {
                // navigate back to the profile page:
                header('Location: admin_manage_user.php');
            }
            else
            {
                // show the form:
                $show_profile_form = true;
                // show an unsuccessful update message:
                $message = "Update failed, please try again<br>";
            }

            // we're finished with the database, close the connection:
            mysqli_close($connection);
        }     
    }
    else 
    {
        echo "<br><br></b>";
        $show_profile_form = true;
        echo $message;
    }
}

?>