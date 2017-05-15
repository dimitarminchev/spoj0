<?php
// Текуща страница
$page = "register";

// Заглавна част на документа
include("header.php");
?>



<!-- Основно съдържание -->
<div class="container">


<?php
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
	if($result) echo "<div class='jumbotron alert-success'><h1>Регистрация</h1><p>Потребителят е регистриран успешно.</p></div>";
	else echo "<div class='jumbotron alert-danger'><h1>Регистрация</h1><p>Възникна проблем при регистрирането на потребителят.</p></div>";
	// close
	$conn->close();

} else {
?>




<!-- header -->
<div class="jumbotron">
<h1>Регистрация</h1>
<p>За да изпращате решения трябва да се регистрирате, като попълните настоящият електронен формуляр. 
Моля запомнете потребителското име и паролата си, те ще са Ви необходими.</p>
</div>

<!-- The Form -->
<form class="form-horizontal" action="register.php" method="POST">
<fieldset>

<!-- Legend -->
<legend>Регистрация</legend>
<!-- name -->
<div class="form-group">
  <label class="col-md-4 control-label" for="name">Име и фамилия</label>
  <div class="col-md-4">
  <input id="name" name="name" type="text" placeholder="Например: Димитър Минчев" class="form-control input-md" required="">
  </div>
</div>
<!-- email -->
<div class="form-group">
  <label class="col-md-4 control-label" for="email">Електронна поща</label>
  <div class="col-md-4">
  <input id="email" name="email" type="text" placeholder="Например: dimitar.minchev@gmail.com" class="form-control input-md" required="">    
  </div>
</div>
<!-- user -->
<div class="form-group">
  <label class="col-md-4 control-label" for="user">Потребител</label>
  <div class="col-md-4">
  <input id="user" name="user" type="text" placeholder="Например: dimitar" class="form-control input-md" required="">   
  </div>
</div>
<!-- pass -->
<div class="form-group">
  <label class="col-md-4 control-label" for="password">Парола</label>
  <div class="col-md-4">
    <input id="password" name="password" type="password" placeholder="Например: minchev" class="form-control input-md" required="">
  </div>
</div>
<!-- TODO: Google Recapcha
<div class="form-group">
<label class="col-md-4 control-label" for="recapcha"></label>
<div class="col-md-4">
<div class="g-recaptcha" data-sitekey="6LeZxQsUAAAAANhwzMKG7AOa1oT0q7LOOd58eWoa"></div>
</div>
</div>
-->
<!-- Submit Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="submit"></label>
  <div class="col-md-4">
    <button id="submit" name="submit" class="btn btn-primary">Регистрация</button>
  </div>
</div>

</fieldset>
</form>



<?php
}
// END GET
?>



</div>
<!-- /Основно съдържание -->



<?php
// Заключителна част на документа
include("footer.php");
