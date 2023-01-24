<?php $pageTitle = "Process Registration";?>
<?php
include 'inc/constants.php';
include 'inc/basic_functions.php';
include 'inc/db_connections.php';

if(!isset($_POST['add'])){
    header("LOCATION: " . BASE_URL.'register.php');
    exit();
}
/// variables
$firstName = strtoupper(mysqli_prep($_POST['firstName']));
$middleName = strtoupper(mysqli_prep($_POST['middleName']));
$lastName = strtoupper(mysqli_prep($_POST['lastName']));
$suffix = mysqli_prep($_POST['suffix']);
$email = mysqli_prep($_POST['email']);
$mobile = mysqli_prep($_POST['mobile']);
$message_err = "";
$message_success="";

//check if essential variables are not empty
if(($firstName == "") || ($lastName == "") || ($email == "") || ($mobile == "")){
    header("LOCATION: " . BASE_URL.'register.php');
    exit();
}

//check existence of record
$chk = "SELECT col_id FROM tbl_applicants WHERE (col_firstName = '$firstName' AND col_lastName = '$lastName' AND col_middleName = '$middleName' AND col_suffix = '$suffix') OR col_email = '$email' ";

$rCheck = mysqli_query($con, $chk);

if(!$rCheck){
	die("Error: Can't check record existence. " . mysqli_error($con));
}

$count = mysqli_num_rows($rCheck);
if($count > 0)
{
    $message_err = "<div class='alert alert-warning'><p><strong>REGISTRATION FAILED!</strong></p><p>A similar record is found in the database. If you forgot your email and password, contact the secretariat of the Division for assistance.</p></div> ";
}else{
    
    //set random password
    $length = random_bytes('4');

    //Print the reult and convert by binaryhexa
    $password = bin2hex($length);
    $pword = salt($password);

    //send email
             
  $to = $email;
  $subject = "ODiSCS: Temporary Password";  
  $message="
  <html>
  <body>
    <p>You have successfully registered to ODiSCS. To access your account for the first time, use the temporary password below. <strong>DON'T FORGET TO CHANGE YOUR PASSWORD AFTER YOU SIGN IN.</strong></p>
    <h1>Temporary Password: $password</h1>
    
    <p><i>Don't reply to this message.</i></p>
  </body>
  </html>";

  $from = "info@odiscs.net";
  $headers = "From: $from\r\n";
  $headers .= "Content-type: text/html\r\n";

  $retval = mail($to,$subject,$message,$headers);

	if($retval == true){
        //if email was successfully sent
        
        $query = "INSERT INTO tbl_applicants (col_lastName, col_firstName, col_middleName, col_suffix, col_email, col_mobileNumber, col_password, col_uan, col_status)
                VALUES('$lastName','$firstName','$middleName','$suffix','$email','$mobile','$pword','$password','1')";
        $result = mysqli_query($con,$query);

        set_recordID(mysqli_insert_id($con),'tbl_applicants',$con);

        if(!$result){
            die("Error in adding new applicants. " . mysqli_error($con));
        }

        $message_success = "<div class='alert alert-success'><p><strong>REGISTRATION SUCCESSFUL!</strong> <p>Open your registered email address to view your temporary password. Don't forget to change your password after you log in.</p></div> ";

	}else{

        $message_err = "<div class='alert alert-danger'><p><strong>EMAIL ERROR!</strong></p><p>The Email Address you provided do not exist or is invalid. Please try again or use a working email address.";
	}
    

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>ODiSCS: <?php echo $pageTitle;?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="<?php echo BASE_URL;?>img/favicon.ico" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body style='background-color:#eaeaea'>

<div class="mt-4 d-flex justify-content-center align-items-center" style="margin-bottom: 3em;">
  <div class="container">
    <div class="row d-flex justify-content-center">
      <div class="col-12 col-md-8 col-lg-5">
        <div class="card bg-white">
          <div class="card-body p-5">
            <div>
              <img src="<?php echo BASE_URL.'img/odiscs - logo.png';?>" class='mx-auto d-block' style="width: 50%; height: auto" />
              <h6 class="fw-bold mb-2 text-uppercase text-center">Online Division Selection Committee System</h6>
              <?php
                if($message_err == ""){
                    echo $message_success;
                }else{
                    echo $message_err;
                }
              ?>
            </div>
            <div>
              <p class="mb-0  text-left"> 
                Back to <a href="<?php echo BASE_URL;?>" class="text-primary fw-bold">Login</a>
              </p>
              <p class="mb-0  text-left"> 
                Back to <a href="<?php echo BASE_URL.'register.php';?>" class="text-primary fw-bold">Register</a>
              </p>
              <p class="font-weight-light text-center" style="font-size: 14px; margin-top: 3em;">Version 2.0</p>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="js/captcha.js"></script>
</body>
</html>
