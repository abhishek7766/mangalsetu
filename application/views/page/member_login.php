<!DOCTYPE html>
<html lang="en">
<head>
  <title><?=$title;?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/style.css">

  <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/ms_fevicon.ico" type="image/x-icon">
<link rel="icon" href="<?php echo base_url(); ?>assets/img/ms_fevicon.ico" type="image/x-icon">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<style>
    body{
            background-image: url(assets/img/login_bg.jpg);
            font-family: Raleway;
            font-weight: 300;
            font-size: 18px;
            color: #555;
            background-repeat: no-repeat;
            background-size: cover;
        }
     .row {
     margin-top: 5%;
     margin-left: 2%;
     margin-right: 2%
 }

 .page {
     margin-top: 0%
 }

 .btn {
     border-radius: 25px;
     margin-top: 2%;
     margin-bottom: 2%;
 }

 .sign {
     border-radius: 25px;
     width: 25%;
     margin: auto
 }

 form {
     padding: 0;
     margin-left: 10%;
     margin-right:10%
 }

 .abc {
     background-color: #ffc48b;
     padding: 2%;
     border-radius: 1%;
     opacity: 0.8;
     text-align: center !important;
 }

 .xyz {
     background-color: gray;
     padding: 2%
 }

 .form-control {
     border-radius: 25px
 }

 .fa {
     color: white;
     margin-top: 5%
 }

 .in {
     color: #495057;
 }

 .in2 {
     color: #495057;
     margin-right: auto
 }

 .my {
     background-color: #bcc2be;
     border: none
 }

 .custom-control {
     margin-bottom: 2%
 }

 h2.account-text {
     color: #fff !important;
     font-weight: 200
 }

 .account-description {
     color: #fff;
     margin-bottom: 4%;
     font-weight: 200
 }

 @media only screen and (max-width:1200){
     body{
        background-size: auto !important;
     }
 }
 @media only screen and (max-height:1200){
     body{
        background-size: auto !important;
     }
 }
 @media only screen and (max-width: 600px) {
     row {
         margin-top: 5%;
         margin-left: 1%;
         margin-right: 1%
     }
     body{
        background-size: auto !important;
     }
 }
</style>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4">
                <div class="abc">
                <a href="<?= base_url();?>"><i class="fa fa-home" aria-hidden="true"></i> Back to Home</a>
                <form id="login_form" action="" method="POST">
                    <p class="h4">Login to continue</p>
                    <hr></hr>
                    <!-- Email --> 
                    <label for="phone" class="in">Mobile Number</label> 
                    <input type="text" id="phone" name="phone" class="form-control " maxlength="10" placeholder="Enter Mobile Number"> 
                    <!-- otp -->
                    <div id="otp_block" style="display: none;"> 
                        <label for="otp" class="in">OTP</label> 
                        <input type="text" id="otp" name="otp" class="form-control" maxlength="4" placeholder="Enter OTP">
                    </div>

                    <div class="d-flex justify-content-left">
                        <!-- Remember me -->
                        <div class="custom-control text-left">
                        <span class="form-text small alert_message"></span>
                        <span class="form-text small success_message"></span>
                        </div>
                    </div> 
                    <!-- Sign in button --> 
                    <button class="btn btn-info btn-block" type="button" id="send_otp" >SENT OTP</button>
                    <button class="btn btn-info btn-block" style="display: none;" type="button" id="login_btn" >LOGIN</button>
                </form>
                <a href="<?= base_url('Registration');?>">Not a Member Yet?</a>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    function setInputFilter(textbox, inputFilter) {
    ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
        textbox.addEventListener(event, function() {
        if (inputFilter(this.value)) {
            this.oldValue = this.value;
            this.oldSelectionStart = this.selectionStart;
            this.oldSelectionEnd = this.selectionEnd;
        } else if (this.hasOwnProperty("oldValue")) {
            this.value = this.oldValue;
            this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
        } else {
            this.value = "";
        }
        });
    });
    }
    setInputFilter(document.getElementById("phone"), function(value) {
    return /^-?\d*$/.test(value); });

    $(function() {
        $("#send_otp").on('click', function(e) {
            e.preventDefault();

            var change_phone = $("#login_form");

            $.ajax({
                url: '<?= base_url('Login/member_login');?>',
                type: 'post',
                data: change_phone.serialize(),
                success: function(response){
                    if(response.status == 'success') {
                        $("#phone").prop('disabled', true);
                        $('#otp_block').show();
                        $('#send_otp').hide();
                        $('#login_btn').show();
                        $(".success_message").html(response.message);
                        setTimeout(function(){ 
                            $(".success_message").html("");
                        }, 5000);
                    }else{
                        $(".alert_message").html(response.message);
                        setTimeout(function(){ 
                            $(".alert_message").html("");
                        }, 5000);
                    }
                }
            });
        });
    });

    $(function() {
        $("#login_btn").on('click', function(e) {
            e.preventDefault();

            
            var phone= $('#phone').val();
            var otp = $('#otp').val();

            $.ajax({
                url: '<?= base_url('Login/verify_otp');?>',
                type: 'post',
                data: {phone : phone,otp : otp},
                success: function(response){
                    if(response.status == 'success') {
                        window.location.href = "<?php echo base_url('Member'); ?>"
                    }else{
                        $(".alert_message").html(response.message);
                        setTimeout(function(){ 
                            $(".alert_message").html("");
                        }, 5000);
                    }
                }
            });
        });
    });
</script>
</html>
