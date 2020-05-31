# Trabajo Fin de Máster DDoS Attacks
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
La ejecución del script tendrá la unificación de dos orquestaciones de contenedores, realizando la tarea de unificar la estructura de **SIEM** junto a la del **WAF**
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