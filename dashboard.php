<?php
include 'server.php';
// Get Location from IP Address using PHP
// Use the IP Geolocation API to get the user’s location from IP using PHP.

// Call API via HTTP GET request using cURL in PHP.
// Convert API JSON response to array using json_decode() function.
// Retrieve IP data from API response.
// IP address 
// $userIP = $_SERVER['REMOTE_ADDR'];
 
//static ip address
// $ip = "208.98.12.1"; 

//Get IP Address of User in PHP
$ip = $_SERVER['REMOTE_ADDR']; 

//call api
$url = file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip);

//decode json data
$getInfo = json_decode($url); 

// print_r($getInfo);
    
//print the array to see the fields if you wish.

// echo "<table border='1' width='50%' align='center'><tr><td>COUNTRY:</td><td>";
// echo $getInfo->geoplugin_countryName;
// echo "</td></tr><tr><td>CITY:</td><td>";
// echo $getInfo->geoplugin_city;
// echo "</td></tr><tr><td>STATE OR REGION:</td><td>";
// echo $getInfo->geoplugin_region;
// echo "</td></tr><tr><td>IP ADDRESS:</td><td>";
// echo $getInfo->geoplugin_request;
// echo "</td></tr><tr><td>COUNTRY CODE:</td><td>";
// echo $getInfo->geoplugin_countryCode;
// echo "</td></tr><tr><td>LATITUTE:</td><td>";
// echo $getInfo->geoplugin_latitude;
// echo "</td></tr><tr><td>LONGITUDE:</td><td>";
// echo $getInfo->geoplugin_longitude;
// echo "</td></tr><tr><td>TIMEZONE:</td><td>";
// echo $getInfo->geoplugin_timezone;
// echo "</td></tr><tr></table>";

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Dashboard</title>
    <link rel="icon" href="./static/img/logo.png" type="image/x-icon" />
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <!--Bootstrap 4 CSS-->
    <link rel="stylesheet" href="./static/bootstrap4/css/bootstrap.min.css" />
    <!--Style Css-->
    <link rel="stylesheet" href="./static/css/style.css" />
  </head>
  <body>
    <div class="container-fluid" id="mynav">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Dashboard</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
      
      <?php
     if($_SESSION['username']){ ?>
                
      <li class="nav-item active">
      <a class="nav-link" href="logout.php">
      <?php echo "Welcome  ". "<strong style='color:white;'>".$_SESSION['firstname']." ".$_SESSION['lastname']."</strong>  <br>";  ?> </a>
      </li>
      <li class="nav-item active">
        <a class="nav-link btn btn-danger" href="logout.php">Logout </a>
      </li>
         <?php 
  } 
 ?>
    </ul>
    
  </div>
</nav>
</div>   


<div class="geo-section" >

<!--Cards-->
<div class="row " style="text-align: center;">
<!--start of one Card -->
<!-- IP address -->
<div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Your IP Address</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $ip ; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end of one Card -->
                        <!--start of one Card -->
<!-- IP address -->
<div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Your Longitude</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php  echo $getInfo->geoplugin_longitude;?> </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end of one Card -->
                                      <!--start of one Card -->
<!-- IP address -->
<div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Your Latitude</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $getInfo->geoplugin_latitude; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end of one Card -->
                        <!--end of Cards-->
                        </div>
                        </div>

                        <!--Request Help Section-->
                        <div class="help">
<div class="row" >
  <div class="col-sm-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Having a health emergency?</h5>
        <p class="card-text">Request for help by clicking the button below</p>
        <a href="#" class="btn btn-primary" >I Need Help</a>
      </div>
    </div>
  </div>
</div>
                        </div>
          
                        
    <!--Bootstrap 4 scripts-->
    <script
      src="./static/bootstrap4/jquery.js"
      integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
      crossorigin="anonymous"
    ></script>
    <script
      src="./static/bootstrap4/popper.js"
      integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
      crossorigin="anonymous"
    ></script>
    <script
      src="./static/bootstrap4/js/bootstrap.min.js"
      integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
      crossorigin="anonymous"
    ></script>
    <!-- End Bootstrap 4 scripts-->
  </body>
</html>
