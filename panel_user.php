<?php
    session_start();
    require "dbcon.php";
    require "navbar.php";
    //this function displays the user's type which is based on what section they work in.
    function getUserType($input){
        $type = '';
        if($input == 'admin'){
            $type = "Administrator";
        }
        else if($input == 'user'){
            $type = "Employee";
        }
        else{
            header(index.php);
        }
        return $type;
    }
?>

<!-- 
<!doctype html> -->
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" integrity="sha512-7x3zila4t2qNycrtZ31HO0NnJr8kg2VI67YLoRSyi9hGhRN66FHYWr7Axa9Y1J9tGYHVBPqIjSE1ogHrJTz51g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <link rel="icon" href="image/logo.gif">
        <title>CRST Calendar Demo</title>
        
        <!-- CSS file import -->
        <link rel="stylesheet" type="text/css" href="assets/style.css">
        <link rel="stylesheet" type="text/css" href="assets/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="assets/bootstrap-extended.min.css">
        
        <link rel="stylesheet" type="text/css" href="assets/vendors.min.css">
        <link rel="stylesheet" type="text/css" href="assets/fullcalendar.min.css">
        <link rel="stylesheet" type="text/css" href="assets/select2.min.css">
        <link rel="stylesheet" type="text/css" href="assets/flatpickr.min.css">
        <link rel="stylesheet" type="text/css" href="assets/colors.min.css">
            
        <link rel="stylesheet" type="text/css" href="assets/form-flat-pickr.min.css">
        <link rel="stylesheet" type="text/css" href="assets/app-calendar.css">
        <link rel="stylesheet" type="text/css" href="assets/form-validation.min.css">
    </head>
    <body>  
        <!--Welcome Message-->
        <div class="panel bg shadow rounded rounded-lg p-1">
            <h1 class ="d-flex mt-2 fade-in display-4">Welcome <?php echo($_SESSION['username']);?></h1>
            <div class ="d-flex">
                <h6 class="mb-1">User Type: <span class="text-primary"><?php echo(getUserType($_SESSION['role']));?></span></h6>
            </div>
        </div>

        <hr class="my-2" />
        <!--User Settings-->
        <div class="m-1">
        <strong class="mb-0">User Settings: </strong>
            <p>Control User Settings Here</p>
        </div>
        <div class="list-group mb-2 shadow">
            <div class="list-group-item">
                <a class="row align-items-center" data-bs-toggle="modal" data-bs-target="#address_book">
                    <div class="col">
                        <strong class="mb-0">Notification Settings:</strong>
                        <p class="text-muted mb-0">Control notification settings</p>
                    </div>
                </a>
            </div>
            <div class="list-group-item">
                <a class="row align-items-center" data-bs-toggle="modal" data-bs-target="#theme_settings">
                    <div class="col">
                        <strong class="mb-0">Theme Settings:</strong>
                        <p class="text-muted mb-0">Change the Look</p>
                    </div>
                </a>
            </div>
        </div>

        <div class=" justify-content-center">
        <p class="mx-1">©&nbsp;&nbsp;2021&nbsp;Cornerstone Services, Inc.</p>
        </div>

        <!--Theme Settings-->
        <div class="modal fade" id="theme_settings" tabindex="-1" role="dialog" aria-labelledby="modal1-label">
            <div class="modal-dialog modal-md">
                <div class="modal-content p-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-header mb-1">
                            <h3 class="modal-title justify-content-center">Theme Settings</h3>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3 mb-1">
                        <div class="form-inline">
                        <form>
                        <!-- Using the settings we have, we will default to the settings the user has choosen in the settings-->
                            <label>Dark Mode</label>
                            <select class="form-control" id="dark_setting">
                                <option value= 1 <?php if($_SESSION['darksetting'] == 'dark_on'){echo("selected");}?>>On</option>
                                <option value= 0 <?php if($_SESSION['darksetting'] == 'dark_off'){echo("selected");}?>>Off</option>
                            </select>
                            <label>User Theme</label>
                            <select class="form-control" id="theme_setting">
                                <option value= 1 <?php if($_SESSION['theme'] == 1){echo("selected");}?>>Theme 1</option>
                                <option value= 2 <?php if($_SESSION['theme'] == 2){echo("selected");}?>>Theme 2</option>
                                <option value= 3 <?php if($_SESSION['theme'] == 3){echo("selected");}?>>Theme 3</option>
                            </select>

                        </div>
                        <div class="mt-1 d-flex justify-content-center">
                            <input type="button" id="change_theme_settings" name="change_theme_settings" value="Save Settings" class="btn btn-primary">
                            <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Client List Modal -->
        <div class="modal fade" id="address_book" tabindex="-1" role="dialog" aria-labelledby="modal1-label">
            <div class="modal-dialog modal-lg">
                <div class="modal-content p-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="modal-header mb-1">
                            <h3 class="modal-title justify-content-center">Clients</h3>
                            <button class="btn btn-primary btn-toggle-sidebar me-1" data-bs-toggle="modal" data-bs-target="#addAddress">
                                <i data-feather='plus-square'></i>Add Client</span>
                            </button>
                        </div>
                        <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                            <?php
                                $sql = "SELECT * FROM address_book";
                                $result = mysqli_query($conn, $sql);
                                $queryResult = mysqli_num_rows($result);
                                    /*here we're going to loop through the entire clients list and display their information to admin.
                                    */
                                    while($row = mysqli_fetch_assoc($result)){
                                        echo("
                                        <div class='mb-2 d-flex gap-3 justify-content-start'>
                                        <h5 class='me-1'>".$row['address_name']."</h5>
                                        <h5 class='me-1'>".$row['address']."</h5>
                                        <button type='submit' id='add_address' name='add_address' aria-label='Close' class='me-1 btn btn-primary' >Edit Client</button>
                                        <button type='submit' id='but_submit' name='but_submit' aria-label='Close' class='btn btn-primary add-event-btn me-1 w-100' >Delete Client</button>
                                        </div>
                                        ");
                                    }
                            ?>
                        </div>
                </div>
            </div>
        </div>

    <!-- JS Files import -->                                          
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
    <script src="assets/fullcalendar.min.js"></script>
    <script src="assets/feather-icons.min.js"></script>
    <script src="assets/moment.min.js"></script>
	<script src="assets/select2.full.min.js"></script>
    <script src="assets/jquery.validate.min.js"></script>
    <script src="assets/flatpickr.min.js"></script>
	<script src="assets/app-calendar.js"></script>
    
    <!--AJAX Calls-->


   

</body>
</html>