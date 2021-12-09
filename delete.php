<?php

    ini_set('display_errors', 1); 
	error_reporting(E_ALL);

     $conn = new mysqli("sql308.epizy.com", "epiz_30427956", "fCGk6119Cg7I5", "epiz_30427956_CRSTDemo");


    // delete an event
    if(isset($_POST["id"])){
	    $id = $_POST['id'];
        // $sql = "delete from events where event_id = $id";
        // $conn->query($sql);
         $stmt = $conn->prepare("delete events, event_users from events
                                inner join event_users
                                where events.event_id = $id and event_users.event_id = $id");  
         $stmt->execute();
         $result = $stmt->get_result();
         if(!$result){
         	echo ("error");
         }
    }



?>