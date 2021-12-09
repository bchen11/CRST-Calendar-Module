<?php

    ini_set('display_errors', 1); 
	error_reporting(E_ALL);
    session_start();

    // DB Connection and collect user form data
    $conn = new mysqli("sql308.epizy.com", "epiz_30427956", "fCGk6119Cg7I5", "epiz_30427956_CRSTDemo");
    if(isset($_POST['key']))
    {
        
 
        $title = $_POST['title'];
        $label = $_POST['label'];
        $start = $_POST['start'];
        $end = $_POST['end'];
        $allDay = $_POST['allDay'];
        $url = $_POST['url'];   
        $location = $_POST['location'];
        $description = $_POST['description'];
        $created_by = $_SESSION['id'];


        $guests = $_POST['guests'];
       
         // Query to insert data into events table
         
        // $data = $conn->query("insert into events(event_title, event_label, event_start, event_end, event_day, event_url, event_location, event_description,created_by) values('$title', '$label', '$start','$end', $allDay, '$url', '$location', '$description', $created_by)"); 


        $stmt = $conn->prepare("insert into events(event_title, event_label, event_start, event_end, event_day, event_url, event_location, event_description,created_by) values('$title', '$label', '$start','$end', $allDay, '$url', '$location', '$description', $created_by)");
        $stmt->execute();

        $result = $stmt->get_result();
        if($result->num_rows === 0){
            echo("failed to add event");
        }

        // Get the last inserted event id
        $event_id = $conn->insert_id;

        // create connection between event and guest/ send email to notify invited guests
        if(!empty($guests)){
            foreach($guests as $g){
              $data2 = $conn->query("insert into event_users (event_id, user_id) values($event_id,$g)");
              sendMail($g,$conn, $_POST);
            
            }
         }
                  
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