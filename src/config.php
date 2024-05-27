<?php
define('dbserver', 'mysql_db');
define('dbusername', 'root');
define('dbpassword', 'toor');
define('dbname', 'user_info');

$db = mysqli_connect(dbserver, dbusername, dbpassword, dbname);

if($db === false) {
    die("Error: connection error." .mysqli_connect_error());
}
