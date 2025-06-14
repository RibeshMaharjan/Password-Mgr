<?php

require_once(__DIR__ . '/../../vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

// Database 
$dbParams = array(
  'host' => $_ENV['DATABASE_HOSTNAME'],
  'username' => $_ENV['DATABASE_USERNAME'],
  'password' => $_ENV['DATABASE_PASSWORD'],
  'dbname' => $_ENV['DATABASE_NAME']
);