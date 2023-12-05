<?php

require_once "header.php";
require_once 'credentials.php';
require_once 'helper.php';

// should we show the signup form?:
$show_signup_form = false;

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

// message to output to user:
$message = "";

if (isset($_SESSION['loggedIn']))
{
    // user is already logged in, just display a message:
    echo "You are already logged in, please log out first<br>";

}
elseif (isset($_POST['username']))
{
    // user just tried to sign up, try and insert these new details:
    // take copies of the credentials the user submitted:
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

    // connect directly to our database (notice 4th argument):
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    // if the connection fails, we need to know, so allow this exit:
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
    $errors = $username_errors . $password_errors;


    if ($errors == "") {

        // try to insert the new details:
        $query = "INSERT INTO users(username, password, firstname, lastname, email, age, city, county, country, phone) VALUES('$username','$password', '$firstname', '$lastname', '$email', '$age', '$city', '$county', '$country', '$phone')";
        $result = mysqli_query($connection, $query);

        // no data returned, we just test for true(success)/false(failure):
        if ($result)
        {
            // show a successful signup message:
            $message = "Signup was successful, $username please sign in<br>";
        }
        else
        {
            // show the form:
            $show_signup_form = true;
            // show an unsuccessful signup message:
            $message = "Sign up failed, please try again<br>";
            $message = "Sign up failed, with error: ". mysqli_error($connection) ."<br>";
        }

        // we're finished with the database, close the connection:
        mysqli_close($connection);

    }

    else {
        echo "<b>Sign-up Failed";
        echo "<br><br></b>";
        $show_signup_form = true;
    }

}
else
{
    // just a normal visit to the page, show the signup form:
    $show_signup_form = true;

    echo $message;

}

if ($show_signup_form)
{
// show the form that allows users to sign up
    echo <<<_END
    <form class="form" id="signup" action="signup.php" method="post">
    <div class="container">
        
        <h1 class="title_form">Sign Up</h1>
        
        <p>Please fill in the form below</p>
        
        <br><hr>

        <label for="username"><b>Username</b></label>
        <input type="text" minlength="1" maxlength="32" placeholder="Enter Username" name="username" required>

        <label for="password"><b>Password</b></label>
        <input type="password" minlength="1" maxlength="64" placeholder="Enter Password" name="password" required>

        <label for="firstname"><b>Firstname</b></label>
        <input type="text" minlength="1" maxlength="64" placeholder="Enter Firstname" name="firstname" required>

        <label for="lastname"><b>Lastname</b></label>
        <input type="text" minlength="1" maxlength="64" placeholder="Enter Lastname" name="lastname" required>

        <label for="email"><b>Email</b></label>
        <input type="email" minlength="1" maxlength="128" placeholder="Enter Email" name="email" required>

        <label for="age"><b>Age</b></label>
        <input type="text" minlength="1" maxlength="3" placeholder="Enter Age" name="age" required>

        <label for="city"><b>City</b></label>
        <input type="text" minlength="1" maxlength="32" placeholder="Enter City" name="city" required>

        <label for="county"><b>County</b></label>
        <input type="text" minlength="1" maxlength="40" placeholder="Enter County" name="county" required>

        <label for="country"><b>Country</b></label>
        <input type="text" minlength="1" maxlength="60" placeholder="Enter Country" name="country" required>

        <label for="phone"><b>Phonenumber</b></label>
        <input type="text" minlength="1" maxlength="24" placeholder="Enter Phonenumber" name="phone" required>

        <div class="buttons btn-group" role="group">
            <button type="submit" class="signButton btn btn-primary">Sign Up</button>
        </div>
    </div>
    </form>
_END;
}

echo $message;

require_once "footer.php";

?>