#!/bin/bash

composer migrate

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
