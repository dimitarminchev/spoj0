<?php
// current page
$page = "answer";

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
	$sql = "SELECT user_id FROM spoj0.users WHERE name='$user' and pass_md5='$pass'";
	$result = $conn->query($sql);
    if ($result->num_rows == 0) 
	die( sprintf("<div class='jumbotron alert-danger'><h1> %s </h1><p> %s.<p></div>",
		$lang["answer"]["problem"],
		$lang["answer"]["info1"]
	));
	$row = $result->fetch_row();
	$user_id = $row[0];
	
	if ($user_id != 1) 
	die( sprintf("<div class='jumbotron alert-danger'><h1> %s </h1><p> %s.<p></div>",
		$lang["answer"]["problem"],
		$lang["answer"]["info2"]
	));

	// prepare sql
	$sql = "update spoj0.questions SET status = 'answered', answer_content='$answer', answer_time='$submit_time' where question_id=$qid";
	
	// execute and message
	if($conn->query($sql)) 
	echo sprintf("<div class='jumbotron alert-success'><h1> %s </h1><p> %s </p></div>",
		$lang["answer"]["answer"],
		$lang["answer"]["info3"]."<b>$problem_id</b>"
	);
	else die( sprintf("<div class='jumbotron alert-danger'><h1> %s </h1><p> %s.<p></div>",
		$lang["answer"]["problem"],
		$lang["answer"]["info4"]
	));

	// close
	$conn->close();


} else {
// GET

// mysql
$sql = "SELECT content FROM questions WHERE question_id=$qid";
$result = $conn->query($sql);
if ($result->num_rows == 0) else die( sprintf("<div class='jumbotron alert-danger'><h1> %s </h1><p> %s.<p></div>",
		$lang["answer"]["problem"],
		$lang["answer"]["info5"]
));
$row = $result->fetch_row();
$content = $row[0];



// The Form
$text = <<<EOT
<h1>%s</h1>
<form class="form-horizontal" action="question-answer.php?id=$qid" method="POST">
<fieldset>
<!-- question -->
<div class="form-group">
  <label class="col-md-4 control-label" for="user">%s</label>
  <div class="col-md-4">
  <textarea id="answer" name="answer" rows="10" class="form-control input-md" readonly> $content </textarea>
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
  <label class="col-md-4 control-label" for="answer">%s</label>
  <div class="col-md-4">
  <textarea id="answer" name="answer" placeholder="%s" rows="10" class="form-control input-md" required=""></textarea>
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
	$lang["answer"]["answer"],
	$lang["answer"]["question"],
	$lang["answer"]["user"],
	$lang["answer"]["user_sample"],
	$lang["answer"]["password"],
	$lang["answer"]["password_sample"],
	$lang["answer"]["answer"],
	$lang["answer"]["answer_note"],
	$lang["answer"]["submit_btn"],
);

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
