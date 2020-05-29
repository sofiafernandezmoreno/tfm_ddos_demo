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

if [ "$task" == "ps" ] ;then
docker-compose -f docker-compose.siem.yml -f docker-compose.waf.yml ps
fi

if [ "$task" == "build" ] ;then
docker-compose -f docker-compose.siem.yml -f docker-compose.waf.yml build
fi

if [ "$task" == "logs" ] ;then
readonly container=${2}
docker-compose -f docker-compose.siem.yml -f docker-compose.waf.yml logs -f $container
fi