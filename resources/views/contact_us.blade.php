<!DOCTYPE html>
<html lang="en">
<head>
  <title>Rummy Boss</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <link rel="shortcut icon" type="image/png" href="assets/img/Rummy Boss Logo.png">

<link rel="stylesheet" type="text/css" href="assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="assets/css/util.css">
  <link rel="stylesheet" type="text/css" href="assets/css/main.css">
<link rel="stylesheet" type="text/css" href="assets/css/style.css">

</head>
<body>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav" style="margin-left: 20%;">
        <li><a href="/">Home</a></li>
        <li><a href="/about-us">About Us</a></li>
        <li><a href="/download">Download</a></li>
        <li><a href="/contact-us">Contact Us</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="sign-in" style="display: none;">
	<a href="#">
		<img src="assets/img/Sign In Button.png">
	</a>
	<br>
	<center>
		<a href="#">Don't have an account? Sign up</a>
	</center>
</div>

<img src="assets/img/Rummy Boss Logo.png" class="logo">


  <div class="container-contact100">
    <div class="contact100-map" id="google_map" data-map-x="40.722047" data-map-y="-73.986422" data-pin="assets/img/icons/map-marker.png" data-scrollwhell="0" data-draggable="1"></div>

    <div class="wrap-contact100">
      <div class="contact100-form-title" style="background-image: url(assets/img/bg-01.jpg);">
        <span class="contact100-form-title-1">
          Contact Us
        </span>

        <span class="contact100-form-title-2">
          Feel free to drop us a line below!
        </span>
      </div>

      <form class="contact100-form validate-form">
        <div class="wrap-input100 validate-input" data-validate="Name is required">
          <span class="label-input100">Full Name:</span>
          <input class="input100" type="text" name="name" placeholder="Enter full name">
          <span class="focus-input100"></span>
        </div>

        <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
          <span class="label-input100">Email:</span>
          <input class="input100" type="text" name="email" placeholder="Enter email addess">
          <span class="focus-input100"></span>
        </div>

        <div class="wrap-input100 validate-input" data-validate="Phone is required">
          <span class="label-input100">Phone:</span>
          <input class="input100" type="text" name="phone" placeholder="Enter phone number">
          <span class="focus-input100"></span>
        </div>

        <div class="wrap-input100 validate-input" data-validate = "Message is required">
          <span class="label-input100">Message:</span>
          <textarea class="input100" name="message" placeholder="Your Comment..."></textarea>
          <span class="focus-input100"></span>
        </div>

        <div class="container-contact100-form-btn">
          <button class="contact100-form-btn">
            <span>
              Submit
              <i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
            </span>
          </button>
        </div>
      </form>
    </div>
  </div>

@extends('layouts.footer')

</body>
</html>