#!/bin/bash -eu

set -eux -o pipefail -o errexit


readonly task=${1}
if [ "$task" == "up" ] ;then
docker-compose -f docker-compose.siem.yml -f docker-compose.waf.yml up -d
fi
if [ "$task" == "stop" ];then
docker-compose -f docker-compose.siem.yml -f docker-compose.waf.yml stop
fi
if [ "$task" == "down" ] ;then
docker-compose -f docker-compose.siem.yml -f docker-compose.waf.yml down -v
fi