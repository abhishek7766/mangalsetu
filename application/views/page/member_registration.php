<!DOCTYPE html>
<html lang="en">
<head>
  <title><?=$title;?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href=<?php echo base_url('assets/css/style.css');?>>

  <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/ms_fevicon.ico" type="image/x-icon">
    <link rel="icon" href="<?php echo base_url(); ?>assets/img/ms_fevicon.ico" type="image/x-icon">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
        <div class="row main-wapper">
            <div class="col-md-6 d-none d-sm-none d-md-block leftside">
                <div class="overlay col-md-12"></div>
            </div>
            <div class="col-md-6 col-xs-12 rightside">
                <div class="col-md-12">
                    <p class="h4 mb-12 text-center">Mangalsetu Registration Form</p>
                    <hr class="accessory"></hr>
                </div>
                <form class="register_form" action="#" id="register_form" method="post">  
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <input type="text" class="form-control" name="firstname" id="firstname" aria-describedby="firstname" placeholder="Firstname">
                        </div>
                        <div class="form-group col-sm-6">
                            <input type="text" class="form-control" name="lastname" id="lastname" aria-describedby="firstname" placeholder="Lastname">
                        </div>
                        <div class="form-group col-sm-6">
                            <select class="form-control" name="gender" id="gender">
                                <option>Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <input placeholder="Select date" type="date" name="dob" id="example" class="form-control">
                            <i class="fas fa-calendar input-prefix" tabindex=0></i>
                        </div>
                        <div class="form-group col-sm-6">
                            <select class="form-control" name="state" id="state">    
                                <option value="">Select State</option>
                                <?php foreach ($states as $state) { ?>
                                <option value="<?php echo $state['id'] ?>"><?php echo $state['state']?> </option>
                                <?php } ?>
                            </select> 
                        </div>
                        <div class="form-group col-sm-6">
                            <select class="form-control" name="city" id="city" disabled>
                                <option>Select City</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon tag-addon">+91</span>
                            <input type="phone" id="phone" maxlength="10" name="phone" class="form-control" placeholder="Mobile Number" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="intrested_in" id="intrested_in">
                            <option>Intrested In..</option>
                            <option value="Male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <input type="checkbox" id="form_check" class="form-check-input" onclick="checkFunction()">
                        <label for="form_check" class="in">If Have any Refrence</label> 
                        <select class="form-control" style="display:none" name="refrenceid" id="refrenceid">
                            <option value="0">Select Refrence</option>
                            <?php foreach ($refrenceids as $refrenceid) { ?>
                            <option value="<?php echo $refrenceid['userid'] ?>"><?php echo $refrenceid['name'];?> </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <p class="alert_message" style="float:left;padding-top: 15px;" style="float:left"></p>
                        <p class="success_message" style="float:left;padding-top: 15px;" style="float:left"></p>
                        <img id="reg_loder" src="<?= base_url();?>assets/img/reg_loder.gif" style="float: right;display: none;">
                        <button type="button" id="submit_form" class="btn btn-info btn-block" style="float:right">Register</button>
                    </div>
                </form>
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

function checkFunction() {
  var checkBox = document.getElementById("form_check");
  var text = document.getElementById("refrenceid");
  if (checkBox.checked == true){
    text.style.display = "block";
  } else {
     text.style.display = "none";
  }
}
$(document).ready(function(){
 $('#state').change(function(){
  var state_id = $('#state').val();
  if(state_id != '')
  {
   $.ajax({
    url:"<?php echo base_url('registration'); ?>/get_cities",
    method:"POST",
    data:{state_id:state_id},
    success:function(data)
    {
        $('#city').prop('disabled', false);
        $('#city').html(data);
    }
   });
  }
  else
  {
    $('#city').html('<option value="">Select City</option>');
    $('#city').prop('disabled', true); 
  }
 });
 
});

$(function() {
    $("#submit_form").on('click', function(e) {
        e.preventDefault();
        $("#submit_form").hide();
        $("#reg_loder").show();

        var change_phone = $("#register_form");
        var text = document.getElementById("refrenceid");

        $.ajax({
            url: '<?php echo base_url('Registration/CreatNewMember');?>',
            type: 'post',
            data: change_phone.serialize(),
            success: function(response){
                //console.log(response);
                if(response.status == 'success') {
                    $("#reg_loder").hide();
                    $("#submit_form").show(); 
                    $("#register_form")[0].reset();
                    text.style.display = "none";
                    $(".success_message").html(response.message);
                    setTimeout(function(){
                        $(".success_message").html("");
                    }, 10000);
                }else{
                    $("#reg_loder").hide();
                    $("#submit_form").show();
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
