<?php 
   session_start();
   include "dbconn.php";
   if (isset($_SESSION['username']) && isset($_SESSION['id'])) {   ?>


<html class="loading" lang="en" data-textdirection="ltr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" integrity="sha512-7x3zila4t2qNycrtZ31HO0NnJr8kg2VI67YLoRSyi9hGhRN66FHYWr7Axa9Y1J9tGYHVBPqIjSE1ogHrJTz51g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="icon" href="image/logo.gif">

    <script>
        
         function inputRestrict(input) {
            var regex = /[^a-z0-9]/gi;
            input.value = input.value.replace(regex,"");
        }
    </script>
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
    <link rel="stylesheet" type="text/css" href="assets/components.min.css">
	
	<link rel="stylesheet" type="text/css" href="assets/form-flat-pickr.min.css">
	<link rel="stylesheet" type="text/css" href="assets/app-calendar.css">
	<link rel="stylesheet" type="text/css" href="assets/form-validation.min.css">
</head>



<body class="vertical-layout vertical-menu-modern footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">
    <?php if ($_SESSION['role'] == 'admin') {?>
     <!-- For Admin -->
     

    <!-- Navbar --> 
   <?php 
        require "navbar.php";
    ?>



    <!--  Admin Content-->
    <div style = "margin-top: 20px">
        <div class="content-overlay"></div>
        
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body" >
                <!-- Full calendar start -->
                <section>
                    <div class="app-calendar overflow-hidden border">
                        <div class="row g-0">
                            <!-- Sidebar -->
                            <div class="col app-calendar-sidebar flex-grow-0 overflow-hidden d-flex flex-column" id="app-calendar-sidebar">
                                <div class="sidebar-wrapper">
                                    <div class="card-body d-flex justify-content-center" >
                                        <button class="btn btn-primary btn-toggle-sidebar w-100"   data-bs-toggle="modal" data-bs-target="#add-new-sidebar">
                                        <i data-feather='plus-square'></i>  <span class="align-middle">Add Event</span>
                                        </button>
                                    </div>
                                    <div class="card-body pb-0">
                                        <h5 class="section-label mb-1">
                                            <span class="align-middle">Filter</span>
                                        </h5>
                                        <div class="form-check mb-1 form-check-success">
                                            <input type="checkbox" class="form-check-input select-all" id="select-all" checked />
                                            <label class="form-check-label" for="select-all">View All</label>
                                        </div>
                                        <div class="calendar-events-filter">
                                            <div class="form-check form-check-danger mb-1">
                                                <input type="checkbox" class="form-check-input  input-filter" id="personal" data-value="personal"  checked />
                                                <label class="form-check-label" for="personal">Personal</label>
                                            </div>
                                            <div class="form-check form-check-primary mb-1">
                                                <input type="checkbox" class="form-check-input input-filter" id="business" data-value="business"  checked />
                                                <label class="form-check-label" for="business">Business</label>
                                            </div>
                                            <div class="form-check form-check-info mb-1">
                                                <input type="checkbox" class="form-check-input input-filter" id="etc" data-value="etc"  checked />
                                                <label class="form-check-label" for="etc">ETC</label>
                                            </div>

                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Sidebar -->

                            <!-- Calendar -->
                            <div class="col position-relative">
                                <div class="card shadow-none border-0 mb-0 rounded-0">
                                    <div class="card-body pb-0">
                                        <div id="calendar" ></div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Calendar -->
                            <div class="body-content-overlay"></div>
                        </div>
                    </div>
                    
                    <!-- Calendar Add/Update/Delete event modal-->
                    <div class="modal modal-slide-in event-sidebar fade" id="add-new-sidebar">
                        <div class="modal-dialog sidebar-lg">
                            <div class="modal-content p-0">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                <div class="modal-header mb-1">
                                    <h5 class="modal-title">Add Event</h5>
                                </div>
                                <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                                    <form class="event-form needs-validation" data-ajax="false" novalidate>
                                        <div class="mb-1">
                                            <label for="title" class="form-label">Title</label>
                                            <input type="text" class="form-control" id="title" name="title" placeholder="Event Title" required onkeyup="inputRestrict(this)" />
                                        </div>
                                        <div class="mb-1">
                                            <label for="select-label" class="form-label" >Label</label>
                                            <select class="select2 select-label form-select w-100" id="select-label" name="select-label" placeholder="Select Label">
                                                <option data-label="primary" value="Business" selected>Business</option>
                                                <option data-label="danger" value="Personal">Personal</option>
                                                <option data-label="info" value="ETC">ETC</option>
                    
                                            </select>
                                        </div>
                                        <div class="mb-1 position-relative">
                                            <label for="start-date" class="form-label">Start Date</label>
                                            <input type="text" class="form-control" id="start-date" name="start-date" placeholder="Start Date" />
                                        </div>
                                        <div class="mb-1 position-relative">
                                            <label for="end-date" class="form-label">End Date</label>
                                            <input type="text" class="form-control" id="end-date" name="end-date" placeholder="End Date" />
                                        </div>
                                        <div class="mb-1">
                                            <div class="form-check form-switch">
                                                <input type="checkbox" class="form-check-input allDay-switch"  id="customSwitch3"  />
                                                <label class="form-check-label" for="customSwitch3" >All Day</label>
                                            </div>
                                        </div>
                                        <div class="mb-1">
                                            <label for="event-url" class="form-label">Event URL</label>
                                            <input type="url" class="form-control" id="event-url" placeholder="https://www.google.com"  onkeyup="inputRestrict(this)"/>
                                        </div>


                                        <!-- add guest -->
                                        <div class="mb-1 select2-primary">
                                            <label for="event-guests" class="form-label">Add Guests</label>
                                            <select class="select2 select-add-guests form-select w-300" style="width: 75%" id="event-guests"  multiple >>
                                            <?php include 'user.php'; 
                                                 if (mysqli_num_rows($res) > 0){  
                                            ?>
                                            <?php
                                                while ($rows = mysqli_fetch_assoc($res)) {
                                                   echo '<option value="'.$rows['id'].'">'.$rows['username'].'</option>';
                                                }
                                            ?>
                                             <?php }?>  
                                            </select>
                                        </div>


                                       
                                        <div class="mb-1">
                                            <label for="event-location" class="form-label">Location</label>
                                            <input type="text" class="form-control" id="event-location" placeholder="Enter Location"  onkeyup="inputRestrict(this)" />
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label">Description</label>
                                            <textarea name="event-description-editor" id="event-description-editor" class="form-control" onkeyup="inputRestrict(this)"></textarea>
                                        </div>
                                        <div class="mb-1 d-flex">
                                            <button type="submit" class="btn btn-primary add-event-btn me-1" >Add</button>
                                            <button type="button" class="btn btn-outline-secondary btn-cancel" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary update-event-btn d-none me-1">Update</button>
                                            <button class="btn btn-outline-danger btn-delete-event d-none">Delete</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Calendar Add/Update/Delete event modal-->
                </section>
                <p>©&nbsp;&nbsp;2021&nbsp;Cornerstone Services, Inc.</p>
                
            </div>
        </div>
    </div>
    <!-- END: Admin Content-->


    <!-- FORE USERS -->                                           
    <?php }else { ?>
        <!-- Navbar --> 
        <?php 
        require "navbar.php";
        ?>

    <div>
        <div class="content-overlay"></div>
        
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body" >
                <!-- Full calendar start -->
                <section>
                    <div class="app-calendar overflow-hidden border">
                        <div class="row g-0">
                            <!-- Sidebar -->
                            <div class="col app-calendar-sidebar flex-grow-0 overflow-hidden d-flex flex-column" id="app-calendar-sidebar">
                                <div class="sidebar-wrapper">
                                    <div class="card-body d-flex justify-content-center" >
                                        <button class="btn btn-primary btn-toggle-sidebar w-100"   data-bs-toggle="modal" data-bs-target="#add-new-sidebar">
                                        <i data-feather='plus-square'></i>  <span class="align-middle">Add Event</span>
                                        </button>
                                    </div>
                                    <div class="card-body pb-0">
                                        <h5 class="section-label mb-1">
                                            <span class="align-middle">Filter</span>
                                        </h5>
                                        <div class="form-check mb-1 form-check-success">
                                            <input type="checkbox" class="form-check-input select-all" id="select-all" checked />
                                            <label class="form-check-label" for="select-all">View All</label>
                                        </div>
                                        <div class="calendar-events-filter">
                                            <div class="form-check form-check-danger mb-1">
                                                <input type="checkbox" class="form-check-input  input-filter" id="personal" data-value="personal"  checked />
                                                <label class="form-check-label" for="personal">Personal</label>
                                            </div>
                                            <div class="form-check form-check-primary mb-1">
                                                <input type="checkbox" class="form-check-input input-filter" id="business" data-value="business"  checked />
                                                <label class="form-check-label" for="business">Business</label>
                                            </div>
                                            <div class="form-check form-check-info mb-1">
                                                <input type="checkbox" class="form-check-input input-filter" id="etc" data-value="etc"  checked />
                                                <label class="form-check-label" for="etc">ETC</label>
                                            </div>

                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Sidebar -->

                            <!-- Calendar -->
                            <div class="col position-relative">
                                <div class="card shadow-none border-0 mb-0 rounded-0">
                                    <div class="card-body pb-0">
                                        <div id="calendar" ></div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Calendar -->
                            <div class="body-content-overlay"></div>
                        </div>
                    </div>
                    
                    <!-- Calendar Add/Update/Delete event modal-->
                    <div class="modal modal-slide-in event-sidebar fade" id="add-new-sidebar">
                        <div class="modal-dialog sidebar-lg">
                            <div class="modal-content p-0">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                <div class="modal-header mb-1">
                                    <h5 class="modal-title">Add Event</h5>
                                </div>
                                <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                                    <form class="event-form needs-validation" data-ajax="false" novalidate>
                                        <div class="mb-1">
                                            <label for="title" class="form-label">Title</label>
                                            <input type="text" class="form-control" id="title" name="title" placeholder="Event Title" required onkeyup="inputRestrict(this)" />
                                        </div>
                                        <div class="mb-1">
                                            <label for="select-label" class="form-label" >Label</label>
                                            <select class="select2 select-label form-select w-100" id="select-label" name="select-label" placeholder="Select Label">
                                                <option data-label="primary" value="Business" selected>Business</option>
                                                <option data-label="danger" value="Personal">Personal</option>
                                                <option data-label="info" value="ETC">ETC</option>
                    
                                            </select>
                                        </div>
                                        <div class="mb-1 position-relative">
                                            <label for="start-date" class="form-label">Start Date</label>
                                            <input type="text" class="form-control" id="start-date" name="start-date" placeholder="Start Date" />
                                        </div>
                                        <div class="mb-1 position-relative">
                                            <label for="end-date" class="form-label">End Date</label>
                                            <input type="text" class="form-control" id="end-date" name="end-date" placeholder="End Date" />
                                        </div>
                                        <div class="mb-1">
                                            <div class="form-check form-switch">
                                                <input type="checkbox" class="form-check-input allDay-switch"  id="customSwitch3"  />
                                                <label class="form-check-label" for="customSwitch3" >All Day</label>
                                            </div>
                                        </div>
                                        <div class="mb-1">
                                            <label for="event-url" class="form-label">Event URL</label>
                                            <input type="url" class="form-control" id="event-url" placeholder="https://www.google.com" onkeyup="inputRestrict(this)" />
                                        </div>

                                        <!-- add guest -->
                                        <div class="mb-1 select2-primary">
                                            <label for="event-guests" class="form-label">Add Guests</label>
                                            <select class="select2 select-add-guests form-select w-300" style="width: 100%" id="event-guests"  multiple >>
                                            <?php include 'user.php'; 
                                                 if (mysqli_num_rows($res) > 0){  
                                            ?>
                                            <?php
                                                while ($rows = mysqli_fetch_assoc($res)) {
                                                   echo '<option value="'.$rows['id'].'">'.$rows['username'].'</option>';
                                                }
                                            ?>
                                             <?php }?>  
                                            </select>
                                        </div>
                                       
                                        <div class="mb-1">
                                            <label for="event-location" class="form-label">Location</label>
                                            <input type="text" class="form-control" id="event-location" placeholder="Enter Location" onkeyup="inputRestrict(this)" />
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label">Description</label>
                                            <textarea name="event-description-editor" id="event-description-editor" class="form-control" onkeyup="inputRestrict(this)"></textarea>
                                        </div>
                                        <div class="mb-1 d-flex">
                                            <button type="submit" class="btn btn-primary add-event-btn me-1" >Add</button>
                                            <button type="button" class="btn btn-outline-secondary btn-cancel" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary update-event-btn d-none me-1">Update</button>
                                            <button class="btn btn-outline-danger btn-delete-event d-none">Delete</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Calendar Add/Update/Delete event modal-->
                </section>
                <p>©&nbsp;&nbsp;2021&nbsp;Cornerstone Services, Inc.</p>
            </div>
        </div>
    </div>


    <?php } ?>
    
   





    <!-- JS Files import -->                                          
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
    <script src="assets/fullcalendar.min.js"></script>
    <script src="assets/feather-icons.min.js"></script>
    <script src="assets/moment.min.js"></script>
	<script src="assets/select2.full.min.js"></script>
    <script src="assets/jquery.validate.min.js"></script>
    <script src="assets/flatpickr.min.js"></script>
	<script src="assets/app-calendar.js"></script>

    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })

        function inputRestrict(input) {
            var regex = /[^a-z0-9]/gi;
            input.value = input.value.replace(regex,"");
        }


    </script>


    <script>

            // Dark/Light mode switch
            var icon = document.getElementById("icon");
            icon.onclick = function(){
                document.body.classList.toggle("dark-layout")
                if(document.body.classList.contains("dark-layout")){
                    icon.src = "image/sun.png";
                }else {
                    icon.src = "image/moon.png";
                }
            }


            //function that notify the user about upcoming event based on current time 
            jQuery(document).ready(function($){
                
                setInterval(function(){
                    var d = new Date();
                    var datetime = d.getFullYear() + "-" + ("0"+(d.getMonth()+1)).slice(-2) + "-" + ("0" + d.getDate()).slice(-2) + " " + ("0" + d.getHours()).slice(-2) + ":" + ("0" + d.getMinutes()).slice(-2) + ":" + ("0" + d.getSeconds()).slice(-2);
                    $.ajax({
                        url: "notify.php",
                        type:"POST",
                        data: {
                        action: 'notification',
                        date: datetime
                        },
                        success: function(data){
                            console.log(data);
                            obj = JSON.parse(data);
                            if(obj.notify == 'true'){
                                alert(obj.msg);
                            }
                            
                        }


                    });
                }, 60000);
            });
    </script>
  
</body>
</html>
<?php }else{
	header("Location: index.php");
} ?>

