<?php
// current page
$page = "questions";

// header
include("header.php");

// container
echo <<<EOT
<!-- container -->
<div class="container">
EOT;

// POST
if($_SERVER['REQUEST_METHOD']=='POST')
{
	// vars
	$problem_id = $conn->real_escape_string(htmlspecialchars($_REQUEST["task"]));
	$user = $conn->real_escape_string(htmlspecialchars($_REQUEST["user"]));
	$pass = md5($conn->real_escape_string($_REQUEST["password"]));
	$question = $conn->real_escape_string(htmlspecialchars($_REQUEST["question"]));
	$submit_time = date("Y-m-d H:i:s");

	// check for user
	$sql = "SELECT user_id FROM  spoj0.users WHERE name='$user' and pass_md5='$pass'";
	$result = $conn->query($sql);
    if ($result->num_rows == 0) die("<div class='jumbotron alert-danger'><h1>Проблем</h1><p>Неправилно потребителско име и/или парола.<p></div>");
	$row = $result->fetch_row();
	$user_id = $row[0];

	// prepare sql
	$sql = "INSERT INTO spoj0.questions (problem_id, user_id, question_time, content, status, answer_time, answer_content) ".
	       "VALUES ('$problem_id','$user_id','$submit_time','$question','not answered','$submit_time','')";

	// execute and message
	if($conn->query($sql)) echo "<div class='jumbotron alert-success'><h1>Въпрос</h1><p>Успешно е изпратено въпрос на задача <b>$problem_id</b>.</p></div>";
	else echo "<div class='jumbotron alert-danger'><h1>Въпрос</h1><p>Възникна проблем при изпращането на въпрос на задача <b>$problem_id</b>.</p></div>";

	// close
	$conn->close();


} else {
// GET

// problem number
$pid = "";
if(isset($_REQUEST["id"])) $pid = (int)$_REQUEST["id"];

?>

<!-- The Form -->
<h1>Въпрос</h1>
<form class="form-horizontal" action="askquestion.php" method="POST">
<fieldset>

<!-- Legend -->
<!-- <legend>Въпрос</legend> -->
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
  <input id="user" name="user" type="text" placeholder="Например: ivan" class="form-control input-md" required="">
  </div>
</div>
<!-- pass -->
<div class="form-group">
  <label class="col-md-4 control-label" for="password">Парола</label>
  <div class="col-md-4">
    <input id="password" name="password" type="password" placeholder="Например: password" class="form-control input-md" required="">
  </div>
</div>
<!-- content -->
<div class="form-group">
  <label class="col-md-4 control-label" for="question">Въпрос</label>
  <div class="col-md-4">
  <textarea id="question" name="question" placeholder="Тук задайте въпроса." rows="10" class="form-control input-md" required=""></textarea>
  </div>
</div>
<!-- Submit Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="submit"></label>
  <div class="col-md-4">
    <button id="submit" name="submit" class="btn btn-primary">Изпрати въпрос</button>
  </div>
</div>

</fieldset>
</form>

<?php
}
// END GET


// container end
echo <<<EOT
</div>
<!-- /container -->
EOT;

// Заключителна част на документа
include("footer.php");
