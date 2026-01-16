#!/bin/sh
set -e

mkdir -p var/cache var/log
chown -R www-data:www-data var/cache var/log
chmod -R 775 var/cache var/log

exec symfony server:start --no-tls --port="${SYMFONY_APP_PORT:-8000}" --listen-ip=0.0.0.0 "$@"
