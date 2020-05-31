FROM alpine

RUN \
  apk --update add iptables bash sudo

COPY iptables.sh /iptables.sh

CMD /iptables.sh