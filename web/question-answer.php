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

// question number
$qid = "";
if(isset($_REQUEST["id"])) $qid = (int)$_REQUEST["id"];


// POST
if($_SERVER['REQUEST_METHOD']=='POST')
{
	// vars
	$problem_id = $conn->real_escape_string(htmlspecialchars($_REQUEST["task"]));
	$user = $conn->real_escape_string(htmlspecialchars($_REQUEST["user"]));
	$pass = md5($conn->real_escape_string(($_REQUEST["password"])));
	$answer = $conn->real_escape_string(htmlspecialchars($_REQUEST["answer"]));
	$submit_time = date("Y-m-d H:i:s");

	// check for user -----
	$sql = "SELECT user_id FROM  spoj0.users WHERE name='$user' and pass_md5='$pass'";
	$result = $conn->query($sql);
    if ($result->num_rows == 0) die("<div class='jumbotron alert-danger'><h1>Проблем</h1><p>Неправилно потребителско име и/или парола.<p></div>");
	$row = $result->fetch_row();
	$user_id = $row[0];
	
	if ($user_id != 1) die("<div class='jumbotron alert-danger'><h1>Проблем</h1><p>Нямате права да отговаряте на въпроси.<p></div>");

	// prepare sql
	$sql = "update spoj0.questions SET status = 'answered', answer_content='$answer', answer_time='$submit_time' where question_id=$qid";
	
	// execute and message
	if($conn->query($sql)) echo "<div class='jumbotron alert-success'><h1>Въпрос</h1><p>Успешно е отговорихте на въпрос на задача <b>$problem_id</b>.</p></div>";
	else echo "<div class='jumbotron alert-danger'><h1>Въпрос</h1><p>Възникна проблем при изпращането на отговор на въпрос на задача <b>$problem_id</b>.</p></div>";

	// close
	$conn->close();


} else {
// GET

	$sql = "SELECT content FROM questions WHERE question_id=$qid";
	$result = $conn->query($sql);
    if ($result->num_rows == 0) die("<div class='jumbotron alert-danger'><h1>Проблем</h1><p>Въпрос с такъв номер на съществува.<p></div>");
	$row = $result->fetch_row();
	$content = $row[0];

?>

<!-- The Form -->
<h1>Отговор</h1>
<?php
echo "<form class=\"form-horizontal\" action=\"question-answer.php?id=$qid\" method='POST'>";
?>
<fieldset>

<!-- Legend -->
<!-- <legend>Отговор</legend> -->
<!-- user -->
<div class="form-group">
  <label class="col-md-4 control-label" for="user">Въпрос</label>
  <div class="col-md-4">
  <textarea id="answer" name="answer" rows="10" class="form-control input-md" readonly>
  <?php 
	echo $content;
  ?>
  </textarea>
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
  <label class="col-md-4 control-label" for="answer">Отговор</label>
  <div class="col-md-4">
  <textarea id="answer" name="answer" placeholder="Тук напишете отговор." rows="10" class="form-control input-md" required=""></textarea>
  </div>
</div>
<!-- Submit Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="submit"></label>
  <div class="col-md-4">
    <button id="submit" name="submit" class="btn btn-primary">Изпрати отговор</button>
  </div>
</div>

</fieldset>
</form>
<p><u>Бележка</u>: Само администратор може да отговаря на въпроси.</p>
<?php
}
// END GET

// close
$conn->close();

// container end
echo <<<EOT
</div>
<!-- /container -->
EOT;

// Заключителна част на документа
include("footer.php");
