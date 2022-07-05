#!/usr/local/bin/dumb-init /bin/sh
php-fpm &
for f in workers/*.php; do
  echo "starting worker:" $(basename $f)
  php "$f" &
done
caddy run
