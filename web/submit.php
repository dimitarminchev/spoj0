<?php
// Текуща страница
$page = "submit";

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
    <option value="cs">C#</option>
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



<?php
// Заключителна част на документа
include("footer.php");
