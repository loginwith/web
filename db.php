<?php
// connect to database
$path = __DIR__ . '/data/loginwith.db';

$dbh = new PDO('sqlite:' . $path, null, null, [PDO::ATTR_PERSISTENT => false]);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$dbh->sqliteCreateFunction('regexp', function($string, $pattern) {
  return preg_match($pattern, $string);
}, 2);
