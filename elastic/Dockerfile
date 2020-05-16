FROM docker.elastic.co/elasticsearch/elasticsearch:7.7.0
MAINTAINER sfernandez
ADD config/ /home/config/
RUN cd /home/config/ && \
    cp elasticsearch.yml /usr/share/elasticsearch/config