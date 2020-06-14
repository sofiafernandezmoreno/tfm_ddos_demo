FROM alpine
MAINTAINER sfernandez
RUN apk --update add iptables bash sudo
RUN mkdir -p /var/log/firewall
RUN touch /var/log/firewall/iptables.log
RUN chmod 600 /var/log/firewall/iptables.log && chown root:adm /var/log/firewall/iptables.log




ADD conf/sysctl.conf /etc/sysctl.conf
COPY iptables.sh /iptables.sh

CMD /iptables.sh