FROM alpine

RUN \
  apk --update add iptables bash

COPY iptables /iptables.sh

CMD /iptables.sh