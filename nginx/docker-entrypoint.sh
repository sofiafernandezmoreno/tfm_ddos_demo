#!/usr/bin/env sh
set -eu

envsubst '${NGINX_PORT} ${HAPROXY_IP} ${HAPROXY_PRIVATE_PORT}' < /etc/nginx/nginx.conf.template > /etc/nginx/nginx.conf

exec "$@"