<?php 
session_start();
// // Report all PHP errors
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

// connect to the database
// connect to the database
try{
  $db = mysqli_connect('localhost', 'benson', 'benson', 'maseno_e_help');
//    $db = mysqli_connect('localhost', 'blinxcok_benson', 'aFek]Np@ZVPZ', 'blinxcok_maseno_e_help');
//echo 'Database Connected Successfully';
}
catch(Exception $e) {
  // echo 'Message: ' .$e->getMessage();
  echo 'Database Connection Failed.';
}

    // ADMIN USER LOGIN
if (isset($_POST['admin_login_btn'])) {
  $username = strtoupper($_POST['admin_id']);
  $password = $_POST['admin_password'];
  if (empty($username)) {
  	array_push($errors, "Username is required");
  }
  if (empty($password)) {
  	array_push($errors, "Password is required");
  }
  if (count($errors) == 0) {
    $encrypted_password = md5($password);
  	$login_query = "SELECT * FROM `admin_details` WHERE `admin_id`='$username' AND `admin_password`='$encrypted_password'";
  	$results = mysqli_query($db, $login_query);
  	if (mysqli_num_rows($results) == 1) {
      $row = mysqli_fetch_assoc($results);
    // end generate random alphanumeric character
      //row data
      $adminID=$row['admin_id'];
      $adminFname=$row['admin_firstname'];
      $adminLname=$row['admin_lastname'];
      $adminMail=$row['admin_email'];
      $adminPhone=$row['admin_phone'];
      $adminRank=$row['admin_rank'];
     
      //sessions
      $_SESSION['admin_id'] = $adminID;
      $_SESSION['admin_firstname'] = $adminFname;
      $_SESSION['admin_lastname'] = $adminLname;
      $_SESSION['admin_email'] =$adminMail;
      $_SESSION['admin_phone'] =$adminPhone;
      $_SESSION['admin_rank'] =$adminRank;
  	  $_SESSION['success'] = "You are now logged in";
  	  header('location: dashboard.php');
  	}else{
  		array_push($errors, "Incorrect Username or Password");
      header('location: index.php');
  	}
  }
}

    // Viewing Tasks
    if (isset($_POST['view-btn'])) {
      $request_helpcode = $_POST['help_code'];
   
      if (empty($request_helpcode)) {
        array_push($errors, "This request lacks a help code");
      }
    
      if (count($errors) == 0) {
        $fetch_query = "SELECT request_status.helpID,request_status.status,
        request_status.admNo,request_status.timestamp,
        student_details.regNum,student_details.firstname,student_details.lastname,student_details.phonenumber
        FROM request_status
        INNER JOIN student_details ON request_status.admNo = student_details.regNum
        WHERE request_status.helpID = '$request_helpcode'";
        
    
        $fetch_results = mysqli_query($db, $fetch_query);
        if (mysqli_num_rows($fetch_results) == 1) {
          $row = mysqli_fetch_assoc($fetch_results);
        // end generate random alphanumeric character
          //row data
          $student_fname=$row['firstname'];
          $student_lname=$row['lastname'];
          $student_phone=$row['phonenumber'];
          $request_helpcode=$row['helpID'];
          $request_status=$row['status'];
          $request_time=$row['timestamp'];

          //sessions
          $_SESSION['firstname'] = $student_fname;
          $_SESSION['lastname'] =$student_lname;
          $_SESSION['phonenumber'] = $student_phone;
          $_SESSION['request_helpcode'] =$request_helpcode;
          $_SESSION['request_status'] =$request_status;
          $_SESSION['request_time'] =$request_time;

          header('location: view.php');
        }else{
          array_push($errors, "Unable to fetch data");
          header('location: inqueue.php');
        }
      }
    }

    // Rescue Team Assignment
    if (isset($_POST['update-team-btn'])) {
      $student_name = $_POST['studentName'];
      $student_phonenumber = $_POST['student_phone'];
      $request_helpcode = $_POST['student_helpcode'];
      $student_status = $_POST['student_status'];
      $request_time = $_POST['time_of_request'];
      $moderator_id = $_POST['admin_id'];
      $moderator_name = $_POST['admin_name'];
      $selected_team_id = $_POST['team'];

      if (empty($student_name)) {
        array_push($errors, "Student name is required");
      }
      if (empty($student_phonenumber)) {
        array_push($errors, "Student phone number is required");
      }
      if (empty($request_helpcode)) {
        array_push($errors, "Student help code is required");
      }
      if (empty($student_status)) {
        array_push($errors, "Student status is required");
      }
      if (empty($request_time)) {
        array_push($errors, "Request time is required");
      }      
      if (empty($selected_team_id)) {
        array_push($errors, "No team was selected");
      }

      if (count($errors) == 0) {
        $insert_query = "INSERT INTO `rescue_team_tasks`(`task_help_code`,`assigning_admin_id`,
         `team_status`,`rescue_team_id`)
         VALUES ('$request_helpcode','$moderator_id','Assigned','$selected_team_id')";
        
        $fetch_results = mysqli_query($db, $insert_query);

          header('location: inqueue.php');
        }else{
          array_push($errors, "Unable to fetch data");
          header('location: view.php');
        }
      }
    
// Rescue Team Re-Assignment
if (isset($_POST['reassign-btn'])) {
  $request_help_code = $_POST['help_code_2'];
  
  if (empty($request_help_code)) {
    array_push($errors, "Help code is missing");
  }

  if (count($errors) == 0) {
    //Select Data from DB
    $select_query = "SELECT request_status.*, rescue_team_tasks.*, student_details.*
    FROM request_status 
    INNER JOIN rescue_team_tasks ON request_status.helpID = rescue_team_tasks.task_help_code
    INNER JOIN student_details ON request_status.admNo = student_details.regNum
    WHERE request_status.helpID = '$request_help_code'";
  

  $fetch_results = mysqli_query($db, $select_query);
        if (mysqli_num_rows($fetch_results) == 1) {
          $row = mysqli_fetch_assoc($fetch_results);
        // end generate random alphanumeric character
          //row data
          $student_fname=$row['firstname'];
          $student_lname=$row['lastname'];
          $student_phone=$row['phonenumber'];
          $request_helpcode=$row['helpID'];
          $team_status=$row['team_status'];
          $team_assignment_time=$row['assignment_time'];

          //sessions
          $_SESSION['fname'] = $student_fname;
          $_SESSION['lname'] =$student_lname;
          $_SESSION['phone'] = $student_phone;
          $_SESSION['helpID'] =$request_helpcode;
          $_SESSION['team_status'] =$team_status;
          $_SESSION['team_assignment_time'] =$team_assignment_time;

          header('location: reassign.php');
    }else{
      array_push($errors, "Unable to fetch data");
      header('location: inqueue.php');
    }
  }

}
// Update Rescue Team Assignment
if (isset($_POST['reassign-team-btn'])) {
  $selected_team_id = $_POST['rescue_team_id'];
  $request_code = $_POST['student_helpcode'];
  $moderator_id = $_POST['admin_id'];
  $moderator_name = $_POST['admin_name'];

  if (empty($selected_team_id)) {
    array_push($errors, "No team was selected");
  }
  if (empty($request_code)) {
    array_push($errors, "No request code was selected");
  }
  if (empty($moderator_id)) {
    array_push($errors, "Moderator ID is missing");
  }
  if (empty($moderator_name)) {
    array_push($errors, "Moderator name is missing");
  }
 
  if (count($errors) == 0) {
    $update_query = "UPDATE `rescue_team_tasks` SET `rescue_team_id`='$selected_team_id',`assigning_admin_id`='$moderator_id' WHERE task_help_code = '$request_code' ";
    $update_results = mysqli_query($db,$update_query);

      header('location: inqueue.php');
    }else{
      array_push($errors, "Unable to fetch data");
      header('location: inqueue.php');
    }
  }
    // Viewing Requests Being Responded to.
    if (isset($_POST['view-requests-being-attended-btn'])) {
      $request_helpcode = $_POST['help_code'];
   
      if (empty($request_helpcode)) {
        array_push($errors, "This request lacks a help code");
      }
    
      if (count($errors) == 0) {
        $fetch_query = "SELECT request_status.helpID,request_status.status,
        request_status.admNo,request_status.timestamp,
        student_details.regNum,student_details.firstname,student_details.lastname,student_details.phonenumber, rescue_team_tasks.task_help_code,rescue_team_tasks.rescue_team_id
        FROM request_status
        INNER JOIN student_details ON request_status.admNo = student_details.regNum
        INNER JOIN rescue_team_tasks ON request_status.helpID = rescue_team_tasks.task_help_code
        WHERE request_status.helpID = '$request_helpcode'";
        
    
        $fetch_results = mysqli_query($db, $fetch_query);
        if (mysqli_num_rows($fetch_results) == 1) {
          $row = mysqli_fetch_assoc($fetch_results);
        // end generate random alphanumeric character
          //row data
          $student_fname=$row['firstname'];
          $student_lname=$row['lastname'];
          $student_phone=$row['phonenumber'];
          $request_helpcode=$row['helpID'];
          $request_status=$row['status'];
          $team_id = $row['rescue_team_id'];
          $request_time=$row['timestamp'];

          //sessions
          $_SESSION['firstname'] = $student_fname;
          $_SESSION['lastname'] =$student_lname;
          $_SESSION['phonenumber'] = $student_phone;
          $_SESSION['request_helpcode'] =$request_helpcode;
          $_SESSION['teamID'] = $team_id;
          $_SESSION['request_status'] =$request_status;
          $_SESSION['request_time'] =$request_time;

          header('location: responding.php');
        }else{
          array_push($errors, "Unable to fetch data");
          header('location: inqueue.php');
        }
      }
    }
  // Viewing teams
  if (isset($_POST['edit-team-btn'])) {
    $rescue_team_id = $_POST['teamID'];
 
    if (empty($rescue_team_id)) {
      array_push($errors, "No Team ID was selected");
    }
  
    if (count($errors) == 0) {
      $fetch_query = "SELECT * FROM rescue_team WHERE team_id = '$rescue_team_id'";
      
  
      $fetch_results = mysqli_query($db, $fetch_query);
      if (mysqli_num_rows($fetch_results) == 1) {
        $row = mysqli_fetch_assoc($fetch_results);
      // end generate random alphanumeric character
        //row data
        $team_id=$row['team_id'];
        $team_username=$row['team_username'];
        $team_name=$row['team_name'];
        $team_phonenumber=$row['team_phone'];
        $team_email=$row['team_email'];
        $team_login_pass = $row['team_password'];
        $time_of_reg=$row['registration_timestamp'];

        //sessions
        $_SESSION['rescue_team_id'] = $team_id;
        $_SESSION['team_username'] =$team_username;
        $_SESSION['team_name'] =  $team_name;
        $_SESSION['team_phone'] =$team_phonenumber;
        $_SESSION['team_email'] =$team_email;
        $_SESSION['team_password'] =$team_login_pass;
        $_SESSION['registration_timestamp'] =$time_of_reg;

        header('location: team_view.php');
      }else{
        array_push($errors, "Unable to fetch data");
        header('location: team.php');
      }
    }
  }
  // Updating Team Details
  if (isset($_POST['update-team-details'])) {
    $rescue_team_id = $_POST['team_identifier'];
    $rescue_team_name = $_POST['teamName'];
    $rescue_team_username = $_POST['team_username'];
    $rescue_team_phone = $_POST['team_phone'];
    $rescue_team_email = $_POST['team_email'];
    // $rescue_team_password = $_POST['team_password'];
 //Validating Input Values
    if (empty($rescue_team_id)) {
      array_push($errors, "No Team ID was selected");
    }
    if (empty($rescue_team_name)) {
      array_push($errors, "Team name is missing");
    }
    if (empty($rescue_team_username)) {
      array_push($errors, "Team username is missing");
    }
    if (empty($rescue_team_phone)) {
      array_push($errors, "Team phone number is missing");
    }
    if (empty($rescue_team_email)) {
      array_push($errors, "Team email is missing");
    }
  
    if (count($errors) == 0) {
      $update_team_query = "UPDATE `rescue_team` SET `team_id`='$rescue_team_id',
      `team_username`='$rescue_team_username',`team_name`='$rescue_team_name',
      `team_phone`='$rescue_team_phone',
      `team_email`='$rescue_team_email' WHERE team_id='$rescue_team_id' ";
      $fetch_results = mysqli_query($db, $update_team_query);
        header('location: team.php');
      }else{
        array_push($errors, "Unable to fetch data");
        echo 'This operation failed terribly';
        // header('location: team.php');
      }
    }
    // Deleting Team Details
    if (isset($_POST['delete-team-btn'])) {
      $rescue_team_id = $_POST['teamID'];
   
   //Validating Input Values
      if (empty($rescue_team_id)) {
        array_push($errors, "No Team ID was selected");
      }
         
      if (count($errors) == 0) {

        $delete_team_query = "DELETE FROM `rescue_team` WHERE team_id='$rescue_team_id' ";
        $fetch_results = mysqli_query($db, $delete_team_query);
          header('location: team.php');
        }else{
          array_push($errors, "Unable to fetch delete data");
          header('location: team.php');
        }
      }


// Update Admin Details
if (isset($_POST['edit-admin-btn'])) {
  $moderator_ID = $_POST['admin_unique_id'];
  $moderator_fname = $_POST['admin_unique_fname'];
  $moderator_lname = $_POST['admin_unique_lname'];
  $moderator_emailAdd= $_POST['admin_unique_mail'];
  $moderator_phone= $_POST['admin_unique_phone'];
  $moderator_rank= $_POST['admin_unique_rank'];
  // $moderator_password= $_POST['adminPass'];

  if (empty($moderator_ID)) {
  	array_push($errors, "Moderator ID is required");
  }
  if (empty($moderator_fname)) {
  	array_push($errors, "Moderator First Name is required");
  }
  if (empty($moderator_lname)) {
  	array_push($errors, "Moderator Last Name is required");
  }
  if (empty($moderator_emailAdd)) {
  	array_push($errors, "Moderator Email Address is required");
  }
  if (empty($moderator_phone)) {
  	array_push($errors, "Moderator Phone Number is required");
  }
  if (empty($moderator_rank)) {
  	array_push($errors, "Moderator Rank is required");
  }   
  // if (empty($moderator_password)) {
  // 	array_push($errors, "Moderator Password is required");
  // }

  if (count($errors) == 0) {

  	$admin_data_update_query = "UPDATE `admin_details` SET `admin_id`='$moderator_ID',`admin_firstname`='$moderator_fname',`admin_lastname`='$moderator_lname',`admin_email`='$moderator_emailAdd',`admin_phone`='$moderator_phone',`admin_rank`='$moderator_rank'
    WHERE admin_id='$moderator_ID' ";
  	$results = mysqli_query($db, $admin_data_update_query);
  	  header('location: moderators.php');
  	}else{
  		array_push($errors, "Unable to push updates");
      header('location: moderators.php');
  	}
  }
  // Deleting Admin Details
  if (isset($_POST['delete-admin-btn'])) {
    $moderator_ID = $_POST['admin_unique_id'];
    $moderator_fname = $_POST['admin_unique_fname'];
    $moderator_lname = $_POST['admin_unique_lname'];
    $moderator_emailAdd= $_POST['admin_unique_mail'];
    $moderator_phone= $_POST['admin_unique_phone'];
    $moderator_rank= $_POST['admin_unique_rank'];
    // $moderator_password= $_POST['adminPass'];
  
    if (empty($moderator_ID)) {
      array_push($errors, "Moderator ID is required");
    }
    if (empty($moderator_fname)) {
      array_push($errors, "Moderator First Name is required");
    }
    if (empty($moderator_lname)) {
      array_push($errors, "Moderator Last Name is required");
    }
    if (empty($moderator_emailAdd)) {
      array_push($errors, "Moderator Email Address is required");
    }
    if (empty($moderator_phone)) {
      array_push($errors, "Moderator Phone Number is required");
    }
    if (empty($moderator_rank)) {
      array_push($errors, "Moderator Rank is required");
    }   
    // if (empty($moderator_password)) {
    // 	array_push($errors, "Moderator Password is required");
    // }
  
    if (count($errors) == 0) {
  
      $admin_data_delete_query = "DELETE FROM `admin_details` WHERE admin_id='$moderator_ID' ";
        $delete_results = mysqli_query($db, $admin_data_delete_query);
        header('location: moderators.php');
      }else{
        array_push($errors, "Unable to push updates");
        header('location: moderators.php');
      }
    }

    // Register Rescue Team
if (isset($_POST['register_team_btn'])) {
  // receive all input values from the form
  $team_ID=strtoupper($_POST['team_id']);
  $teamName =  $_POST['team_name'];
  $team_Username =  $_POST['team_username'];
  $team_Email =  $_POST['team_email'];
  $team_Number =  $_POST['team_phone'];
  $password =  $_POST['team_password1'];
  $confirmPassword =  $_POST['team_password2'];
  // form validation: ensure that the form is correctly filled ...
// by adding (array_push()) corresponding error unto $errors array
if (empty($team_ID)) { array_push($errors, "Team ID is required"); }
if (empty($teamName)) { array_push($errors, "Team Name is required"); }
if (empty($team_Username)) { array_push($errors, "Team Username is required"); }
if (empty($team_Email)) { array_push($errors, "Team Email is required"); }
if (empty($team_Number)) { array_push($errors, "Team Phone Number is required"); }
if (empty($password)) { array_push($errors, "Password is required"); }
if (empty($confirmPassword)) { array_push($errors, "Confirm password is required"); }
if ($password != $confirmPassword) {
  array_push($errors, "The two passwords do not match");
}
// first check the database to make sure
// a team does not already exist with the same username and/or email

$team_check_query = "SELECT * FROM `rescue_team` WHERE team_id='$team_ID' OR team_email='$team_Email' LIMIT 1";
$result = mysqli_query($db, $team_check_query);
$user = mysqli_fetch_assoc($result);

if ($user) { // if team exists
  if ($user['team_id'] === $team_ID) {
    array_push($errors, "Team ID already exists");
  }
  if ($user['team_email'] === $team_Email) {
    array_push($errors, "Email already exists");
  }
}
// Finally, register team if there are no errors in the form
if (count($errors) == 0) {
  $encrypted_team_password = md5($confirmPassword);//encrypt the password before saving in the database

  $team_register_query = "INSERT INTO `rescue_team`(`team_id`, `team_username`, `team_name`, `team_phone`, `team_email`, `team_password`)
  VALUES ('$team_ID','$team_Username','$teamName','$team_Number','$team_Email','$encrypted_team_password')";
  mysqli_query($db, $team_register_query);
  header('location: team.php');
  }else{
    header('location: add_team.php');
  }
}

    // Register Rescue Team Member
    if (isset($_POST['register_team_member'])) {
      // receive all input values from the form
      $member_firstname=$_POST['member_fname'];
      $member_lastname=$_POST['member_lname'];
      $member_email=$_POST['member_email'];
      $member_phone=$_POST['member_phone']; 
      $member_role = $_POST['member_role'];
      $member_team = $_POST['member_team'];
      $member_id = $_POST['member_id'];

      // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($member_firstname)) { array_push($errors, "First Name is required"); }
    if (empty($member_lastname)) { array_push($errors, "Last Name is required"); }
    if (empty($member_email)) { array_push($errors, "Email is required"); }
    if (empty($member_phone)) { array_push($errors, "Phone Number is required"); }
    if (empty($member_role)) { array_push($errors, "Role is required"); }
    if (empty($member_team)) { array_push($errors, "Team is required"); }
    if (empty($member_id)) { array_push($errors, "Member ID is required"); }

   
    // first check the database to make sure
    // a team member does not already exist with the same username and/or email
    
    $member_check_query = "SELECT * FROM `rescue_team_members` WHERE member_id='$member_id'  LIMIT 1";
    $result = mysqli_query($db, $member_check_query);
    $member = mysqli_fetch_assoc($result);
    
    if ($member) { // if member exists
      if ($member['member_id'] === $member_id) {
        array_push($errors, "User already exists");
      }
    }
    // Finally, register team member if there are no errors in the form
    if (count($errors) == 0) {
      $member_register_query = "INSERT INTO `rescue_team_members`(`member_id`,`fname`, `lname`, `email`, `phone`,
       `role_id`, `rescue_team_id`)
       VALUES ('$member_id','$member_firstname','$member_lastname','$member_email','$member_phone',
       '$member_role','$member_team')";
     $member_results= mysqli_query($db, $member_register_query);
      header('location: team.php');
     
      }else{
        header('location: add_member.php');
      }
    }

    // Edit Paramedic Details
    if (isset($_POST['edit-paramedic-btn'])) {
      // receive all input values from the form
      $member_ID=$_POST['member_id'];
      
      // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($member_ID)) { array_push($errors, "Member ID is required"); }
    if (count($errors) == 0) {
    
    $paramedic_check_query = "SELECT * FROM `rescue_team_members` WHERE member_id='$member_ID'  LIMIT 1";
    $result = mysqli_query($db, $paramedic_check_query);
    $row = mysqli_fetch_assoc($result);
   
      //row data
      $paramedic_member_id=$row['member_id'];
      $paramedic_fname=$row['fname'];
      $paramedic_lname=$row['lname'];
      $paramedic_mail=$row['email'];
      $paramedic_phone=$row['phone'];
      $paramedic_role_id=$row['role_id'];
      $paramedic_team_id=$row['rescue_team_id'];

      //Create Sessions
      $_SESSION['member_id'] = $paramedic_member_id;
      $_SESSION['fname'] = $paramedic_fname;
      $_SESSION['lname'] =$paramedic_lname;
      $_SESSION['email'] = $paramedic_mail;
      $_SESSION['phone'] =$paramedic_phone;
      $_SESSION['role_id'] =$paramedic_role_id;
      $_SESSION['rescue_team_id'] =$paramedic_team_id;
     
      header('location: paramedic_view.php');
      }else{
        header('location: paramedics.php');
      }
    }


// Update Paramedic Details
if (isset($_POST['update-paramedic-details'])) {

  $fname = $_POST['paramedic_fname'];
  $lname = $_POST['paramedic_lname'];
  $emailAddress = $_POST['paramedic_email'];
  $phoneNum= $_POST['paramedic_phone'];
  $param_member_id= $_POST['paramedic_member_id'];
  $team_id= $_POST['paramedic_team_id'];

  if (empty($fname)) {
  	array_push($errors, "Paramedic First Name is required");
  }
  if (empty($lname)) {
  	array_push($errors, "Paramedic Last Name is required");
  }
  if (empty($emailAddress)) {
  	array_push($errors, "Paramedic Email is required");
  }
  if (empty($phoneNum)) {
  	array_push($errors, "Paramedic phone number is required");
  }
  if (empty($param_member_id)) {
  	array_push($errors, "Paramedic role ID is required");
  }
  if (empty($team_id)) {
  	array_push($errors, "Paramedic team ID is required");
  }

  if (count($errors) == 0) {

  	$paramedic_data_update_query = "UPDATE `rescue_team_members` SET `fname`='$fname',`lname`='$lname',`email`='$emailAddress',`phone`='$phoneNum',`rescue_team_id`='$team_id'
    WHERE member_id= '$param_member_id' ";
  	$results = mysqli_query($db, $paramedic_data_update_query);
  	  header('location: paramedics.php');
  	}else{
  		array_push($errors, "Unable to push updates");
      header('location: paramedic_view.php');
  	}
  }
  // Delete Paramedic Details
if (isset($_POST['delete-paramedic-btn'])) {
$member_id = $_POST['member_id'];

if (empty($member_id)) {
  array_push($errors, "Paramedic Member ID is required");
}
if (count($errors) == 0) {
  	$paramedic_data_delete_query = "DELETE FROM `rescue_team_members` WHERE member_id='$member_id ' ";
  	$results = mysqli_query($db, $paramedic_data_delete_query);
  	  header('location: paramedics.php');
  	}else{
  		array_push($errors, "Unable to push updates");
      header('location: paramedics.php');
  	}
}

// Edit Nurse Details
if (isset($_POST['edit-nurse-btn'])) {
  // receive all input values from the form
  $nurse_member_ID=$_POST['nurse_member_id'];
  
  // form validation: ensure that the form is correctly filled ...
// by adding (array_push()) corresponding error unto $errors array
if (empty($nurse_member_ID)) { array_push($errors, "Member ID is required"); }

if (count($errors) == 0) {

$nurse_check_query = "SELECT * FROM `rescue_team_members` WHERE member_id='$nurse_member_ID'  LIMIT 1";
$result = mysqli_query($db, $nurse_check_query);
$row = mysqli_fetch_assoc($result);

  //row data
  $nurse_member_id=$row['member_id'];
  $nurse_fname=$row['fname'];
  $nurse_lname=$row['lname'];
  $nurse_mail=$row['email'];
  $nurse_phone=$row['phone'];
  $nurse_role_id=$row['role_id'];
  $nurse_team_id=$row['rescue_team_id'];

  //Create Sessions
  $_SESSION['nurse_member_id'] = $nurse_member_id;
  $_SESSION['nurse_fname'] = $nurse_fname;
  $_SESSION['nurse_lname'] =$nurse_lname;
  $_SESSION['nurse_email'] = $nurse_mail;
  $_SESSION['nurse_phone'] =$nurse_phone;
  $_SESSION['nurse_role_id'] =$nurse_role_id;
  $_SESSION['nurse_rescue_team_id'] =$nurse_team_id;
 
  header('location: nurse_view.php');
  }else{
    header('location: paramedics.php');
  }
}

// Update Nurse Details
if (isset($_POST['update-nurse-details'])) {

  $nurse_fname = $_POST['nurse_fname'];
  $nurse_lname = $_POST['nurse_lname'];
  $nurse_emailAddress = $_POST['nurse_email'];
  $nurse_phoneNum= $_POST['nurse_phone'];
  $nurse_member_id= $_POST['nurse_member_id'];
  $nurse_team_id= $_POST['nurse_team_id'];

  if (empty($nurse_fname)) {
  	array_push($errors, "Nurse First Name is required");
  }
  if (empty($nurse_lname)) {
  	array_push($errors, "Nurse Last Name is required");
  }
  if (empty($nurse_emailAddress)) {
  	array_push($errors, "Nurse Email is required");
  }
  if (empty($nurse_phoneNum)) {
  	array_push($errors, "Nurse phone number is required");
  }
  if (empty($nurse_member_id)) {
  	array_push($errors, "Nurse role ID is required");
  }
  if (empty($nurse_team_id)) {
  	array_push($errors, "Nurse team ID is required");
  }

  if (count($errors) == 0) {

  	$nurse_data_update_query = "UPDATE `rescue_team_members` SET `fname`='$nurse_fname',`lname`='$nurse_lname',`email`='$nurse_emailAddress',`phone`='$nurse_phoneNum',`rescue_team_id`='$nurse_team_id'
    WHERE member_id= '$nurse_member_id' ";
  	$results = mysqli_query($db, $nurse_data_update_query);
  	  header('location: paramedics.php');
  	}else{
  		array_push($errors, "Unable to push updates");
      header('location: nurse_view.php');
  	}
  }
  // Delete Nurse Details
  if (isset($_POST['delete-nurse-btn'])) {
    $nurse_member_id = $_POST['nurse_member_id'];
    
    if (empty($nurse_member_id)) {
      array_push($errors, "Nurse Member ID is required");
    }
    if (count($errors) == 0) {
        $nurse_data_delete_query = "DELETE FROM `rescue_team_members` WHERE member_id='$nurse_member_id' ";
        $results = mysqli_query($db, $nurse_data_delete_query);
          header('location: paramedics.php');
        }else{
          array_push($errors, "Unable to delete record");
          header('location: paramedics.php');
        }
    }
?>