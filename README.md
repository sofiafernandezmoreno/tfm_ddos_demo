# Trabajo Fin de Máster DDoS Attacks

Antes de comenzar se debe asignar la siguiente configuración, ajustando el parámetro del kernel vm.max_map_count:
```
vi /etc/sysctl.conf

vm.max_map_count = 262144
```
Además de algunas configuraciones del kernel que permiten mejorar la performance y mitigar mejor los ataques de DDoS.

Casi todas las distros actuales, o mejor, desde el kernel Linux v3.12, iptables incorpora un módulo denominado **SYNPROXY**. **SYNPROXY** es un módulo de netfilter, en el núcleo Linux, y está optimizado para gestionar millones de paquetes por segundo utilizando toda la CPU disponible sin tener problemas de bloqueos de concurrencia entre conexiones.

Estas configuraciones tienden a maximizar el rendimiento del sistema bajo un ataque de DDoS, y mejora la efectividad de las reglas de iptables que establezcamos. 

Configuramos Elasticsearch (`/usr/share/elasticsearch/elasticsearch.yml`) para que se envie a todas las interfaces de red y opere en modo mononodo:

```
network.host: 0.0.0.0
discovery.seed_hosts: []
```
## FIREWALL (IPTABLES)

Se dispone del módulo del kernel denominado `nf_conntrack`, que puede ayudar a mitigar muchos ataques basados en **TCP** que no usan paquetes con **flag SYN**.

Esto incluye los ataques de **ACK** o **SYN-ACK** y ataques basados en los flags falsos o erróneos de TCP.

```
net.netfilter.nf_conntrack_max = 10000000 
net.netfilter.nf_conntrack_tcp_loose = 0 
net.netfilter.nf_conntrack_tcp_timeout_established = 1800 
net.netfilter.nf_conntrack_tcp_timeout_close = 10 
net.netfilter.nf_conntrack_tcp_timeout_close_wait = 10 
net.netfilter.nf_conntrack_tcp_timeout_fin_wait = 20 
net.netfilter.nf_conntrack_tcp_timeout_last_ack = 20 
net.netfilter.nf_conntrack_tcp_timeout_syn_recv = 20 
net.netfilter.nf_conntrack_tcp_timeout_syn_sent = 20 
net.netfilter.nf_conntrack_tcp_timeout_time_wait = 10 
```


### Docker IPTABLES
```
iptables -I DOCKER-USER -i eth0 ! -s 127.0.0.1 -j DROP
```
### Bloquear paquetes inválidos
Lo primero es bloquear todos los paquetes inválidos, es decir, aquellos que no sean paquetes SYN (de establecimiento de conexión) y que tampoco pertenezcan a ninguna conexión activa:

```
iptables -t mangle -A PREROUTING -m conntrack --ctstate INVALID -j DROP
```
### Bloquear paquetes nuevos que no son SYN
Ahora a bloquear todos los paquetes que no pertenecen a ninguna conexión establecida, y además no usan el flag SYN. Similar a la anterior, pero captura algunos paquetes que no filtra la regla anterior:

```
iptables -t mangle -A PREROUTING -p tcp ! --syn -m conntrack --ctstate NEW -j DROP
```

### Bloquear valores anoramales de MSS
Vamos a bloquear ahora paquetes nuevos, es decir, aquellos que contengan el flag SYN activado, pero que además tengan un valor de MSS (Maximum Segment Size) fuera de lo normal, ya que los paquetes SYN suelen ser pequeños, y paquetes SYN grandes podrían indicar inundación de SYN (SYN flood):

```
iptables -t mangle -A PREROUTING -p tcp -m conntrack --ctstate NEW -m tcpmss ! --mss 536:65535 -j DROP
```
### Bloquear paquetes con flags erróneos
Ahora algunas reglas para filtrar paquetes con flags erróneos, aquellos flags o combinaciones de los mismos que un paquete normal no utilizaría.

```
iptables -t mangle -A PREROUTING -p tcp --tcp-flags FIN,SYN,RST,PSH,ACK,URG NONE -j DROP 
iptables -t mangle -A PREROUTING -p tcp --tcp-flags FIN,SYN FIN,SYN -j DROP 
iptables -t mangle -A PREROUTING -p tcp --tcp-flags SYN,RST SYN,RST -j DROP 
iptables -t mangle -A PREROUTING -p tcp --tcp-flags FIN,RST FIN,RST -j DROP 
iptables -t mangle -A PREROUTING -p tcp --tcp-flags FIN,ACK FIN -j DROP 
iptables -t mangle -A PREROUTING -p tcp --tcp-flags ACK,URG URG -j DROP 
iptables -t mangle -A PREROUTING -p tcp --tcp-flags ACK,FIN FIN -j DROP 
iptables -t mangle -A PREROUTING -p tcp --tcp-flags ACK,PSH PSH -j DROP 
iptables -t mangle -A PREROUTING -p tcp --tcp-flags ALL ALL -j DROP 
iptables -t mangle -A PREROUTING -p tcp --tcp-flags ALL NONE -j DROP 
iptables -t mangle -A PREROUTING -p tcp --tcp-flags ALL FIN,PSH,URG -j DROP 
iptables -t mangle -A PREROUTING -p tcp --tcp-flags ALL SYN,FIN,PSH,URG -j DROP 
iptables -t mangle -A PREROUTING -p tcp --tcp-flags ALL SYN,RST,ACK,FIN,URG -j DROP
```

### Bloquear paquetes de subredes privadas
Esto es importante para evitar el spoofing o inundación de tráfico por parte de atacantes. Estas reglas bloquean tráfico que proviene de direcciones IP’s privadas, ya que usualmente en la interfaz WAN no se recibe tráfico privado, sino aquel proveniente de direcciones IP’s públicas.

```
iptables -t mangle -A PREROUTING -s 224.0.0.0/3 -j DROP 
iptables -t mangle -A PREROUTING -s 169.254.0.0/16 -j DROP 
iptables -t mangle -A PREROUTING -s 172.16.0.0/12 -j DROP 
iptables -t mangle -A PREROUTING -s 192.0.2.0/24 -j DROP 
iptables -t mangle -A PREROUTING -s 192.168.0.0/16 -j DROP 
iptables -t mangle -A PREROUTING -s 10.0.0.0/8 -j DROP 
iptables -t mangle -A PREROUTING -s 0.0.0.0/8 -j DROP 
iptables -t mangle -A PREROUTING -s 240.0.0.0/5 -j DROP 
iptables -t mangle -A PREROUTING -s 127.0.0.0/8 ! -i lo -j DROP
```

Se asume que el equipo utiliza como dirección de loopback una del rango 127.0.0.0/8.

### Bloquear tráfico ICMP
Bloqueamos todo el tráfico ICMP entrante. Si bien algunos tipos de mensajes ICMP pueden llegar a ser útiles en caso de congestión de red o fragmentación, en general no suelen haber inconvenientes con bloquear todo el tráfico ICMP entrante con una regla similar a esta:
```
iptables -t mangle -A PREROUTING -p icmp -j DROP
```

Esta regla, además de bloquear el ping, también bloquea los paquetes de inundación icmp, icmp de fragmentación, y por supuesto, el ping flood, o «Ping de la muerte» (Ping of Death).

### Bloquear tráfico por cantidad de conexiones
Otra regla interesante es la que permite bloquear a equipos que superan un umbral determinado de cantidad de conexiones establecidas. Por ejemplo, si un host en Internet establece 85 conexiones contra el puerto 80 de nuestro servidor web, seguramente sea un tipo de ataque, y podemos bloquearlo con algo como esto:

```
iptables -A INPUT -p tcp -m connlimit --connlimit-above 85 -j REJECT --reject-with tcp-reset
```

### Bloquear tráfico por cantidad de conexiones por unidad de tiempo
Otro punto importante es el de limitar la cantidad de conexiones por unidad de tiempo, y por ráfaga, desde una misma dirección IP. Esto es interesante ya que muchas veces un atacante intentará inundar de tráfico nuestros servidores intentando establecer muchas conexiones. Así, por ejemplo, si quisiéramos limitar a que una máquina remota pueda establecer como máximo 50 conexiones por segundo, con una ráfaga de 18 conexiones entre segundos, podríamos crear dos reglas en este orden:

```
iptables -A INPUT -p tcp -m conntrack --ctstate NEW -m limit --limit 50/s --limit-burst 18 -j ACCEPT 
iptables -A INPUT -p tcp -m conntrack --ctstate NEW -j DROP
```

### Bloquear paquetes fragmentados
Adicionalmente, una buena técnica es la de bloquear también los paquetes fragmentados. Normalmente no es necesario, pero a veces la inundación de paquetes UDP fragmentados pueden consumir mucho ancho de banda y producir una denegación de servicio. Para mitigar esto podemos descartar todo el tráfico fragmentado con algo así:

```
iptables -t mangle -A PREROUTING -f -j DROP
```

### Bloquear tráfico TCP RST
Por otro lado, una buena idea puede ser limitar también los floods de paquetes taggeados con el flag de reset RST en TCP, aunque acá podría necesitarse un análisis más profundo:

```
iptables -A INPUT -p tcp --tcp-flags RST RST -m limit --limit 4/s --limit-burst 4 -j ACCEPT 
iptables -A INPUT -p tcp --tcp-flags RST RST -j DROP
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

## WORDPRESS
### Load balancer and web server


Configuración del acelerador NGINX Throttle
Utilice el módulo 'limit_req' para limitar las solicitudes excesivas de una IP o un URI específico, por ejemplo, procesar 100 solicitudes por segundo de una IP.
```
# throttle setting example
limit_req_zone $binary_remote_addr zone=by_ip:10m rate=200r/s;
limit_req_zone $request_uri zone=by_uri:10m rate=200r/s;

# limit_req_zone : Declare a zone to limit the request
# binary_remote_addr : Client IP based limit
# request_uri : URI based limit
# share memory assign : 10M
# rate : If there are more than 200 requests per second, further requests will be limited
```
Luego, usamos la directiva `limit_req` para limitar la velocidad de las conexiones a una ubicación o archivo en particular.

```
location / {
    proxy_pass         http://wordpress:80;
    proxy_redirect     off;
    limit_req zone=one;

}
```
Ajustaremos gradualmente el proceso de trabajo y las conexiones de trabajo a un valor más alto o más bajo para manejar los ataques DDoS.
```
events { 
    worker_connections 50000; 
}
 ```


Las conexiones lentas pueden representar un intento de mantener las conexiones abiertas durante mucho tiempo. Como resultado, el servidor no puede aceptar nuevas conexiones.

La directiva `client_body_timeout` define cuánto tiempo espera Nginx entre las escrituras del cuerpo del cliente y  `client_header_timeout` significa cuánto tiempo Nginx espera entre las escrituras del encabezado del cliente. Ambos están configurados en 5 segundos.

```
client_body_timeout 5s;
client_header_timeout 5s;
```
#### Limitar el tamaño de las solicitudes
Los grandes valores de búfer o el gran tamaño de las solicitudes HTTP facilitan los ataques DDoS. Por lo tanto, limitamos los siguientes valores de búfer en el archivo de configuración de Nginx para mitigar los ataques DDoS.
```
client_body_buffer_size 200K;
client_header_buffer_size 2k;
client_max_body_size 200k;
large_client_header_buffers 3 1k;
```
Con `deny` denegamos la IP de la cual podemos identificar el ataque.
```
deny 192.168.1.103
```

Cuando se utiliza Nginx como balanceador de carga, es posible ajustar los parámetros para limitar el número de conexiones para cada servidor:
```
upstream wordpress-web {
    server 192.168.2.56:80 max_conns=100;
    queue 20 timeout=10s;
}
```
Aquí la directiva `max_conns` especifica el número de conexiones que Nginx puede abrir para el servidor. La directiva de `queue` limita el número de solicitudes que se han puesto en cola cuando todos los servidores de este grupo han alcanzado el límite de conexión. Finalmente, la directiva de `timeout` especifica cuánto tiempo se puede retener una solicitud en la cola.

Activamos en el archivo `wp-config.php`
```
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
```




```
docker inspect -f '{{.Name}} - {{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' $(docker ps -aq) 

/proxy_wordpress - 192.168.2.56
/wordpress - 192.168.2.11
/db_backup - 192.168.2.10
/logstash - 192.168.2.9
/suricata - 
/auditbeat - 192.168.2.7
/metricbeat - 192.168.2.8
/heartbeat - 192.168.2.6
/iptables - 192.168.2.86
/kibana - 192.168.2.5
/elasticsearch - 192.168.2.4
/filebeat - 192.168.2.2
/db_wordpress - 192.168.2.3
/waf - 192.168.2.66
/load_balancer_monitoring - 192.168.2.76

```