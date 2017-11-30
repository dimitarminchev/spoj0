<?php
// current page
$page = "news";

// header
include("header.php");

// container
echo sprintf( "<div class='container'><h1>%s</h1>", $lang["nav"]["news"] );

// query
$result = $conn->query("SELECT * FROM news ORDER BY new_id DESC");

// execute
if ($result->num_rows > 0)

// print
while($row = $result->fetch_assoc()) {
$text=<<<EOT
<div class='row'>
<div class='col-md-12'>
<div class='panel panel-default'>
<div class='panel-heading'><h3 class='panel-title'>%s</h3></div>
<div class='panel-body'><h4>%s</h4><i>%s</i></div>
</div>
EOT;
echo sprintf ( $text, $row["topic"], $row["content"], (new DateTime($row["new_time"]))->format("d.m.Y H:i:s"));
}

// close
$conn->close();

// container end
echo "</div>";

// Заключителна част на документа
include("footer.php");
