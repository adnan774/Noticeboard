<?php
$date = date("h:i:sa");
echo <<<FOOTER
<footer>
            <hr>
            <!-- assign an id attribute to the tags that surround your footer information  -->
            <h5 id="bottom-footer">Adnan Asif- 2022 - Online Notice Board</h5>
            <h6>Hosted on the {$_SERVER['SERVER_NAME']} and requested by {$_SERVER['REMOTE_ADDR']} at $date</h6>
            <script src="custom.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
            <script src="https://code.jquery.com/jquery-3.5.0.js"></script>

</footer>   
    </body>

</html>
FOOTER; 
?>