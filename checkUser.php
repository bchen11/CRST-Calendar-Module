<?php 
    session_start();
	ini_set('display_errors', 1); 
	error_reporting(E_ALL);

    // DB connection
	 $conn = new mysqli("sql308.epizy.com", "epiz_30427956", "fCGk6119Cg7I5", "epiz_30427956_CRSTDemo");

    // collect data from user input
    if (isset($_POST['username']) && isset($_POST['password'])) {

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
          }

        $username = test_input($_POST['username']);
	    $password = test_input($_POST['password']);
        $username = mysqli_real_escape_string($conn, $username);
        $password = mysqli_real_escape_string($conn, $password);
	    $role = test_input($_POST['role']);

        

        // redirect to login page 
        if (empty($username) || empty($password)) {
            header("Location: index.php?error=User Name and Password are Required");
            exit();
        }

        // check the user role/type
        else {

          
            // $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
         
            $stmt = $conn->prepare("SELECT * FROM users WHERE username='$username' AND password='$password'");
            $stmt->execute();

            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                // the user name must be unique
                $row = mysqli_fetch_assoc($result);
                if ($row['password'] === $password) {
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['role'] = $row['role'];
                    $_SESSION['username'] = $row['username'];
                    header("Location: calendar.php");   
                    exit('success');
    
                }else {
                    header("Location: index.php?error=Incorect User name or password");
                    exit();
                   
        }
    }else {
        header("Location: index.php?error=Incorect User name or password");
        exit();
    }
}
    }
    



	
 ?>