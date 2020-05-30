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

## IPTABLES