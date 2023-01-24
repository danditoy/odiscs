<?php $pageTitle = "Register";?>
<?php
include 'inc/constants.php';
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
  <style>
    #content-desktop {display: block;}
    #content-mobile {display: none;}
    #content-phone {display: none;}

    @media screen and (max-width: 768px) {
        #content-desktop {display: none;}
        #content-mobile {display: block;}
        #content-phone {display: none;}
    }

    @media screen and (max-device-width: 640px){
        #content-desktop {display: none;}
        #content-mobile {display: none;}
        #content-phone {display: block;}
    }

    /* Code By Webdevtrick ( https://webdevtrick.com )*/
    @import url(https://fonts.googleapis.com/css?family=Open+Sans:400,600,300,700);
    @import url(https://fonts.googleapis.com/css?family=Roboto+Slab:400,100);

    .captchaField { 
    margin: 0 auto;
    border: 1px solid #ccc; 
    padding: 15px;
    width: auto;
    background-color: #fff;
    border-radius: 5px;
    }
    .CaptchaWrap { position: relative; }
    .CaptchaTxtField { 
    border-radius: 5px; 
    border: 1px solid #ccc; 
    display: block;  
    box-sizing: border-box;
    }
    #CaptchaImageCode { 
    text-align:center;
    margin-top: 15px;
    padding: 0px 0;
    width: 300px;
    overflow: hidden;
    }
    .capcode { 
    font-size: 24px; 
    display: block; 
    -moz-user-select: none;
    -webkit-user-select: none;
    user-select: none; 
    cursor: default;
    letter-spacing: 1px;
    color: #ccc;
    font-family: 'Roboto Slab', serif;
    font-weight: 100;
    font-style: italic;
    }
    .ReloadBtn { 
    background:url('https://webdevtrick.com/wp-content/uploads/recaptcha.png') left top no-repeat;   
    background-size : 100%;
    }
    .btnSubmit {
    margin-top: 15px;
    }
    .error { 
    color: red; 
    font-size: 12px; 
    display: none; 
    }
    .success {
    color: green;
    font-size: 18px;
    margin-bottom: 15px;
    display: none;
    }


    </style>
</head>
<body style='background-color:#eaeaea'>

<div class="mt-4 d-flex justify-content-center align-items-center" style="margin-bottom: 3em;">
  <div class="container">
    <div class="row d-flex justify-content-center">
      <div class="col-12 col-md-8 col-lg-5">
        <div class="card bg-white">
          <div class="card-body p-5">
            <form class="mb-3" action="process-registration.php" id="myForm" method="post">
                <img src="<?php echo BASE_URL.'img/odiscs - logo.png';?>" class='mx-auto d-block' style="width: 50%; height: auto" />
              <h6 class="fw-bold mb-2 text-uppercase text-center">Online Division Selection Committee System</h6>
              <p class="fw-bold mb-2 text-uppercase text-center text-primary">REGISTRATION FORM</p>
                <div class="mb-2 row">
                    <label for="last-name" class="col-sm-4 col-form-label"><small>Last Name</small></label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control form-control-sm" id="last-name" name="lastName" required />
                    </div>
                </div>
                <div class="mb-2 row">
                    <label for="first-name" class="col-sm-4 col-form-label"><small>First Name</small></label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control form-control-sm" id="first-name" name="firstName" required />
                    </div>
                </div>
                <div class="mb-2 row">
                    <label for="middle-name" class="col-sm-4 col-form-label"><small>Middle Name</small></label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control form-control-sm" id="middle-name" name="middleName" />
                    </div>
                </div>
                <div class="mb-2 row">
                    <label for="suffix" class="col-sm-4 col-form-label"><small>Suffix</small></label>
                    <div class="col-sm-8">
                    <select class="form-control form-control-sm" id="suffix" name="suffix">
                        <option value="" selected="selected">None</option>
                        <option value="Sr.">SR.</option>
                        <option value="Jr.">JR.</option>
                        <option value="II">II</option>
                        <option value="III">III</option>
                        <option value="IV">IV</option>
                        <option value="V">V</option>
                        <option value="VI">VI</option>
                        <option value="VII">VII</option>
                    </select>
                    </div>
                </div>
                <div class="mb-2 row">
                    <label for="email" class="col-sm-4 col-form-label"><small>Email Address</small></label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control form-control-sm" id="email" name="email" required />
                    </div>
                </div>
                <div class="mb-2 row">
                    <label for="mobile" class="col-sm-4 col-form-label"><small>Mobile Number</small></label>
                    <div class="col-sm-8">
                    <input type="tel" pattern="[0-9]{11}" class="form-control form-control-sm" id="mobile" minlength="11" maxlength="11" name="mobile" placeholder="09xxxxxxxxx" required />
                    
                    </div>
                </div>
              
              <div class="mb-2">
                <fieldset class="captchaField">
                    <span id="SuccessMessage" class="success">The Captcha Is Correct!</span>
                    <input type="text" id="UserCaptchaCode" class="form-control form-control-sm" placeholder='Enter Captcha - Case Sensitive'>
                    <span id="WrongCaptchaError" class="error"></span>
                    <div class='CaptchaWrap'>
                        <div id="CaptchaImageCode" class="CaptchaTxtField">
                            <canvas id="CapCode" class="capcode" width="300" height="80"></canvas>
                        </div> 
                        
                    
                    </div>
                    <input type="button" class="btn btn-primary btn-sm btnSubmit" onclick="CheckCaptcha();" value="Submit">
                    <button type="button" class="btn btn-success btn-sm btnSubmit" onclick='CreateCaptcha();' title="Reload" >Reload</button>
                </fieldset>
              </div>
              <div class="d-grid">
                <button class="btn btn-primary" id='add' name='add' disabled type="submit">Register</button>
              </div>
            </form>
            <div>
              <p class="mb-0  text-left"> 
                Already have an account? <a href="<?php echo BASE_URL;?>" class="text-primary fw-bold">Login</a>
              </p>
              <p class="font-weight-light text-center" style="font-size: 14px; margin-top: 1em;">Version 2.0</p>
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
