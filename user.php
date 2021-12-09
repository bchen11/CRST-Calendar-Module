<?php  

 $conn = new mysqli("sql308.epizy.com", "epiz_30427956", "fCGk6119Cg7I5", "epiz_30427956_CRSTDemo");

// list all user for guest invitation
if (isset($_SESSION['username']) && isset($_SESSION['id'])) {
    
    $sql = "SELECT * FROM users ORDER BY id ASC";
    $res = mysqli_query($conn, $sql);

	if(mysqli_num_rows($res) === 0){
		echo("DB error");
	}
  
    
    }else{
	header("Location: index.php");
} 