<?php
/* SPOJ0 */
// Settings
$NAME = 'spoj0'; // the name of the system
$HOME_DIR = '/home/spoj0'; // home directory of the system
$EXEC_DIR = '/home/spoj0run'; // where problems are executed
$SETS_DIR = '/home/spoj0/sets'; // where problem sets are stored
$NEWS_DIR = '/home/spoj0/news'; // where the news are stored
$EXPORT_DIR = '/home/spoj0/export'; // where stuff is exported
$STOP_DAEMON_FILE = '/home/spoj0/spoj0-stop-daemon';

// Statuses
$STATUS_WAITING = 'waiting';
$STATUS_JUDGING = 'judging';
$STATUS_OK = 'ok';
$STATUS_CE = 'ce'; // compile error
$STATUS_TL = 'tl'; // time limit
$STATUS_WA = 'wa'; // wrong answer
$STATUS_PE = 'pe'; // presentation error (difference in whitespaces)
$STATUS_RE = 're'; // runtime error



/* MySQL */
// Creditentials
$servername = "localhost";
$username = "spoj0_admin";
$password = "stancho3";
$dbname = "spoj0";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) die("Error: " . $conn->connect_error);

