<?php

    ini_set('display_errors', 1); 
    error_reporting(E_ALL);
    session_start();

    // Set Session user id and DB connection
    $user_id = $_SESSION['id'];

    $conn = new mysqli("sql308.epizy.com", "epiz_30427956", "fCGk6119Cg7I5", "epiz_30427956_CRSTDemo");

    $events = array();

    // select event created by current user
    // $sql = "SELECT e.* FROM event_users eu
    //         RIGHT JOIN `events` e
    //         ON e.`event_id` = eu.`event_id`
    //         WHERE eu.`user_id`=$user_id OR e.`created_by`=$user_id GROUP BY e.`event_id`";


    $stmt = $conn->prepare("SELECT e.* FROM event_users eu
            RIGHT JOIN `events` e
            ON e.`event_id` = eu.`event_id`
            WHERE eu.`user_id`=$user_id OR e.`created_by`=$user_id GROUP BY e.`event_id`");
    $stmt->execute();

    $result = $stmt->get_result();
        while ($row = $result ->fetch_object()){
            $ev = array(
                "id" => $row->event_id,
                'url' => $row->event_url,
                'title' => $row->event_title,
                'start' => $row->event_start,
                'end' => $row->event_end,
                'allDay' => (boolean)$row->event_day,
                'extendedProps' => array( 
                    'location' => $row->event_location,
                    'calendar'=> $row->event_label,
                    'description' => $row->event_description,
                    'guests' => json_decode($row->guests,true)
                )
                
                
            ); 
             
            $events[] = $ev; 
            // header('Content-Type: application/json');
           

        }

    
    echo json_encode($events);



        
        
?>




