<?php
// current page
$page = "news";

// header
include("header.php");

// container
$text <<<EOT
<!-- container -->
<div class="container">
<h1>%s</h1>
EOT;
echo sprintf( $text, $lang["nav"]["news"] );


// sql
$sql = "SELECT * FROM news ORDER BY new_id DESC";
$result = $conn->query($sql);

// execute
if ($result->num_rows > 0)

// print
while($row = $result->fetch_assoc()) {
$text = <<< EOT
<h3>%s</h3>
<div>%s</div>
<p>%s</p>
<hr>
EOT;
echo sprintf( $text, $row["topic"], (new DateTime($row["new_time"]))->format("d.m.Y H:i:s"), $row["content"]);
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
