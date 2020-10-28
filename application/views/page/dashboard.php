<div class="container mt-5">
    
<?php if($member_details->payment_status != 1){ ?>
        <div class="alert alert-danger text-center" role="alert">
            You are not a Prime Member. Please <a href="<?= base_url('Payment');?>">Proceed To Payment</a> to become a Prime Member or Contact to customer Support.
        </div>    
    <?php }?>
    
    <div class="row">

        <div class="col-md-4 d-none d-sm-none d-md-block">
            <div class="login_box text-center">
            <img src="<?= base_url();?>assets/profile_img/<?=$member_details->image_1;?>" onerror="this.src='<?= base_url();?>assets/profile_img/default_user.png'" alt="User Profile" class="image-circle"/>
            
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

            <strong aling="left">Profile :</strong>
            <div class="progress">
                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="<?=$profile_percent;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$profile_percent;?>%"></div>
            </div>
            <div class="row">
                <label class="col-sm-12 col-form-label">Email : <?=$member_details->email;?></label>
                <label class="col-sm-12 col-form-label">Mobile : <?=$member_details->phone;?></label>
            </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-8">
            <div class="heading">
                <div class="row">
                    <div class="col-md-7">
                        <h5>Matching Profiles</h5>
                    </div>
                    <div class="col-md-5">
                        <form class="form-inline" action="<?php echo base_url() ?>Member" method="POST" id="searchList">
                            <input type="text" class="form-control" value="<?php echo $searchText; ?>" id="searchText" name="searchText" placeholder="Seach by Firstname / City" style="width: 60%;height: 25px;">
                            <button type="submit" class="btn btn-success" style="width: 70px;margin-left: 5px;height: 25px;padding: 0;">Search</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <?php 
            //echo "<prE>";print_r($listing);die;
            if(!empty($listing)){
                foreach($listing as $list){?>
            <div class="profileimg">
        		<div class="row">
                    <div class="col-md-4 text-center">
                    <?php
                        if(!empty($list['image_1'])){
                        $img_url = $list['image_1'];
                        }else{
                        $img_url = 'default_user.png';
                        }
                    ?>
                        <div class="recentaddlist" style="background-image: url('<?= base_url();?>assets/profile_img/<?=$img_url;?>');background-size: cover;">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="panel-heading">
                            <h3><?=$list['firstname']." ".$list['lastname'];?><span style="font-size: 18px;" class="pt-2 text-right pull-right">City : <?=$list['city'];?>&nbsp;&nbsp;<i id="favourate" data-memberid=<?=$list['member_id'];?>  class="fa <?php echo ($list['favourate'])?'fa-heart' : 'fa-heart-o';?> favourate" aria-hidden="true"></i></span></h3>
                        </div>
                        <table class="table table-borderless" style="color: #fff;">
                            <tbody>
                                <tr>
                                <td>Age :</td>
                                <td><?php echo ($list['age'] != 0)?$list['age']:"-";?></td>
                                <td>Education :</td>
                                <td><?php echo ($list['education'] != "")?$list['education']:"-";?></td>
                                </tr>
                                <tr>
                                <td>Occupation :</td>
                                <td><?php echo ($list['occupation'] != "")?$list['occupation']:"-";?></td>
                                <td>CTC (Lakhs/annum) :</td>
                                <td><?php echo ($list['ctc'] != 0)?$list['ctc']:"-";?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php }
            }else{ ?>
                <div class="alert alert-danger text-center" role="alert">
                    You dont have any match.
                </div>  
            <?php } ?>
        </div>
    </div>

</div>
<script>
/**
 * @author Kishor Mali
 */


jQuery(document).ready(function(){

	jQuery(document).on("click", "#favourate", function(){
		var memberid = $(this).data("memberid"),
			hitURL = "<?php echo base_url('Member/addFavourate');?>",
			currentRow = $(this);
		
		var confirmation = confirm("Are Sure to add this profile to your Favourities");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { memberid : memberid } 
			}).done(function(data){
				if(data.status) {
                    currentRow.removeClass('fa-heart-o'); 
                    currentRow.addClass('fa-heart'); 
                    alert("Profile added successfully"); 
                }
				else {
                    currentRow.removeClass('fa-heart'); 
                    currentRow.addClass('fa-heart-o'); 
                    alert("Profile removed successfully"); 
                }
			});
		}
	});
	
});
    
</script>