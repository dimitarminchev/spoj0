<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="Dimitar Minchev">
<title>SPOJ</title>
<!-- Bootstrap -->
<link rel="stylesheet" href="assets/bootstrap.min.css" >
<link rel="stylesheet" href="assets/bootstrap-theme.min.css">
<link rel="stylesheet" href="assets/bootstrap-table.min.css">
<style>body { padding-top: 50px; }</style>
</head>
<body>

<!-- Навигация -->
<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Навигация</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
	  <a class="navbar-brand" href="#">SPOJ</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="index.php">Състезания</a></li>
            <li class="active"><a href="submit.php">Решение</a></li>
            <li><a href="status.php">Статус</a></li>
            <li><a href="register.php">Регистрация</a></li>
          </ul>
        </div>
      </div>
</nav>

<!-- Основно съдържание -->
<div class="container">


<?php
// init
include("init.php");

// POST
if($_SERVER['REQUEST_METHOD']=='POST')
{
	// vars
	$problem_id = $conn->real_escape_string($_REQUEST["task"]);
	$user = $conn->real_escape_string($_REQUEST["user"]);
	$pass = md5($conn->real_escape_string($_REQUEST["password"]));
	$language = $conn->real_escape_string($_REQUEST["language"]);
	$code = $conn->real_escape_string($_REQUEST["code"]);
	$submit_time = date("Y-m-d H:i:s");

	// check for user
	$sql = "SELECT user_id FROM  spoj0.users WHERE name='$user' and pass_md5='$pass'";
	$result = $conn->query($sql);
        if ($result->num_rows == 0) echo "<div class='jumbotron alert-danger'><h1>Проблем</h1><p>Неправилно потребителско име и/или парола.<p></div>";
	$row = $result->fetch_row();
	$user_id = $row[0];

	// prepare sql
	$sql = "INSERT INTO spoj0.runs (problem_id, user_id, submit_time, language, source_code, source_name, about, status, log) ".
	       "VALUES ('$problem_id','$user_id','$submit_time','$language','$code','program.$language','','waiting','')";

	// execute and message
	if($conn->query($sql)) echo "<div class='jumbotron alert-success'><h1>Решение</h1><p>Успешно е изпратено решение <b>$problem_id</b> на задача.</p></div>";
	else echo "<div class='jumbotron alert-danger'><h1>Решение</h1><p>Възникна проблем при изпращането на решение <b>$problem_id</b> на задача.</p></div>";

	// close
	$conn->close();


} else {
// GET

// problem number
$pid = "";
if(isset($_REQUEST["id"])) $pid = (int)$_REQUEST["id"];
?>

<!-- The Form -->
<h1>Решение</h1>
<form class="form-horizontal" action="submit.php" method="POST">
<fieldset>

<!-- Legend -->
<!-- <legend>Решение</legend> -->
<!-- task -->
<div class="form-group">
  <label class="col-md-4 control-label" for="task">Номер на задачата</label>
  <div class="col-md-4">
  <input id="task" name="task" type="text" placeholder="Например: 42" class="form-control input-md" required="" value="<?php echo $pid; ?>">
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
<!-- language -->
<div class="form-group">
  <label class="col-md-4 control-label" for="language">Език за програмиране</label>
  <div class="col-md-4">
   <select class="form-control" name="language" id="language" class="form-control input-md" >
    <option selected value="cpp">C++</option>
<!-- <option value="csharp">C#</option> -->
    <option value="java">Java</option>
   </select>
  </div>
</div>
<!-- code -->
<div class="form-group">
  <label class="col-md-4 control-label" for="code">Изходен код на програмата</label>
  <div class="col-md-4">
  <textarea id="code" name="code" placeholder="Тук копирайте и поставете Вашият програмен код съдържащ решението на задачата и подлежащ на проверка." rows="10" class="form-control input-md" required=""></textarea>
  </div>
</div>
<!-- Submit Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="submit"></label>
  <div class="col-md-4">
    <button id="submit" name="submit" class="btn btn-primary">Изпрати решението за проверка</button>
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

<!-- Заключителна част -->
<div class="container">
<hr><p><a target="_blank" href="http://www.minchev.eu">Димитър Минчев</a> &copy; 2016</p>
</div>
<!-- /footer -->

<!-- jQuery JavaScript Payload -->
<script src="assets/jquery.min.js"></script>
<!-- BootStrap JavaScript PayLoad -->
<script src="assets/bootstrap.min.js"></script>
<script src="assets/bootstrap-table.min.js"></script>

</body>
</html>
