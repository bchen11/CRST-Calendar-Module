<?php 
  
   session_start();
   if (!isset($_SESSION['username']) && !isset($_SESSION['id'])) {   
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="icon" href="image/logo.gif">
    <title>CRST Calander Login</title>
  </head>
  <body>
  

    <!-- User Login Form -->
    <div>
        
        <img src="image/crst_logo.png" class="img-circle mt-2 " style ="margin-left: auto; margin-right:auto;display: block;" width="300" height="300"> 
    
        <form style="max-width: 480px; margin: auto;" class="border shadow p-3" role="form" method="post" action="calendar.php">
            <h3 class="mt-3 mb-3 font-weight-4">Please Sign In</h3>

            <?php if (isset($_GET['error'])) { ?>
      	      <div class="alert alert-danger" role="alert">
				      <?=$_GET['error']?>
			        </div>
			    <?php } ?>



            <div class="mb-3">
            <label class="form-label " for="login-username">User Name:</label>
            <input type="text" id="txt_uname" class="form-control mb-1"
            placeholder="Username" required autofocus>
            <label class="form-label " for="login-password">Password:</label>
            <input type="password" id="txt_pwd" class="form-control"
            placeholder="Password" aria-describedby="login-password" required autofocus>
          </div>
          

            <!-- <div class="mb-3">
            <label class="form-label">Select User Type:</label>
          </div>
          <select class="form-select mb-3"
                  name="role"
                  id="role" 
                  aria-label="Default select example">
            <option selected value="user">User</option>
            <option value="admin">Admin</option>
          </select> -->
            <div class="checkbox">
                    <label>
                      <input type ="checkbox" value="remember-me" class="mt-3"> Remember me
                    </label>
                  </div>


            <input type="button" id="submit" name="submit" value="Sign In" class="btn btn-lg btn-primary mt-2">
        </form>
        <br>
 
    </div>
    <p class="text-center">©&nbsp;&nbsp;2021&nbsp;Cornerstone Services, Inc.</p>
    
  </body>
  <script>

// ajax call for user authentication
$(document).ready(function(){
    $("#submit").click(function(){
        var username = $("#txt_uname").val().trim();
        var password = $("#txt_pwd").val().trim();
        var role = $("#role option:selected").val();
 

        if( username != "" && password != "" ){
            $.ajax({
                url:'checkUser.php',
                type:'post',
                data:{
                  username:username,
                  password:password,
                  // role: role
                },
                success:function(response){
                    
                   window.location = "calendar.php";  
                },
                error: function(jqXHR, textStatus, errorThrown){
                   alert(jqXHR.responseText);
                  }
                

            });
        }
        else {
          alert("User name and Password are required");
        }
    });
});
</script>

</html>

<?php }else{
	header("Location: calendar.php");
} ?>