<?php
// current page
$page = "contests";

// header
include("header.php");

// container
echo <<<EOT
<!-- container -->
<div class="container">
EOT;

// init
include("init.php");

// contest number
if(!isset($_REQUEST["id"])) 
die( sprintf("<div class='jumbotron alert-danger'><h1> %s </h1><p> %s.<p></div>",
	$lang["contest"]["problem"],
	$lang["contest"]["info1"]
));
$id = (int)$_REQUEST["id"];

// contest info
$sql = "SELECT contest_id, set_code, name, start_time, duration, show_sources, about, UNIX_TIMESTAMP(start_time) as ustart, UNIX_TIMESTAMP(NOW()) as unow FROM contests WHERE contest_id=$id";
$result = $conn->query($sql);
if ($result->num_rows == 0) 
die( sprintf("<div class='jumbotron alert-danger'><h1> %s </h1><p> %s.<p></div>",
	$lang["contest"]["problem"],
	$lang["contest"]["info2"]
));
$row = $result->fetch_assoc();

// contast start
if ($row["ustart"] > $row["unow"]) 
die( sprintf("<div class='jumbotron alert-danger'><h1> %s </h1><p> %s.<p></div>",
	$lang["contest"]["problem"],
	$lang["contest"]["info3"]
));

// start time
$start = new DateTime($row["start_time"]);

// contest header
$text = <<<EOT
<h1> %s </h1>
<div class="row">
<!-- 1 -->
<div class="col-md-6">
<div class="panel panel-default">
<div class="panel-heading"><h3 class="panel-title"> %s </h3></div>
<div class="panel-body"><h3> %s </h3></div>
</div>
</div>
<!-- 2 -->
<div class="col-md-3">
<div class="panel panel-default">
<div class="panel-heading"><h3 class="panel-title"> %s </h3></div>
<div class="panel-body"><h3> %s </h3></div>
</div>
</div>
<!-- 3 -->
<div class="col-md-3">
<div class="panel panel-default">
<div class="panel-heading"><h3 class="panel-title"> %s </h3></div>
<div class="panel-body"><h3> %s </h3></div>
</div>
</div>
</div>
<!-- /row -->
EOT;
echo sprintf( $text, 
	$lang["contest"]["problems"], 
	$lang["contest"]["contest"], $row["name"],
	$lang["contest"]["start"], $start->format("d.m.Y H:i"),
	$lang["contest"]["duration"], $row["duration"]
);

// contest table
$text = <<<EOT
<div class="row">
<div class="col-md-12">
<table class="table table-striped">
<thead>
<tr>
<th> %s </th>
<th> %s </th>
<th> %s </th>
<th class="pull-right"> %s </th>
</tr>
</thead>
<tbody>
EOT;
echo sprintf( $text, 
	$lang["contest"]["id"], 
	$lang["contest"]["letter"], 
	$lang["contest"]["about"], 
	$lang["contest"]["action"]
);

// sql & execute
$sql = "SELECT * FROM problems WHERE contest_id=$id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {

// print contest table
while($row = $result->fetch_assoc()) {
	
// contest row	
$id = $row["problem_id"];
$about = $row["about"];
$letter = strtoupper($row["letter"]);
	
// contest row
$text = <<<EOT
<tr>
<td>$id</td>
<td>$letter</td>
<td>$about</td>
<td class='pull-right'><a href='description.php?id=$id' class='btn btn-primary' role='button'> %s </a> &nbsp;
<a href='submit.php?id=$id' class='btn btn-info' role='button'> %s </a> &nbsp;
<a href='askquestion.php?id=$id' class='btn btn-warning' role='button'> %s </a>
</tr>
EOT;
echo sprintf( $text,  
	$lang["contest"]["description"], 
	$lang["contest"]["submit"], 
	$lang["contest"]["question"]
);

}}

// end table
echo "</tbody></table></div></div>";

// close
$conn->close();

// container end
echo <<<EOT
</div>
<!-- /container -->
EOT;

// footer
include("footer.php");