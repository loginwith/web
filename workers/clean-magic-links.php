<?php
require __DIR__ . '/../db.php';

$running = true;

declare(ticks = 1);

pcntl_signal(SIGTERM, "signal_handler");
pcntl_signal(SIGINT, "signal_handler");

function signal_handler($signal) {
  global $running;

  echo "caught signal $signal\n";

  switch($signal) {
    case SIGTERM:
    case SIGINT:
      $running = false;
    default:
  }
}

while($running) {
  global $dbh;

  echo "removing stale magic links... ";
  $x = $dbh->exec("DELETE FROM magic_links WHERE expires < " . time());
  echo "$x\n";

  sleep(60);
}

echo "exiting\n";
