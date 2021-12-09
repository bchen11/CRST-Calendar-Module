<?php

    ini_set('display_errors', 1); 
    error_reporting(E_ALL);
    session_start();
    $user_id = $_SESSION['id'];

    // initlize reminders varaibles
    if(!isset($_SESSION['reminders'])){
        $_SESSION['reminders'] = [];
    }
    if(!isset($_SESSION['reminders2'])){
        $_SESSION['reminders2'] = [];
    }
     $conn = new mysqli("sql308.epizy.com", "epiz_30427956", "fCGk6119Cg7I5", "epiz_30427956_CRSTDemo");

    $events = array();

    $sql = "SELECT e.* FROM event_users eu
            RIGHT JOIN `events` e
            ON e.`event_id` = eu.`event_id`
            WHERE eu.`user_id`=$user_id OR e.`created_by`=$user_id GROUP BY e.`event_id`";
    $result = mysqli_query($conn, $sql);


    // fetch the start date/time and compute the remainning minutes 
    $from_time = strtotime($_POST['date']);
    while ($row = $result ->fetch_object()){

        $to_time = strtotime($row->event_start);
        
        // compute the minutes and return msg to notify user
        $minutes = round(abs($to_time - $from_time) / 60,0);

        if($minutes <= 10 && $row->notified !='yes'){
            $_SESSION['reminders'][] = $row->event_id;
            $conn->query("update events set notified = 'yes' where event_id = '$row->event_id'");
            echo json_encode(array('notify'=>'true','msg'=>"\"$row->event_title\" event is ready to attend in 10 minutes."));
            die();
        }
        if($minutes <= 1 && $row->notified2 !='yes'){
            $_SESSION['reminders2'][] = $row->event_id;
            $conn->query("update events set notified2 = 'yes' where event_id = '$row->event_id'");
            echo json_encode(array('notify'=>'true','msg'=>"\"$row->event_title\" event is ready to attend in 1 minute."));
            die();
        }

    }

    echo json_encode(array('notify'=>'false',));
    die();
    
?>