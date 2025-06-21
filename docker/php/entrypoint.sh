#!/bin/bash
set -e

# Ensure logs exist
touch /var/log/supervisord.log /var/log/supervisord.err

exec /usr/bin/supervisord -n -c /etc/supervisor/conf.d/laravel-worker.conf
