<?php
session_start();

echo <<<_END
<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Noticeboard</title>
    <link rel="stylesheet" href="custom.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> 
</head>

<body id="background" class="background">
    <!-- add an id attribute with the value #top-header to the tags that surround the header text  -->
    <header>
        <h1 id="top-header">Noticeboard</h1>
    </header>
    <hr> 
    <table>
        <tr>
            <td class="cell-data p-3 mb-2 bg-light text-dark" onclick="changeColour()">Default Theme</td>
            <td class="cell-data p-3 mb-2 bg-light text-dark" onclick="changeColour('dark')">Dark Theme</td>
            <td class="cell-data p-3 mb-2 bg-light text-dark" onclick="changeColour('light')">Light Theme</td>
        </tr>
    </table>
    <hr>

      <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    
      <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
        <li class="nav-item">
                <a class="nav-link active text-primary" aria-current="page" href="admin_signed_in.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-primary" href="admin_create_post.php">Create Post</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-primary" href="admin_view_all_posts.php">View All Posts</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-primary" href="admin_view_posts.php">View Your Posts</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-primary" href="admin_profile.php">Edit Profile</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-primary" href="admin_manage_user.php">Manage Users</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-primary" href="admin_manage_posts.php">Manage Posts</a>
              </li>
      <li class="nav-item">
        <a class="nav-link text-primary" href="sign_out.php">Sign Out</a>
      </li>
        </ul>
      </div>
    </nav>
_END;
?>