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