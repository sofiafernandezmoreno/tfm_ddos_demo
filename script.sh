#!/bin/bash -eu

set -eux -o pipefail -o errexit


readonly task=${1}
if [ "$task" == "attack" ] ;then
export INTERFACE="br-$(docker network ls | grep tfm_ddos_demo_tfm | awk '{print $1}')"
docker-compose -f docker-compose.siem.yml -f docker-compose.waf.yml -f docker-compose.iptables.yml -f docker-compose.wordpress.yml up -d
sleep 5
python ATTACKS/botnet/attack.py
fi
if [ "$task" == "up" ] ;then
export INTERFACE="br-$(docker network ls | grep tfm_ddos_demo_tfm | awk '{print $1}')"
docker-compose -f docker-compose.siem.yml -f docker-compose.waf.yml -f docker-compose.iptables.yml -f docker-compose.wordpress.yml up -d

fi
if [ "$task" == "stop" ];then
export INTERFACE="br-$(docker network ls | grep tfm_ddos_demo_tfm | awk '{print $1}')"

docker-compose -f docker-compose.siem.yml -f docker-compose.waf.yml -f docker-compose.iptables.yml -f docker-compose.wordpress.yml stop
fi
if [ "$task" == "down" ] ;then
export INTERFACE="br-$(docker network ls | grep tfm_ddos_demo_tfm | awk '{print $1}')"

docker-compose -f docker-compose.siem.yml -f docker-compose.waf.yml -f docker-compose.iptables.yml -f docker-compose.wordpress.yml down -v
fi

if [ "$task" == "ps" ] ;then
export INTERFACE="br-$(docker network ls | grep tfm_ddos_demo_tfm | awk '{print $1}')"

docker-compose -f docker-compose.siem.yml -f docker-compose.waf.yml -f docker-compose.iptables.yml -f docker-compose.wordpress.yml ps
fi

if [ "$task" == "build" ] ;then
export INTERFACE="br-$(docker network ls | grep tfm_ddos_demo_tfm | awk '{print $1}')"

docker-compose -f docker-compose.siem.yml -f docker-compose.waf.yml -f docker-compose.iptables.yml -f docker-compose.wordpress.yml build
fi

if [ "$task" == "logsc" ] ;then
export INTERFACE="br-$(docker network ls | grep tfm_ddos_demo_tfm | awk '{print $1}')"

readonly container=${2}
docker-compose -f docker-compose.siem.yml -f docker-compose.waf.yml -f docker-compose.iptables.yml -f docker-compose.wordpress.yml logs -f $container
fi
if [ "$task" == "logs" ] ;then
export INTERFACE="br-$(docker network ls | grep tfm_ddos_demo_tfm | awk '{print $1}')"

docker-compose -f docker-compose.siem.yml -f docker-compose.waf.yml -f docker-compose.iptables.yml -f docker-compose.wordpress.yml logs -f 
fi

if [ "$task" == "exec" ] ;then
export INTERFACE="br-$(docker network ls | grep tfm_ddos_demo_tfm | awk '{print $1}')"

readonly container=${2}
docker-compose -f docker-compose.siem.yml -f docker-compose.waf.yml -f docker-compose.iptables.yml -f docker-compose.wordpress.yml exec $container /bin/bash
fi


if [ "$task" == "restart" ] ;then
export INTERFACE="br-$(docker network ls | grep tfm_ddos_demo_tfm | awk '{print $1}')"

readonly container=${2}
docker-compose -f docker-compose.siem.yml -f docker-compose.waf.yml -f docker-compose.iptables.yml -f docker-compose.wordpress.yml restart $container 
fi

