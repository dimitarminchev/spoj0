<?php
// current page
$page = "ask";

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
        if ($result->num_rows == 0) 
	die( sprintf("<div class='jumbotron alert-danger'><h1> %s </h1><p> %s.<p></div>",
		$lang["ask"]["problem"],
		$lang["ask"]["info1"]
	));
	$row = $result->fetch_row();
	$user_id = $row[0];

	// prepare sql
	$sql = "INSERT INTO spoj0.questions (problem_id, user_id, question_time, content, status, answer_time, answer_content) VALUES ('$problem_id','$user_id','$submit_time','$question','not answered','$submit_time','')";

	// execute and message
	if($conn->query($sql)) 
	echo sprintf("<div class='jumbotron alert-success'><h1> %s </h1><p> %s </p></div>",
		$lang["ask"]["question"],
		$lang["ask"]["info2"]."<b>$problem_id</b>"
	);
	else die( sprintf("<div class='jumbotron alert-danger'><h1> %s </h1><p> %s.<p></div>",
		$lang["ask"]["problem"],
		$lang["ask"]["info3"]
	));

	// close
	$conn->close();


} else {
// GET

// problem number
$pid = "";
if(isset($_REQUEST["id"])) $pid = (int)$_REQUEST["id"];


// The Form
$text = <<<EOT
<h1>%s</h1>
<form class="form-horizontal" action="question-ask.php" method="POST">
<fieldset>
<!-- task -->
<div class="form-group">
  <label class="col-md-4 control-label" for="task">%s</label>
  <div class="col-md-4">
  <input id="task" name="task" type="text" placeholder="%s" class="form-control input-md" required="" value="$pid">
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
<!-- content -->
<div class="form-group">
  <label class="col-md-4 control-label" for="question">%s</label>
  <div class="col-md-4">
  <textarea id="question" name="question" placeholder="%s" rows="10" class="form-control input-md" required=""></textarea>
  </div>
</div>
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
	$lang["ask"]["question"],
	$lang["ask"]["task_id"],
	$lang["ask"]["task_sample"],
	$lang["ask"]["user"],
	$lang["ask"]["user_sample"],
	$lang["ask"]["password"],
	$lang["ask"]["password_sample"],
	$lang["ask"]["question"],
	$lang["ask"]["question_note"],
	$lang["ask"]["submit_btn"]
);

}
// END GET

// container end
echo <<<EOT
</div>
<!-- /container -->
EOT;

// Заключителна част на документа
include("footer.php");
