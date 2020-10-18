<div class="container" style="margin-top:30px">
     
  <div class="row   ">
    <div class="col-md-12">
      <div class="heading" style="height: 50px !important;">
        <h5 class="pull-left">User Details</h5>
      </div>
      <div class="profileimg">
        
      <form id="editProfile" action="" method="POST">
        
        <div class="row">
            <div class="col-md-4">
              <label for="weight" class="in">Weight :</label> 
              <input type="text" id="weight" name="weight" class="form-control " value="<?php echo $member_details->weight;?>">
            </div>
            <div class="col-md-4">
              <label for="color" class="in">Color :</label> 
              <input type="text" id="color" name="color" class="form-control " value="<?php echo $member_details->color;?>">
            </div>
            <div class="col-md-4">
              <label for="currentplace" class="in">Current Place :</label> 
              <input type="text" id="currentplace" name="currentplace" class="form-control " value="<?php echo $member_details->currentplace;?>">
            </div>          
        </div>
        <div class="row">
            <div class="col-md-4">
              <label for="address" class="in">Full Address:</label> 
              <textarea type="textarea" style="resize: none;" id="address" name="address" class="form-control " value="<?php echo $member_details->address;?>"></textarea>
            </div>
            <div class="col-md-4">
              <label for="zip_code" class="in">Zip Code:</label> 
              <input type="text" id="zip_code" name="zip_code" class="form-control " value="<?php echo $member_details->zip_code;?>">
            </div>
            <div class="col-md-4">
              <label for="fathername" class="in">Father Name :</label> 
              <input type="text" id="fathername" name="fathername" class="form-control " value="<?php echo $member_details->fathername;?>">
            </div>          
        </div>
        <div class="row">
            <div class="col-md-4">
              <label for="father_occupation" class="in">Father's Occupation:</label> 
              <input type="text" id="father_occupation" name="father_occupation" class="form-control " value="<?php echo $member_details->father_occupation;?>">
            </div>
            <div class="col-md-4">
              <label for="mothername" class="in">Mother Name :</label> 
              <input type="text" id="mothername" name="mothername" class="form-control " value="<?php echo $member_details->mothername;?>">
            </div>
            <div class="col-md-4">
              <label for="mother_occupation" class="in">Mother's Occupation :</label> 
              <input type="text" id="mother_occupation" name="mother_occupation" class="form-control " value="<?php echo $member_details->mother_occupation;?>">
            </div>          
        </div>
        <div class="row">
            <div class="col-md-4">
              <label for="gotra" class="in">Gotra :</label> 
              <input type="text" id="gotra" name="gotra" class="form-control " value="<?php echo $member_details->gotra;?>">
            </div>
            <div class="col-md-4">
              <label for="no_of_sisters" class="in">No. of Sister :</label> 
              <input type="text" id="no_of_sisters" name="no_of_sisters" class="form-control " value="<?php echo $member_details->no_of_sisters;?>">
            </div>
            <div class="col-md-4">
              <label for="no_of_married_sisters" class="in">No. of Married :</label> 
              <input type="text" id="no_of_married_sisters" name="no_of_married_sisters" class="form-control " value="<?php echo $member_details->no_of_married_sisters;?>">
            </div>          
        </div>
        <div class="row">
            <div class="col-md-4">
              <label for="no_of_brothers" class="in">No. of Brother :</label> 
              <input type="text" id="no_of_brothers" name="no_of_brothers" class="form-control " value="<?php echo $member_details->no_of_brothers;?>">
            </div>
            <div class="col-md-4">
              <label for="no_of_married_brothers" class="in">No. of Married :</label> 
              <input type="text" id="no_of_married_brothers" name="no_of_married_brothers" class="form-control " value="<?php echo $member_details->no_of_married_brothers;?>">
            </div>
            <div class="col-md-4">
              <label for="age" class="in">Age :</label> 
              <input type="text" id="age" name="age" class="form-control " value="<?php echo $member_details->age;?>">
            </div>          
        </div>
        <div class="row">
            <div class="col-md-4">
              <label for="hobbies" class="in">Hobbies :</label> 
              <input type="text" id="hobbies" name="hobbies" class="form-control " value="<?php echo $member_details->hobbies;?>">
            </div>
            <div class="col-md-4">
              <label for="family" class="in">Family Type :</label> 
              <select name="family" id="family" class="form-control ">
                <option>Select</option>
                <option value="Nuclear"<?php if($member_details->family == "Nuclear"){echo "Selected";}?>>Nuclear</option>
                <option value="Joint" <?php if($member_details->family == "Joint"){ echo "Selected";}?>>Joint</option>
              </select>
            </div>
            <div class="col-md-4">
              <label for="language" class="in">Mother Tung :</label> 
              <input type="text" id="language" name="language" class="form-control " value="<?php echo $member_details->language;?>">
            </div>          
        </div>
        <div class="row">
            <div class="col-md-4">
              <label for="occupation" class="in">Occupation of Groom/Bride :</label> 
              <input type="text" id="occupation" name="occupation" class="form-control " value="<?php echo $member_details->occupation;?>">
            </div>
            <div class="col-md-4">
              <label for="horoscope" class="in">Horoscope :</label> 
              <input type="text" id="horoscope" name="horoscope" class="form-control " value="<?php echo $member_details->horoscope;?>">
            </div>
            <div class="col-md-4">
              <label for="birth_place" class="in">Place of Birth :</label> 
              <input type="text" id="birth_place" name="birth_place" class="form-control " value="<?php echo $member_details->birth_place;?>">
            </div>          
        </div>
        <div class="row">
            <div class="col-md-4">
              <label for="nakshatra" class="in">Rashi Nakshatra :</label> 
              <input type="text" id="nakshatra" name="nakshatra" class="form-control " value="<?php echo $member_details->nakshatra;?>">
            </div>
            <div class="col-md-4">
              <label for="bith_time" class="in">Birth Time :</label> 
              <input type="time" id="bith_time" name="bith_time" class="form-control " value="<?php echo $member_details->bith_time;?>">
            </div>
            <div class="col-md-4">
              <label for="address" class="in">Short Bio:</label> 
              <textarea type="textarea" style="resize: none;" id="address" name="short_bio" class="form-control " value="<?php echo $member_details->short_bio;?>"></textarea>
            </div>          
        </div>
        <div class="row">
          <div class="col-md-8">
            <p class="alert_message" style="float:left;padding-top: 15px;" style="float:left"></p>
            <p class="success_message" style="float:left;padding-top: 15px;" style="float:left"></p>
          </div>
          <div class="col-md-4 form-inline">
            <button class="btn btn-info btn-block" type="button" id="submit_edit">Save</button>
            <a href="<?= base_url('Payment');?>" class="btn btn-success btn-block">Proceed To Payment</a>
          </div>
        </div>
      </form>  
      </div>



      <div class="row">
        <div class="col-md-12">
          <div class="heading" style="height: 50px !important;">
            <h5 class="pull-left">User Profile Images</h5>
          </div>
          <div class="profileimg">
            <div class="row">
              <div class="col-md-4">
                <div class="thumbnail">
                  <img src="<?= base_url();?>assets/profile_img/<?=$member_details->image_2;?>" onerror="this.src='<?= base_url();?>assets/profile_img/default_user.png'" alt="User Profile" style="width:100%"/>
                  <div class="caption">
                  <form class="uploadForm" action="" method="post">
                    <label>Upload Image File:</label><br/>
                    <input type="hidden" name="type" value="image_2">
                    <input name="image" type="file" class="form-control-file" accept="image/*" />
                    <input type="submit" value="Upload" class="btn btn-success" />
                  </form>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="thumbnail">
                  <img src="<?= base_url();?>assets/profile_img/<?=$member_details->image_3;?>" onerror="this.src='<?= base_url();?>assets/profile_img/default_user.png'" alt="User Profile" style="width:100%"/>
                    <div class="caption">
                    <form class="uploadForm" action="" method="post">
                      <label>Upload Image File:</label><br/>
                      <input type="hidden" name="type" value="image_3">
                      <input name="image" type="file" class="form-control-file" accept="image/*" />
                      <input type="submit" value="Upload" class="btn btn-success" />
                    </form>
                    </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="thumbnail">
                    <img src="<?= base_url();?>assets/profile_img/<?=$member_details->image_4;?>" onerror="this.src='<?= base_url();?>assets/profile_img/default_user.png'" alt="User Profile" style="width:100%"/>
                    <div class="caption">
                    <form class="uploadForm" action="" method="post">
                      <label>Upload Image File:</label><br/>
                      <input type="hidden" name="type" value="image_4">
                      <input name="image" type="file" class="form-control-file" accept="image/*" />
                      <input type="submit" value="Upload" class="btn btn-success" />
                    </form>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
$(function() {
    $("#submit_edit").on('click', function(e) {
        e.preventDefault();
        
        var saveEdit = $("#editProfile");

        $.ajax({
            url: '<?php echo base_url('Member/saveEdit');?>',
            type: 'post',
            data: saveEdit.serialize(),
            success: function(response){
                //console.log(response);
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
    });
});

$(function (e){
    $(".uploadForm").on('submit',(function(e){
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
                      location.reload();
                    }else{
                      location.reload();
                    }
                }	        
            });
    }));
});
</script>