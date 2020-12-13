<?php
$member_details->email = "XXXXXX@XXX.com";
$member_details->phone = "+91-XXXXXXXXXX";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $title;?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta property="og:image" content="<?= base_url();?>assets/profile_img/<?=$member_details->image_1;?>" />
  <meta property="og:title" content="<?php echo $member_details->firstname." ".$member_details->lastname;?>" />
  <meta property="og:image:secure_url" content="<?= base_url();?>assets/profile_img/<?=$member_details->image_1;?>" />
  <meta property="og:image:type" content="image/jpeg" />
  <meta property="og:image:width" content="400" />
  <meta property="og:image:height" content="400" />
  <meta property="og:description" content="Mangalsetu - A Matrimony for Agarawal Community" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href=<?php echo base_url('assets/css/style.css');?>>
  <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/ms_fevicon.ico" type="image/x-icon">
  <link rel="icon" href="<?php echo base_url(); ?>assets/img/ms_fevicon.ico" type="image/x-icon">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
  <div class="header">
  <nav class="container navbar navbar-expand-lg navbar-dark bg-none">
    <a class="navbar-brand" style="font-family: sans-serif;font-weight: 900;" href="<?= base_url();?>">Mangal Setu</a>
  </nav>
  </div>
  <style>
.myImg {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

.myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  padding-top:50px;
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.modal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 500px;
}

/* Caption of Modal Image */
#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation */
.modal-content, #caption {  
  -webkit-animation-name: zoom;
  -webkit-animation-duration: 0.6s;
  animation-name: zoom;
  animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
  from {-webkit-transform:scale(0)} 
  to {-webkit-transform:scale(1)}
}

@keyframes zoom {
  from {transform:scale(0)} 
  to {transform:scale(1)}
}

/* The Close Button */
.close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .modal-content {
    width: 100%;
  }
}
</style>
<div class="container mt-5">
  <div class="row">
    <div class="col-md-4">         
        <div class="login_box text-center">
        <div class="image-circle profile-pic">
          <img style="height: inherit;" src="<?= base_url();?>assets/profile_img/<?=$member_details->image_1;?>" onerror="this.src='<?= base_url();?>assets/profile_img/default_user.png'" alt="User Profile"/>
        </div>
          <div class="line">
              <h3>
                  <?php echo $member_details->firstname." ".$member_details->lastname;
                      if($member_details->isPrime == 1){
                  ?>
                  <svg style="color: #00940b;" width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-award-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path d="M8 0l1.669.864 1.858.282.842 1.68 1.337 1.32L13.4 6l.306 1.854-1.337 1.32-.842 1.68-1.858.282L8 12l-1.669-.864-1.858-.282-.842-1.68-1.337-1.32L2.6 6l-.306-1.854 1.337-1.32.842-1.68L6.331.864 8 0z"/>
                  <path d="M4 11.794V16l4-1 4 1v-4.206l-2.018.306L8 13.126 6.018 12.1 4 11.794z"/>
                  </svg>
                      <?php }?>
              </h3>
          </div>
          <div class="row">
              <label class="col-sm-12 col-form-label">Email : <?=$member_details->email;?></label>
              <label class="col-sm-12 col-form-label">Mobile : <?=$member_details->phone;?></label>
          </div>
        </div>
    </div>
	 
	
	 
    <div class="col-md-8">
      <div class="heading" style="height: 50px !important;">
        <h5 class="pull-left">User Details</h5>
      </div>
      <div class="profileimg">	
       <div class="row">
          <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">Name :</label>
              <div class="col-xs-7 controls"><?php echo $member_details->firstname." ".$member_details->lastname;?></div>
              <!-- col-sm-10 --> 
            </div>
          </div>
          <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">Age :</label>
              <div class="col-xs-7 controls"><?=($member_details->age == 0)?"--":$member_details->age;?></div>
              <!-- col-sm-10 --> 
            </div>
          </div>
          <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">Weight:</label>
              <div class="col-xs-7 controls"><?=($member_details->weight == 0)?"--":$member_details->weight;?></div>
              <!-- col-sm-10 --> 
            </div>
          </div>
          <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">Color:</label>
              <div class="col-xs-7 controls"><?=($member_details->color =="")?"--":$member_details->color;?></div>
              <!-- col-sm-10 --> 
            </div>
          </div>
          <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">Current Place:</label>
              <div class="col-xs-7 controls"><?=($member_details->currentplace =="")?"--":$member_details->currentplace;?></div>
              <!-- col-sm-10 --> 
            </div>
          </div>
          <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">Full Address:</label>
              <div class="col-xs-7 controls"><?=($member_details->address =="")?"--":$member_details->address;?></div>
              <!-- col-sm-10 --> 
            </div>
          </div>
          <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">Zip Code:</label>
              <div class="col-xs-7 controls"><?=($member_details->zip_code ==0)?"--":$member_details->zip_code;?></div>
              <!-- col-sm-10 --> 
            </div>
          </div>
          <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">Mobile No. :</label>
              <div class="col-xs-7 controls"><?= $member_details->phone;?></div>
              <!-- col-sm-10 --> 
            </div>
          </div>
          <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">Father Name :</label>
              <div class="col-xs-7 controls"><?=($member_details->fathername =="")?"--":$member_details->fathername;?></div>
              <!-- col-sm-10 --> 
            </div>
          </div>
		     <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">Father's Occupation :</label>
              <div class="col-xs-7 controls"><?=($member_details->father_occupation =="")?"--":$member_details->father_occupation;?></div>
              <!-- col-sm-10 --> 
            </div>
          </div>
          <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">Mother Name :</label>
              <div class="col-xs-7 controls"><?=($member_details->mothername =="")?"--":$member_details->mothername;?></div>
              <!-- col-sm-10 --> 
            </div>
          </div>
		    <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">Mother's Occupation :</label>
              <div class="col-xs-7 controls"><?=($member_details->mother_occupation =="")?"--":$member_details->mother_occupation;?></div>
              <!-- col-sm-10 --> 
            </div>
          </div>
		    <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">Gotra :</label>
              <div class="col-xs-7 controls"><?=($member_details->gotra =="")?"--":$member_details->gotra;?></div>
              <!-- col-sm-10 --> 
            </div>
        </div>
		     <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">No. of Sister :</label>
              <div class="col-xs-7 controls"><?=($member_details->no_of_sisters ==0)?"--":$member_details->no_of_sisters;?></div>
              <!-- col-sm-10 --> 
            </div>
          </div>
		     <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">No. of Married :</label>
              <div class="col-xs-7 controls"><?=($member_details->no_of_married_sisters ==0)?"--":$member_details->no_of_married_sisters;?></div>
              <!-- col-sm-10 --> 
            </div>
          </div>
		     <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">No. of Brother :</label>
              <div class="col-xs-7 controls"><?=($member_details->no_of_brothers ==0)?"--":$member_details->no_of_brothers;?></div>
              <!-- col-sm-10 --> 
            </div>
          </div>
		     <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">No. of Married :</label>
              <div class="col-xs-7 controls"><?=($member_details->no_of_married_brothers ==0)?"--":$member_details->no_of_married_brothers;?></div>
              <!-- col-sm-10 --> 
            </div>
          </div>
		     <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">Email :</label>
              <div class="col-xs-7 controls"><?=($member_details->email =="")?"--":$member_details->email;?></div>
              <!-- col-sm-10 --> 
            </div>
          </div>
		     <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">Hobbies :</label>
              <div class="col-xs-7 controls"><?=($member_details->hobbies =="")?"--":$member_details->hobbies;?></div>
              <!-- col-sm-10 --> 
            </div>
          </div>
		     <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">Family Type :</label>
              <div class="col-xs-7 controls"><?=($member_details->family =="")?"--":$member_details->family;?></div>
              <!-- col-sm-10 --> 
            </div>
          </div>
		     <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">Mother Tung :</label>
              <div class="col-xs-7 controls"><?=($member_details->language =="")?"--":$member_details->language;?></div>
              <!-- col-sm-10 --> 
            </div>
          </div>
		     <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">Occupation of Groom/Bride :</label>
              <div class="col-xs-7 controls"><?=($member_details->occupation =="")?"--":$member_details->occupation;?></div>
              <!-- col-sm-10 --> 
            </div>
          </div>
		     <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">Horoscope :</label>
              <div class="col-xs-7 controls"><?=($member_details->horoscope =="")?"--":$member_details->horoscope;?></div>
              <!-- col-sm-10 --> 
            </div>
          </div>
		     <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">Place of Birth :</label>
              <div class="col-xs-7 controls"><?=($member_details->birth_place =="")?"--":$member_details->birth_place;?></div>
              <!-- col-sm-10 --> 
            </div>
          </div>
		     <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">Rashi Nakshatra :</label>
              <div class="col-xs-7 controls"><?=($member_details->nakshatra =="")?"--":$member_details->nakshatra;?></div>
              <!-- col-sm-10 --> 
            </div>
          </div>
		     <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">DOB :</label>
              <div class="col-xs-7 controls"><?=($member_details->dob =="")?"--":$member_details->dob;?></div>
              <!-- col-sm-10 --> 
            </div>
          </div>
		      <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">Birth Time :</label>
              <div class="col-xs-7 controls"><?=($member_details->bith_time =="00:00:00")?"--":$member_details->bith_time;?></div>
              <!-- col-sm-10 --> 
            </div>
          </div>
          <div class="col-sm-6">
            <div class="row mgbt-xs-0">
              <label class="col-xs-5 control-label">Education :</label>
              <div class="col-xs-7 controls"><?=($member_details->education =="")?"--":$member_details->education;?></div>
              <!-- col-sm-10 --> 
            </div>
          </div>
          <div class="col-sm-6">
              <div class="row mgbt-xs-0">
                <label class="col-xs-5 control-label">CTC (in Lakhs/annum) :</label>
                <div class="col-xs-7 controls"><?=($member_details->ctc =="")?"--":$member_details->ctc;?></div>
                <!-- col-sm-10 --> 
              </div>
          </div>
          <div class="col-sm-6">
              <div class="row mgbt-xs-0">
                <label class="col-xs-5 control-label">Height (in cm) :</label>
                <div class="col-xs-7 controls"><?=($member_details->height =="")?"--":$member_details->height;?></div>
                <!-- col-sm-10 --> 
              </div>
          </div>
        </div>
      </div>
      <?php if($member_details->short_bio != ""){?>
      <div class="profileimg">
        <h4>Short Bio :</h4>
        <span><?=$member_details->short_bio;?></span>
      </div>
      <?php }?>

      <div class="heading" style="height: 50px !important;">
        <h5 class="pull-left">User Profiles</h5>
      </div>
      <div class="profileimg">
          <div class="row">
            <div class="col-md-3">
              <img onclick="showModel(this)" src="<?= base_url();?>assets/profile_img/<?=$member_details->image_1;?>" onerror="this.src='<?= base_url();?>assets/profile_img/default_user.png'" alt="User Profile" class="img-thumbnail profile-pic myImg"/>
            </div>
            <div class="col-md-3">
              <img onclick="showModel(this)" src="<?= base_url();?>assets/profile_img/<?=$member_details->image_2;?>" onerror="this.src='<?= base_url();?>assets/profile_img/default_user.png'" alt="User Profile" class="img-thumbnail profile-pic myImg"/>
            </div>
            <div class="col-md-3">
              <img onclick="showModel(this)"src="<?= base_url();?>assets/profile_img/<?=$member_details->image_3;?>" onerror="this.src='<?= base_url();?>assets/profile_img/default_user.png'" alt="User Profile" class="img-thumbnail profile-pic myImg"/>
            </div>
            <div class="col-md-3">
              <img onclick="showModel(this)" src="<?= base_url();?>assets/profile_img/<?=$member_details->image_4;?>" onerror="this.src='<?= base_url();?>assets/profile_img/default_user.png'" alt="User Profile" class="img-thumbnail profile-pic myImg"/>
            </div>
          </div>
          <div id="myModal" class="modal">
            <span class="close">&times;</span>
            <img class="modal-content" id="img01">
            <div id="caption"></div>
          </div>
      </div>


    </div>
   
  </div>
</div>
<script>
var modal = document.getElementById("myModal");
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");

function showModel(e){
  modal.style.display = "block";
  modalImg.src = e.src;
  captionText.innerHTML = this.alt;
}
//class profile-pic


// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
  modal.style.display = "none";
}

$(document).ready(function() {    
    var readURL = function(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('.profile-pic').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
  }

  $(".file-upload").on('change', function(){
      readURL(this);
      $("#image_submit").show();
  });

  $(".upload-button").on('click', function() {
    $(".file-upload").click();            
  });

  $("#profile_form").on('submit',(function(e){
        e.preventDefault();
        $.ajax({
                url: "<?= base_url('Member/do_upload');?>",
                type: "POST",
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function(response){
                    if(response.status == 'success') {
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
    }));
});
</script>