FROM owasp/modsecurity
COPY nginx.conf /etc/nginx/nginx.conf.template
COPY modsecurity_rules.conf /etc/modsecurity_rules.conf
COPY docker-entrypoint.sh /
ENTRYPOINT ["/docker-entrypoint.sh"]
CMD ["nginx", "-g", "daemon off;"]