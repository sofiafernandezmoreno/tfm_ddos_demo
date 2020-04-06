FROM docker.elastic.co/logstash/logstash:7.7.0
MAINTAINER sfernandez
ADD dist/ /home/dist

RUN cd /home/dist/ && \
    cp logstash.conf /usr/share/logstash/pipeline/logstash.conf 
    #chmod 775 /var/log/suricata/eve.json
