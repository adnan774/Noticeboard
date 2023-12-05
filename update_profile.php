<?php

if(isset($_POST['username']))    
    {
        require_once 'credentials.php';
        $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
        $userid = $_SESSION['uid']; 
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

        $query = "UPDATE users SET username = '$username', password = '$password', firstname = '$firstname', lastname = '$lastname', email = '$email', age = '$age', city = '$city', county = '$county', country = '$country', phone = '$phone' WHERE uid = $userid";

        //echo $query;
        
        $result = mysqli_query($connection, $query);
        if ($result)
        {
            // navigate back to the profile page:
            header('Location: profile.php');
        }
        else
        {    
            // show an unsuccessful signup message:
            $message = "Update failed, please try again<br>";
        }
        
      

    }//if the form hasn't been sent, what should I do?
}
?>