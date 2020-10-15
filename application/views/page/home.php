<!DOCTYPE html>
<html lang="en">
<head>
  <title>Mangal Setu : Agrasen Samaj</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css');?>">
  
  <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/ms_fevicon.ico" type="image/x-icon">
  <link rel="icon" href="<?php echo base_url(); ?>assets/img/ms_fevicon.ico" type="image/x-icon">
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <style>
body{
	background-image: url('assets/img/background.jpg');
	font-family: Raleway;
	font-weight: 300;
	font-size: 18px;
    color: #555;
 }
.fakeimg {
    height: 200px;
    background: #ffa417;
    margin-top: 10px;
    color: #fff;
    font-weight: 500;
    padding: 10px 15px 2px;
}
.card{
	flex-direction: row !important;
}
.card-body {
    padding: 0.25rem !important;
}
  </style>
</head>
<body>
<div class="header_bar text-center" style="margin-bottom:0">
<nav class="container navbar navbar-expand-lg navbar-dark bg-none">
  <a class="navbar-brand" href="<?= base_url('Member');?>">Mangal Setu</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <!-- Links -->
	  <ul class="navbar-nav ml-auto">
		<li class="nav-item">
		  <a class="nav-link" href="<?= base_url('About')?>">About Us</a>
		</li>
		<?php
			$isLoggedIn = FALSE;
			if($this->session->has_userdata('member')){
				$member_data = $this->session->userdata ( 'member');
				$isLoggedIn	= $member_data['isLoggedIn'];
			}
			if (!isset ( $isLoggedIn ) || $isLoggedIn == TRUE) {
		?>
		<li class="nav-item">
        	<a class="nav-link" href="<?= base_url('Member/Member');?>">Dashboard</a>
		</li>
		<li class="nav-item">
        	<a class="nav-link" href="<?= base_url('Member/Profile');?>">Profile</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="<?= base_url('Member/Favourate');?>">Favourites</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="<?= base_url('Member/Logout');?>">Logout</a>
		</li>
		<?php }else{ ?>
		<li class="nav-item">
		  <a class="nav-link" href="<?= base_url('login')?>">Login</a>
		</li>
		<li class="nav-item">
		  <a class="nav-link" href="<?= base_url('registration')?>">Registration</a>
		</li>
		<?php } ?>
	  </ul>
  </div>
</nav>
<img src="assets/img/agrasen.png" class="banner_img img-responsive"/>
</div>
<?php if(!empty($announcement)){?>
<section>
  <div class="section" >
    <div class="anc text-center" role="alert">
	    <div class="main-text">
        <h3><?=date("d M Y", strtotime($announcement->date));?><sup><?=date("g a", strtotime($announcement->from_time));?> TO <?=date("g a", strtotime($announcement->to_time));?></sup></h3>
        <p><h2><?= $announcement->title;?></h2></p>      
        <hr>
		    <p>FIRST TIME IN INDIA</h3></p>
        <p class="mb-0"><a href="<?= base_url('Registration');?>">20-12-2020 को महासम्मेलन वैवहिक परिचे के लिये अभि रजिस्टर करे:-</a></p>
		  </div>
    </div>
  </div>
</section>
<?php } ?>
<div class="container" style="margin-top:30px">
     
  <div class="row">
    <div class="col-sm-8">
	<div class="heading"><h5>मंगल सेतु का अर्थ :</h5></div>
      <div class="fakeimg">
        
        <p>मंगल सेतु का अर्थ शुभ कार्य क पथ से है</p>
        <p>विवाह करना या करवाना एक शुभ कार्य है  अतः मंगल सेतु में यह कार्य विधमान है</p>
        <h5>The meaning of Mangal setu:</h5>
        <p>Mangal setu means the path of auspicious work.</p>
        <p>Getting married or getting it done is an auspicious task, so this work is present in Mangal setu.</p>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="embed-responsive embed-responsive-16by9">
        <iframe class="container-fluid embed-responsive-item" src="assets/vedio/intro.mp4" allowfullscreen></iframe>
      </div>
    </div>
  </div>
</div>
<div class="container"  style="margin-top:30px" >
<div class="row">
    <div class="col-sm-8">
<div class="  text-center">
  <h3>Population Of Agrawals in India</h3>
  <div class="table-responsive" >   
      <table class="table table-bordered" style="    background: #d4baba;">
    <thead>
      <tr >
        <th>STATE</th>
		<th>LK</th>
       <th>STATE</th>
		<th>LK</th>
		<th>STATE</th>
		<th>LK</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>J&K</td>
        <td>6</td>
        <td>Panjab</td>
		<td>9</td>
		<td>Hariyana</td>
		<td>14</td>
      </tr>
      <tr>
        <td>Rajsthan</td>
        <td>78</td>
        <td>Gujrat</td>
		<td>60</td>
			<td>Maharastra</td>
		<td>45</td>
      </tr>
      <tr >
        <td>Goa</td>
        <td>5</td>
        <td>Karnatka</td>
		<td>45</td>
		<td>Kerla</td>
		<td>12</td>
      </tr>
	    <tr >
        <td>Tamilnadu</td>
        <td>36</td>
        <td>Andhrapradesh</td>
		<td>24</td>
		<td>Chattisgrah</td>
		<td>24</td>
      </tr>
	      <tr >
        <td>Orrisa</td>
        <td>37</td>
        <td>Jharkhand</td>
		<td>12</td>
		<td>Bihar</td>
		<td>90</td>
      </tr>
	      <tr >
        <td>West Bangol</td>
        <td>18</td>
        <td>Madhypradesh</td>
		<td>42</td>
		<td>Uttar Pradesh</td>
		<td>200</td>
      </tr>
	      <tr >
        <td>Uttrakhand</td>
        <td>20</td>
        <td>Himachal</td>
		<td>45</td>
		<td>Sikkim</td>
		<td>1</td>
      </tr>
	      <tr >
        <td>Assam</td>
        <td>10</td>
        <td>Karnatka</td>
		<td>1.5</td>
		<td>Arunachal</td>
		<td>1</td>
      </tr>
	      <tr >
        <td>Nagland</td>
        <td>2</td>
        <td>Karnatka</td>
		<td>7</td>
		<td>Meghalay, Tripura</td>
		<td>11</td>
      </tr>
    </tbody>
  </table>
  </div>
		</div>
</div>
 	<div class="col-sm-4">
 		<div class="view_profile">
        	<h3>Recently Added Profiles</h3>
			<div class="scrolling-box">
				<?php foreach($new_members as $member){?>
				<div class="row mb-1" style="background: #fff;">
					<div class="col-sm-4">
					<img src="<?= base_url();?>assets/profile_img/<?=$member['image_1'];?>" onerror="this.src='<?= base_url();?>assets/profile_img/default_user.png'" alt="User Profile"
					style="width: 100%;border: 1px solid #c7c2be;" class="responsive rounded-circle"/>
					</div>
					<div class="col-sm-8 profile_item-desc pt-3">
						<h4>Name : <?=$member['firstname']." ".$member['lastname'];?></h4>
						<h5>City : <?=$member['city'];?></h5>
					</div>
				</div>
				<?php } ?>
        	</div>  
		</div>
 	</div>

</div></div>
<footer class="page-footer font-small">

  <!-- Copyright -->
  <div class="footer-copyright text-center py-3">© 2020 Copyright:
    <a href="#"> Mangal Setu</a>
  </div>
  <!-- Copyright -->

</footer>

</body>
</html>

</body>
</html>
