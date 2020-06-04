# Trabajo Fin de Máster DDoS Attacks

En tal caso ajustamos el parámetro del kernel vm.max_map_count:


vi /etc/sysctl.conf

vm.max_map_count = 262144


Configuramos Elasticsearch para que se bindee a todas las interfaces de red y opere en modo mononodo:

vi /etc/elasticsearch/elasticsearch.yml
network.host: 0.0.0.0
discovery.seed_hosts: []

Filtramos el tráfico de red para que solo se tenga acceso al Elasticsearch desde Logstash y Kibana:


```
iptables -I INPUT 1 -p tcp --dport 9200 -j DROP
iptables -I INPUT 1 -p tcp --dport 9200 -s LOGSTASHSERVER -j ACCEPT
iptables -I INPUT 1 -p tcp --dport 9200 -s KIBANASERVER -j ACCEPT
```



Filtramos el tráfico para que solo el servidor web pueda enviarnos logs a procesar:
```
iptables -I INPUT 1 -p tcp --dport 5044 -j DROP
iptables -I INPUT 1 -p tcp --dport 5044 -s KIBANASERVER -j ACCEPT
```

## Ejecución de script para ejecutar la orquestación de contenedores
Lanzar la orquestación
```console
$ ./script up
```
Parar la orquestación
```console
$ ./script stop
```
Borrar información de la orquestación
```console
$ ./script down
```
La ejecución del script tendrá la unificación de dos orquestaciones de contenedores, realizando la tarea de unificar la estructura de **SIEM** junto a la del **WAF** y la instalación del **WordPress** junto su **WebServer**.
```
docker-compose -f docker-compose.siem.yml -f docker-compose.waf.yml up -d
```

### Creación de un index pattern via Kibana API
```console
curl -XPOST -D- 'http://192.168.2.76:5601/api/saved_objects/index-pattern' \
    -H 'Content-Type: application/json' \
    -H 'kbn-version: 7.7.0' \
    -d '{"attributes":{"title":"logstash-*","timeFieldName":"@timestamp"}}' \
-u 'tfmddos:tfmdd0s2020'
```

### IPTABLES
TCP_PORTS: A list of TCP Ports which we should accept all traffic to
HOSTS: A list of hosts for which we should accept all traffic

any other traffic is DROPped.

example usage:

```
$ docker run --name firewall -e TCP_PORTS=22 -e HOSTS=172.12.1.1/32 --rm -ti --cap-add=NET_ADMIN iptables
```