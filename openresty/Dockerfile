FROM openresty/openresty:latest

LABEL maintainer="Sofía Fernández <chui274@gmail.com>"


RUN apt update \
        && apt install -y curl \
    && mkdir -p /usr/local/share/GeoIP && \
    cd /usr/local/share/GeoIP && \
    curl -fSL https://github.com/kubernetes/ingress-nginx/raw/master/images/nginx/rootfs/etc/nginx/geoip/GeoIP.dat -o GeoIP.dat && \
    curl -fSL https://github.com/kubernetes/ingress-nginx/raw/master/images/nginx/rootfs/etc/nginx/geoip/GeoIPASNum.dat -o GeoIPASNum.dat && \
    curl -fSL https://github.com/kubernetes/ingress-nginx/raw/master/images/nginx/rootfs/etc/nginx/geoip/GeoLiteCity.dat -o GeoLiteCity.dat \
    && find / -name ngx_http_geoip_module.so

CMD ["/usr/local/openresty/bin/openresty", "-g", "daemon off;"]
