<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $title;?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css');?>">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  
  <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/ms_fevicon.ico" type="image/x-icon">
    <link rel="icon" href="<?php echo base_url(); ?>assets/img/ms_fevicon.ico" type="image/x-icon">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  
</head>
<body>
  <div class="header">
  <nav class="container navbar navbar-expand-lg navbar-dark bg-none">
    <a class="navbar-brand" href="<?= base_url('Member');?>">Mangal Setu</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Links -->
      <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="<?= base_url('Member');?>">Dashboard</a>
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
      </ul>
    </div>
  </nav>
  </div>
