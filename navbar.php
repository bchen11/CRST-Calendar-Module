<?php
session_start();
?>

 <!-- Navbar --> 
    <nav class="navbar" style = "padding: 5px 5px 10px 10px;"  >
            <!-- <h1>Admin</h1> -->
            <a class="navbar-brand "href="calendar.php">
                <img src="image/logo.gif" width="30" height="30" class="d-inline-block align-top" >
                CRST Calendar Demo
            </a>
               
       
        <div id ='navSelect' class='d-flex justify-content-end' >
               <div>
                <img style = "padding: 5px 10px 1px 5px;" src="image/moon.png"  id="icon">
                <!-- <a href="logout.php"><i data-feather='log-out' ></i>Logout</a>  -->
            </div>   
        <?php
            /**if there's a user that is currently signed in, we will display the navbar. Change this to base it on your variable
             * for the users' ID. Else, we will redirect the user back to the logout page
            **/
            if(isset($_SESSION['id'])){
                echo(/*
                    First, will be the user's first name and if they click on it they will be redirected to the user panel which will depend on
                    their user privlages. The variable 'ufname', will is a session variable we use from the user's acount
                    Finally, we will display the logout button*/"
                


                <div class='me-1 nav-item'>
                <a href='panel_redirect.php'> <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-person-circle' viewBox='0 0 16 16'>
                <path d='M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z'/>
                <path fill-rule='evenodd' d='M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z'/>
                </svg>"
                .$_SESSION['username'].
                "</a>
                </div>
                
                <div class='me-2 nav-item'>
                <a href='logout.php'>  
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-door-open-filled' viewBox='0 0 16 16'>
                    <path d='M1.5 15a.5.5 0 0 0 0 1h13a.5.5 0 0 0 0-1H13V2.5A1.5 1.5 0 0 0 11.5 1H11V.5a.5.5 0 0 0-.57-.495l-7 1A.5.5 0 0 0 3 1.5V15H1.5zM11 2h.5a.5.5 0 0 1 .5.5V15h-1V2zm-2.5 8c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1z'/>
                    </svg> Logout
                </a>
                </div>");
            }else{
            }
        ?>
    </div>
            
    </nav>



       <script>
            var icon = document.getElementById("icon");
            icon.onclick = function(){
                document.body.classList.toggle("dark-layout")
                if(document.body.classList.contains("dark-layout")){
                    icon.src = "image/sun.png";
                }else {
                    icon.src = "image/moon.png";
                }
            }


        </script>