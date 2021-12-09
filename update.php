<?php

    global $conn;
    ini_set('display_errors', 1); 
    error_reporting(E_ALL);


    session_start();
    $user_id = $_SESSION['id'];

     $conn = new mysqli("sql308.epizy.com", "epiz_30427956", "fCGk6119Cg7I5", "epiz_30427956_CRSTDemo");



    // function that check if guests is already invited to event
    function checkExistingGuest($event_id, $user_id,$conn){
        $sql = "select * from event_users where event_id=$event_id AND user_id=$user_id";

        $result = mysqli_query($conn, $sql);
        while ($row = $result ->fetch_object()){
            if($row->event_id == $event_id && $row->user_id == $user_id){
                return $row->id;
            }
        }
        return false;
    }




    // update event from user input
    if(isset($_POST['key']))
    {
        $id = $_POST['id'];
        $title = $_POST['title'];
		$label = $_POST['label'];
        $start = $_POST['start'];
        $end = $_POST['end'];
        $allDay = $_POST['allDay'];
        $url = $_POST['url'];   
        $location = $_POST['location'];
        $description = $_POST['description'];
        $guests = $_POST['guests'];

        
        // $data = $conn->query("update events set event_title = '$title', event_label = '$label', event_start = '$start', event_end = '$end', event_day = $allDay, event_url = '$url', event_location = '$location', event_description = '$description'
        //                       where event_id = '$id'");

        // $data = $conn->query("update events set event_title = '$title', event_label = '$label', event_start = '$start', event_end = '$end', event_day = $allDay, event_url = '$url', event_location = '$location', event_description = '$description', guests='".json_encode($guests)."' where event_id = '$id'");

        $stmt = $conn->prepare("update events set event_title = '$title', event_label = '$label', event_start = '$start', event_end = '$end', event_day = $allDay, event_url = '$url', event_location = '$location', event_description = '$description', guests='".json_encode($guests)."' where event_id = '$id' ");
         $stmt->execute();
         
         // update connection between event and guest/ send email to notify invited guests
        foreach($guests as $g){
            $existingGuests = checkExistingGuest($id, $g,$conn);
            if(!$existingGuests){
                echo "insert into event_users (event_id, user_id) values($id,$g)";
                $conn->query("insert into event_users (event_id, user_id) values($id,$g)"); 
            }
            sendMail($g,$conn, $_POST);
        }
        
        
        
        
        exit('update');       
    }





  // function that will notify user with event details
    function sendMail($user_id, $conn, $event){
        $sql = "select * from users where id=$user_id";
        $result = mysqli_query($conn, $sql);
        while ($row = $result ->fetch_object()){
            $email = $row->email;
            $subject = "Event Invitation ".$event['title'];
            $body = 'You are invited for the following event:<br>';
            $body.= 'Title: '.$event['title'].'<br>';
            $body.= 'Category: '.$event['label'].'<br>';
            $body.= 'Start: '.$event['start'].'<br>';
            $body.= 'End: '.$event['end'].'<br>';
            $body.= 'Url: '.$event['url'].'<br>';
            $body.= 'Location: '.$event['location'].'<br>';
            $body.= 'Descriptions:<br> '.$event['description'];

            mail($email, $subject, $body);
        }

    }

?>