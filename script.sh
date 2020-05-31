#!/bin/bash -eu

set -eux -o pipefail -o errexit


readonly task=${1}

if [ "$task" == "up" ] ;then
docker-compose -f docker-compose.siem.yml -f docker-compose.waf.yml -f docker-compose.iptables.yml up -d
fi
if [ "$task" == "stop" ];then
docker-compose -f docker-compose.siem.yml -f docker-compose.waf.yml -f docker-compose.iptables.yml stop
fi
if [ "$task" == "down" ] ;then
docker-compose -f docker-compose.siem.yml -f docker-compose.waf.yml -f docker-compose.iptables.yml down -v
fi

if [ "$task" == "ps" ] ;then
docker-compose -f docker-compose.siem.yml -f docker-compose.waf.yml -f docker-compose.iptables.yml ps
fi

if [ "$task" == "build" ] ;then
docker-compose -f docker-compose.siem.yml -f docker-compose.waf.yml -f docker-compose.iptables.yml build
fi

if [ "$task" == "logsc" ] ;then
readonly container=${2}
docker-compose -f docker-compose.siem.yml -f docker-compose.waf.yml -f docker-compose.iptables.yml logs -f $container
fi
if [ "$task" == "logs" ] ;then

docker-compose -f docker-compose.siem.yml -f docker-compose.waf.yml -f docker-compose.iptables.yml logs -f 
fi

if [ "$task" == "exec" ] ;then
readonly container=${2}
docker-compose -f docker-compose.siem.yml -f docker-compose.waf.yml -f docker-compose.iptables.yml exec $container /bin/bash
fi


if [ "$task" == "restart" ] ;then
readonly container=${2}
docker-compose -f docker-compose.siem.yml -f docker-compose.waf.yml -f docker-compose.iptables.yml restart $container 
fi

