#!/bin/bash

touch /var/run/supervisor.sock
chmod 777 /var/run/supervisor.sock
service supervisor restart
supervisord -c /etc/supervisor/conf.d/supervisord.conf
supervisorctl -c /etc/supervisor/conf.d/supervisord.conf
supervisorctl reread
supervisorctl update
supervisorctl start "laravel-worker:*"
