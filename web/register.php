<?php
// current page
$page = "register";

// header
include("header.php");

// container
echo <<<EOT
<!-- container -->
<div class="container">
EOT;

// init
include("init.php");

// POST
if($_SERVER['REQUEST_METHOD']=='POST')
{
	// data
	$user = $conn->real_escape_string($_REQUEST["user"]);
	$pass = md5($conn->real_escape_string($_REQUEST["password"]));
	$name = $conn->real_escape_string($_REQUEST["name"]);
	$email = "email:".$conn->real_escape_string($_REQUEST["email"]);
	// sql and execute
	$sql = "INSERT INTO spoj0.users (name, pass_md5, display_name, about) VALUES ('$user','$pass','$name','$email')";
	$result = $conn->query($sql); 
	// message
	if($result) echo sprintf( "<div class='jumbotron alert-success'><h1>%s</h1><p>%s.</p></div>", $lang["register"]["register"], $lang["register"]["info1"] );	
	else echo sprintf( "<div class='jumbotron alert-danger'><h1>%s</h1><p>%s</p></div>", $lang["register"]["problem"], $lang["register"]["info2"] );
	// close
	$conn->close();

} else {


// GET
$text = <<< EOT
<!-- header -->
<div class="jumbotron">
<h1>%s</h1>
<p>%s</p>
</div>

<!-- The Form -->
<form class="form-horizontal" action="register.php" method="POST">
<fieldset>

<!-- Legend -->
<legend>%s</legend>
<!-- name -->
<div class="form-group">
  <label class="col-md-4 control-label" for="name">%s</label>
  <div class="col-md-4">
  <input id="name" name="name" type="text" placeholder="%s" class="form-control input-md" required="">
  </div>
</div>
<!-- email -->
<div class="form-group">
  <label class="col-md-4 control-label" for="email">%s</label>
  <div class="col-md-4">
  <input id="email" name="email" type="text" placeholder="%s" class="form-control input-md" required="">    
  </div>
</div>
<!-- user -->
<div class="form-group">
  <label class="col-md-4 control-label" for="user">%s</label>
  <div class="col-md-4">
  <input id="user" name="user" type="text" placeholder="%s" class="form-control input-md" required="">   
  </div>
</div>
<!-- pass -->
<div class="form-group">
  <label class="col-md-4 control-label" for="password">%s</label>
  <div class="col-md-4">
    <input id="password" name="password" type="password" placeholder="%s" class="form-control input-md" required="">
  </div>
</div>
<!-- TODO: Google Recapcha
<div class="form-group">
<label class="col-md-4 control-label" for="recapcha"></label>
<div class="col-md-4">
<div class="g-recaptcha" data-sitekey="%s"></div>
</div>
</div>
-->
<!-- Submit Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="submit"></label>
  <div class="col-md-4">
    <button id="submit" name="submit" class="btn btn-primary">%s</button>
  </div>
</div>

</fieldset>
</form>
EOT;
echo sprintf( $text,
	$lang["register"]["register"], 
	$lang["register"]["register_info"],
	$lang["register"]["register"],
	$lang["register"]["name"],
	$lang["register"]["name_note"],
	$lang["register"]["email"],
	$lang["register"]["email_note"],
	$lang["register"]["user"], 
	$lang["register"]["usern_note"], 
	$lang["register"]["password"], 
	$lang["register"]["password_note"], 
	$RECAPTCHA_KEY,
	$lang["register"]["submit"]
);


}
// END GET

// container end
echo <<<EOT
</div>
<!-- /container -->
EOT;

// footer
include("footer.php");
