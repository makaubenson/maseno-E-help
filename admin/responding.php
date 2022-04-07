<?php
include 'server.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php include './includes/header.php'; ?>
  <body>
    <?php include './includes/navbar.php'; ?>
<div class="container mt-4">
  <form method="post" action="server.php" class="border border-info p-5">
<?php
include 'errors.php';
?>
    <div class="row">
        <div class="col-md-12">
            <h3 style='text-align:center;'>Request Response Details.</h3>
        </div>
      <div class="col">
        <label for="student_name">Student Name</label>
        <input type="text" class="form-control" name='studentName' readonly placeholder="Enter your Full Name" value="<?php echo $_SESSION['firstname'] .' '.$_SESSION['lastname'] ; ?>" >
      </div>
      <div class="col">
        <label for="student_name">Phone number</label>
        <input type="text" class="form-control" name='student_phone' readonly placeholder="phone" value='<?php echo $_SESSION['phonenumber'];?>'>
      </div>
    </div>
<br>
    <div class="row">
      <div class="col">
        <label for="student_name">Help Code</label>
        <input type="text" class="form-control" name='student_helpcode' placeholder="help code" readonly value='<?php echo  $_SESSION['request_helpcode'];?>'>
      </div>
      <div class="col">
        <label for="student_name">Status</label>
        <input type="text" class="form-control" name='student_status' placeholder="status" readonly value='<?php echo $_SESSION['request_status'] ;?>'>
      </div>
    </div>
<br>
<div class="row">
  <div class="col">
    <label for="student_name">Moderator ID</label>
    <input type="text" class="form-control" name='admin_id' placeholder="help code" readonly value='<?php echo $_SESSION['admin_id'];?>'>
  </div>
  <div class="col">
    <label for="student_name">Moderator Name</label>
    <input type="text" class="form-control" name='admin_name' placeholder="status" readonly value='<?php echo $_SESSION['admin_firstname'].' '.$_SESSION['admin_lastname'] ;?>'>
  </div>
</div>
<br>
    <div class="row">
      <div class="col">
        <label for="student_name">Time of Request</label>
        <input type="text" class="form-control" name='time_of_request'readonly placeholder="Time of request" value='<?php echo $_SESSION['request_time'];?>'>
      </div>
      <div class="col">
        <label for="student_name">Team ID</label>
        <input type="text" class="form-control" name='team_name' readonly placeholder="status"  value='<?php echo $_SESSION['teamID'];?>'>
      </div>
    </div>
    <br>
    <div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
      <!-- <button type="submit" name='update-team-btn'class="btn btn-success btn-block">Update</button> -->
    </div>
    <div class="col-md-4"></div>
  </div>
  </form>
</div>



    <!--Bootstrap 4 scripts-->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<!-- End Bootstrap 4 scripts-->
<!-- modal script -->
<script src="./static/js/app.js"></script>
  </body>
</html>