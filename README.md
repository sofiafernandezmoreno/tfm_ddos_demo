# Restrinjir las conexiones al host Docker 
Tenga en cuenta que deberá cambiar `ext_if` para que se corresponda con la interfaz externa real de su host. En su lugar, podría permitir conexiones desde una subred de origen. La siguiente regla solo permite el acceso desde la subred `192.168.56.0/24`:
```console
iptables -I DOCKER-USER -i ext_if ! -s 192.168.56.0/24 -j DROP
```