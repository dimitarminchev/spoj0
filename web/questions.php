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

// var
$limit = 200;
$order = " ORDER BY q.question_id desc LIMIT $limit";

// sql
$sql =<<<EOT
SELECT
q.question_id,
q.user_id,
q.problem_id,
u.display_name as uname,
u.hidden as hidden,
c.set_code as ccode,
p.letter as pletter,
c.contest_id,
q.question_time,
q.content,
q.status,
q.answer_time,
q.answer_content
FROM questions as q
INNER JOIN users as u ON q.user_id = u.user_id
INNER JOIN problems as p ON q.problem_id = p.problem_id
INNER JOIN contests as c ON p.contest_id = c.contest_id
EOT;

// check
if(isset($_REQUEST["id"])) {
$qid = $_REQUEST["id"];
echo<<<EOT
<h1>Question</h1>
EOT;

// Part 1. single question status
$sql .= " WHERE q.question_id=".(int)$_REQUEST["id"].$order;

//echo $sql;

// execute
$result = $conn->query($sql);
if ($result->num_rows == 0) die("<div class='jumbotron alert-danger'><h1>Problem</h1><p>A question with such a number does not exist.<p></div>");
$row = $result->fetch_assoc();

// data
$contest = $row["ccode"];//."&nbsp;<span class='label label-info'>".$row["contest_id"]."</span>";
$problem = strtoupper($row["pletter"])."&nbsp;<span class='label label-info'>".$row["problem_id"]."</span>";
$user = $row["uname"];//."&nbsp;<span class='label label-info'>".$row["user_id"]."</span>";
$date = (new DateTime($row["question_time"]))->format("d.m.y H:i:s");
$content = $row["content"];
$answer_date = (new DateTime($row["answer_time"]))->format("d.m.y H:i:s");
$answer_content = $row["answer_content"];
$stat = strtoupper($row["status"]);
if($stat=="ANSWERED") $stat = "<span class='label label-success'>ANSWERED</span>";
else $stat = "<span class='label label-danger'>$stat</span>";

// print
echo <<<EOT
<div class="row">
<!-- 1 -->
<div class="col-md-6">
<div class="panel panel-default">
<div class="panel-heading"><h3 class="panel-title">Contest</h3></div>
<div class="panel-body"><h4>$contest</h4></div>
</div>
</div>
<!-- 2 -->
<div class="col-md-6">
<div class="panel panel-default">
<div class="panel-heading"><h3 class="panel-title">Problem</h3></div>
<div class="panel-body"><h4>$problem</h4></div>
</div>
</div>
</div>
<div class="row">
<!-- 3 -->
<div class="col-md-6">
<div class="panel panel-default">
<div class="panel-heading"><h3 class="panel-title">User</h3></div>
<div class="panel-body"><h4>$user</h4></div>
</div>
</div>
<!-- 4 -->
<div class="col-md-6">
<div class="panel panel-default">
<div class="panel-heading"><h3 class="panel-title">Status</h3></div>
<div class="panel-body"><h4>$stat</h4><a href='question-answer.php?id=$qid' class='btn btn-primary' role='button'>Аnswer</a></div>
</div>
</div>
</div>
<div class="row">
<!-- 5 -->
<div class="col-md-6">
<div class="panel panel-default">
<div class="panel-heading"><h3 class="panel-title">Question</h3></div>
<div class="panel-body"><h4>$content</h4></div>
</div>
</div>
<!-- 6 -->
<div class="col-md-6">
<div class="panel panel-default">
<div class="panel-heading"><h3 class="panel-title">Date</h3></div>
<div class="panel-body"><h4>$date</h4></div>
</div>
</div>
</div>
<!-- /end -->
EOT;

if(strtoupper($row["status"])=="ANSWERED") {
echo <<<EOT
<div class="row">
<!-- 7 -->
<div class="col-md-6">
<div class="panel panel-default">
<div class="panel-heading"><h3 class="panel-title">Answer</h3></div>
<div class="panel-body"><h4>$answer_content</h4></div>
</div>
</div>
<!-- 8 -->
<div class="col-md-6">
<div class="panel panel-default">
<div class="panel-heading"><h3 class="panel-title">Date</h3></div>
<div class="panel-body"><h4>$answer_date</h4></div>
</div>
</div>
</div>
EOT;
}


} else {
	// 2. multiple runs status
echo<<<EOT
<h1>Questions</h1>
EOT;

// table
echo<<<EOT
<div class="row">
<div class="col-md-12">
<table class="table table-striped">
<thead>
<tr>
<th>number</th>
<th>user</th>
<th>contest</th>
<th>problem</th>
<th>date</th>
<th>status</th>
<th class="pull-right">action</th>
</tr>
</thead>
<tbody>
EOT;

// execute
$sql .= $order;
$result = $conn->query($sql);

// process
if ($result->num_rows > 0)
{

 // output data of each row
 while($row = $result->fetch_assoc())
 {
	$qid = $row["question_id"];
	$date = (new DateTime($row["question_time"]))->format("d.m.y H:i:s");
	echo "<tr>";
	echo "<td>$qid</td>";
	//echo "<td><span class='label label-info'>".$row["user_id"]."</span>&nbsp;".$row["uname"]."</td>";
	echo "<td>".$row["uname"]."</td>";
	//echo "<td><span class='label label-info'>".$row["contest_id"]."</span>&nbsp;".$row["ccode"]."</td>";
	echo "<td>".$row["ccode"]."</td>";
	echo "<td><span class='label label-info'>".$row["problem_id"]."</span>&nbsp;".strtoupper($row["pletter"])."</td>";
	echo "<td>$date</td>";
	// status
	$stat = strtoupper($row["status"]);
	if($stat=="ANSWERED") $stat = "<span class='label label-success'>ANSWERED</span>";
	//else if($stat == "WA" || $stat == "PE")  $stat = "<span class='label label-warning'>$stat</span>";
	else $stat = "<span class='label label-warning'>$stat</span>";
	echo "<td>$stat</td>";
	// info button
	echo "<td class='pull-right'><a href='questions.php?id=$qid' class='btn btn-primary' role='button'>Information</a></td>";
	echo "</tr>";

 }
}


// end table
echo "</tbody></table></div></div>";

// note
echo "<p><u>Note</u>: Only <b>$limit</b> recent questions are displayed on the page.</p>";

}

// close
$conn->close();

// container end
echo <<<EOT
</div>
<!-- /container -->
EOT;

// Заключителна част на документа
include("footer.php");
