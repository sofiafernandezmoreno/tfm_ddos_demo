# Trabajo Fin de Máster DDoS Attacks

Antes de comenzar se debe asignar la siguiente configuración, ajustando el parámetro del kernel vm.max_map_count:
```
vi /etc/sysctl.conf

vm.max_map_count = 262144
```

Configuramos Elasticsearch (`/usr/share/elasticsearch/elasticsearch.yml`) para que se envie a todas las interfaces de red y opere en modo mononodo:

```
network.host: 0.0.0.0
discovery.seed_hosts: []
```
Filtramos el tráfico de red para que solo se tenga acceso al **Elasticsearch** desde **Logstash** y **Kibana**:


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
La ejecución del script tendrá la unificación de cuatro orquestaciones de contenedores, realizando la tarea de unificar la estructura del **FIREWALL** y **SIEM+IDS+IPS** junto a la del **WAF** y la instalación del **WordPress** junto su **WebServer**, todas desde la misma subred.
```
docker-compose -f docker-compose.siem.yml -f docker-compose.waf.yml -f docker-compose.iptables.yml -f docker-compose.wordpress.yml up -d
```

