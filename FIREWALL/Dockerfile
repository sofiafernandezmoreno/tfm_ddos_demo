FROM alpine
MAINTAINER sfernandez
RUN apk --update add iptables bash sudo
ADD conf/sysctl.conf /etc/sysctl.conf
COPY iptables.sh /iptables.sh

CMD /iptables.sh