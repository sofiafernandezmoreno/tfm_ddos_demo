#!/bin/bash

declare -a TCP_PORTS=22
declare -a HOSTS=192.168.2.0/24

iptables -P INPUT ACCEPT
iptables -F
iptables -A INPUT -i lo -j ACCEPT
iptables -A INPUT -m state --state ESTABLISHED,RELATED -j ACCEPT
 
# Allow incoming ssh only
for port in ${TCP_PORTS//,/ }; do
  echo Allowing traffic to TCP $port
  iptables -A INPUT -p tcp -s 0/0 --dport ${port} -m state --state NEW,ESTABLISHED -j ACCEPT
done

for host in ${HOSTS//,/ }; do
  echo Block invalid packets
  iptables -t mangle -A PREROUTING -m conntrack --ctstate INVALID -j DROP
  echo Block new packets != SYN
  iptables -t mangle -A PREROUTING -p tcp ! --syn -m conntrack --ctstate NEW -j DROP
  echo Block MSS values
  iptables -t mangle -A PREROUTING -p tcp -m conntrack --ctstate NEW -m tcpmss ! --mss 536:65535 -j DROP
  echo Block error flags
  iptables -t mangle -A PREROUTING -p tcp --tcp-flags FIN,SYN,RST,PSH,ACK,URG NONE -j DROP 
  iptables -t mangle -A PREROUTING -p tcp --tcp-flags FIN,SYN FIN,SYN -j DROP 
  iptables -t mangle -A PREROUTING -p tcp --tcp-flags SYN,RST SYN,RST -j DROP 
  iptables -t mangle -A PREROUTING -p tcp --tcp-flags FIN,RST FIN,RST -j DROP 
  iptables -t mangle -A PREROUTING -p tcp --tcp-flags FIN,ACK FIN -j DROP 
  iptables -t mangle -A PREROUTING -p tcp --tcp-flags ACK,URG URG -j DROP 
  iptables -t mangle -A PREROUTING -p tcp --tcp-flags ACK,FIN FIN -j DROP 
  iptables -t mangle -A PREROUTING -p tcp --tcp-flags ACK,PSH PSH -j DROP 
  iptables -t mangle -A PREROUTING -p tcp --tcp-flags ALL ALL -j DROP 
  iptables -t mangle -A PREROUTING -p tcp --tcp-flags ALL NONE -j DROP 
  iptables -t mangle -A PREROUTING -p tcp --tcp-flags ALL FIN,PSH,URG -j DROP 
  iptables -t mangle -A PREROUTING -p tcp --tcp-flags ALL SYN,FIN,PSH,URG -j DROP 
  iptables -t mangle -A PREROUTING -p tcp --tcp-flags ALL SYN,RST,ACK,FIN,URG -j DROP
  echo Block private subnet
  iptables -t mangle -A PREROUTING -s 224.0.0.0/3 -j DROP 
  iptables -t mangle -A PREROUTING -s 169.254.0.0/16 -j DROP 
  iptables -t mangle -A PREROUTING -s 172.16.0.0/12 -j DROP 
  iptables -t mangle -A PREROUTING -s 192.0.2.0/24 -j DROP 
  iptables -t mangle -A PREROUTING -s 192.168.0.0/16 -j DROP 
  iptables -t mangle -A PREROUTING -s 10.0.0.0/8 -j DROP 
  iptables -t mangle -A PREROUTING -s 0.0.0.0/8 -j DROP 
  iptables -t mangle -A PREROUTING -s 240.0.0.0/5 -j DROP 
  iptables -t mangle -A PREROUTING -s 127.0.0.0/8 ! -i lo -j DROP
  echo Block ICMP traffic
  iptables -t mangle -A PREROUTING -p icmp -j DROP
  echo Block taffic by size
  iptables -A INPUT -p tcp -m connlimit --connlimit-above 85 -j REJECT --reject-with tcp-reset
  echo Block taffic by size/time
  iptables -A INPUT -p tcp -m conntrack --ctstate NEW -m limit --limit 50/s --limit-burst 18 -j ACCEPT 
  iptables -A INPUT -p tcp -m conntrack --ctstate NEW -j DROP 
  echo Block fragment packets
  iptables -t mangle -A PREROUTING -f -j DROP
  echo Block TCP RST
  iptables -A INPUT -p tcp --tcp-flags RST RST -m limit --limit 4/s --limit-burst 4 -j ACCEPT 
  iptables -A INPUT -p tcp --tcp-flags RST RST -j DROP
  echo Allowing traffic from ${host}
  iptables -A INPUT -p tcp -s ${host} -m state --state NEW,ESTABLISHED -j ACCEPT
  echo Filter traffic from ${host} only access Elastic from Logstash and Kibana
  iptables -I INPUT 1 -p tcp --dport 9200 -j DROP
  iptables -I INPUT 1 -p tcp --dport 9200 -s ${host} -j ACCEPT
  iptables -I INPUT 1 -p tcp --dport 9200 -s ${host} -j ACCEPT
  echo Filter traffic from ${host} logs to process
  iptables -I INPUT 1 -p tcp --dport 5044 -j DROP
  iptables -I INPUT 1 -p tcp --dport 5044 -s ${host} -j ACCEPT
  echo Mitigate scan ports
  iptables -N port-scan 
  iptables -A port-scan -p tcp --tcp-flags SYN,ACK,FIN,RST RST -m limit --limit 1/s --limit-burst 3 -j RETURN 
  iptables -A port-scan -j DROP
done

iptables -P INPUT DROP
iptables -P FORWARD DROP
iptables -P OUTPUT ACCEPT



exec syslogd -n -O -