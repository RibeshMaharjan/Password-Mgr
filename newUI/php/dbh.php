<?php

require_once __DIR__.'/database.php';

$dbh = new PDO("mysql:host=" . $dbParams['host'] . ";dbname=" . $dbParams['dbname'] . "",  $dbParams['username'],  $dbParams['password']);
