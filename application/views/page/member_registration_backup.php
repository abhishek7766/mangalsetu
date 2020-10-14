<style>
sup{
    color:red;
}    
</style>
<div class="container">
    <form action="<?php echo base_url('Registration/CreatNewMember');?>" id="register_form" method="post">               
        <div class="row">
            <div class="col-md-6 offset-md-3 abc">
                <div class="col-md-12">
                    <p class="h4 mb-12 text-center">Mangalsetu Registration Form</p>
                    <hr class="reg_hr"></hr>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label for="firstname" class="in">Firstname<sup>*</sup></label> 
                        <input type="text" id="firstname" name="firstname" class="form-control" required>
                    </div>
                    <div class="col">
                        <label for="Lastname" class="in">Lastname<sup>*</sup></label> 
                        <input type="text" id="lastname" name="lastname" class="form-control" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <!-- email --> 
                        <label for="Email" class="in">Email<sup>*</sup></label> 
                        <input type="email" id="email" name="email" class="form-control " required>
                    </div>
                    <div class="col">
                        <label for="state">State<sup>*</sup></label>
                        <select class="form-control" name="state" id="state">
                        <option value="">Select State</option>
                        <?php foreach ($states as $state) { ?>
                        <option value="<?php echo $state['id'] ?>"><?php echo $state['state']?> </option>
                        <?php } ?>
                        </select>
                    </div>
                    <div class="col">
                        <label for="city">City<sup>*</sup></label>
                        <select class="form-control" name="city" id="city" disabled>
                            <option>Select City</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label for="intrested_in">Intrested In<sup>*</sup></label>
                        <select class="form-control" name="intrested_in" id="intrested_in">
                        <option>Select</option>
                        <option value="Male">Male</option>
                        <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="col">
                         <!-- Mobile --> 
                        <label for="phone" class="in">Mobile<sup>*</sup></label> 
                        <input type="phone" id="phone" name="phone" class="form-control mb-4" required>
                    </div>
                    <div class="col">
                        <!-- Password --> 
                        <label for="password" class="in">Password<sup>*</sup></label> 
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <div id="date-picker-example" class="md-form md-outline input-with-post-icon datepicker">
                            <label for="example">Date Of Birth<sup>*</sup></label>
                            <input placeholder="Select date" type="date" name="dob" id="example" class="form-control">
                            <i class="fas fa-calendar input-prefix" tabindex=0></i>
                        </div>
                    </div>
                    <div class="col">
                        <label for="gender">Gender<sup>*</sup></label>
                        <select class="form-control" name="gender" id="gender">
                        <option>Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="female">Female</option>
                        </select>
                    </div>
                </div>
                <hr></hr>
                <div class="form-row">
                    <div class="col">
                        <input type="checkbox" id="form_check" class="form-check-input" onclick="checkFunction()">
                        <label for="form_check" class="in">If Have any Refrence</label> 
                    </div>
                    <div class="col" id="check_refrence" style="display:none">
                        <select class="form-control" name="refrenceid" id="refrenceid">
                        <option value="0">Select Refrence</option>
                        <?php foreach ($refrenceids as $refrenceid) { ?>
                        <option value="<?php echo $refrenceid['userid'] ?>"><?php echo $refrenceid['name'];?> </option>
                        <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-12 text-center">
                    <p class="alert alert-danger" id="error">Email or Password doesnot match!</p>
                </div>
                <div class="col-md-12 register_submit">
                    <!-- Sign in button --> 
                    <button class="btn btn-info btn-block" type="submit" >Register</button>
                </div>   
            </div>
        </div>
    </form>
</div>
<script>
function checkFunction() {
  var checkBox = document.getElementById("form_check");
  var text = document.getElementById("check_refrence");
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
</script>