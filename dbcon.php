<?php

    $conn = new mysqli("sql308.epizy.com", "epiz_30427956", "fCGk6119Cg7I5", "epiz_30427956_CRSTDemo");

    if($conn->connect_error) {
        die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
    }


?>

