<?php

// execute the credentials script
require_once 'credentials.php';

require_once 'helper.php';

// should we show the signin form:
$show_signin_form = true;


if ($show_signin_form)
{
    require_once 'usernavbar.php';
}

// finish off the HTML for this page
require_once "footer.php";
?>