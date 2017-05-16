<?php
// current page
$page = "submit";

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
    if ($result->num_rows == 0) 
	die( sprintf("<div class='jumbotron alert-danger'><h1> %s </h1><p> %s.<p></div>",
		$lang["submit"]["problem"],
		$lang["submit"]["info1"]
	));

	$row = $result->fetch_row();
	$user_id = $row[0];

	// prepare sql
	$sql = "INSERT INTO spoj0.runs (problem_id, user_id, submit_time, language, source_code, source_name, about, status, log) ".
	       "VALUES ('$problem_id','$user_id','$submit_time','$language','$code','program.$language','','waiting','')";

	// execute and message
	if($conn->query($sql)) 
	echo sprintf("<div class='jumbotron alert-success'><h1> %s </h1><p> %s </p></div>",
		$lang["submit"]["submit"],
		$lang["submit"]["info2"]."<b>$problem_id</b>"
	);
	else echo sprintf("<div class='jumbotron alert-danger'><h1> %s </h1><p> %s </p></div>",
		$lang["submit"]["submit"],
		$lang["submit"]["info3"]."<b>$problem_id</b>"
	);

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
<form class="form-horizontal" action="submit.php" method="POST">
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
<!-- language -->
<div class="form-group">
  <label class="col-md-4 control-label" for="language">%s</label>
  <div class="col-md-4">
   <select class="form-control" name="language" id="language" class="form-control input-md">
    <option selected value="cpp">C++</option>
    <option value="cs">C#</option>
    <option value="java">Java</option>
   </select>
   <div id="language_note" class="alert alert-info" style="margin-top:10px; display: none;">%s</div>
  </div>  
</div>
<!-- code -->
<div class="form-group">
  <label class="col-md-4 control-label" for="code">%s</label>
  <div class="col-md-4">
  <textarea id="code" name="code" placeholder="%s" rows="10" class="form-control input-md" required=""></textarea>
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
<!-- Show/Hide Java Language Note -->
<script language="javascript">
document.getElementById('language').addEventListener('change', function () {
 var style = this.value == "java" ? 'block' : 'none';
 document.getElementById('language_note').style.display = style;
});
</script>
EOT;
echo sprintf( $text,  
	$lang["submit"]["submit"], 	
	$lang["submit"]["task_id"],
	$lang["submit"]["task_sample"],
	$lang["submit"]["user"], 
	$lang["submit"]["user_sample"],
	$lang["submit"]["password"], 
	$lang["submit"]["password_sample"],
	$lang["submit"]["language"], 
	$lang["submit"]["language_note"],
	$lang["submit"]["code"], 
	$lang["submit"]["code_note"],
	$lang["submit"]["submit_btn"] 
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
