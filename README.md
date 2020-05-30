# Trabajo Fin de Máster DDoS Attacks
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

# Importar dashboard Kibana

``` console
curl -X POST "localhost:5601/"localhost:5601/api/kibana/dashboards/import?exclude=index-pattern"" -H 'kbn-xsrf: true' -H 'Content-Type: application/json' -d'
{
  "objects": [
    {
      "id": "80b956f0-b2cd-11e8-ad8e-85441f0c2e5c",
      "type": "visualization",
      "updated_at": "2018-09-07T18:40:33.247Z",
      "version": 1,
      "attributes": {
        "title": "Count Example",
        "visState": "{\"title\":\"Count Example\",\"type\":\"metric\",\"params\":{\"addTooltip\":true,\"addLegend\":false,\"type\":\"metric\",\"metric\":{\"percentageMode\":false,\"useRanges\":false,\"colorSchema\":\"Green to Red\",\"metricColorMode\":\"None\",\"colorsRange\":[{\"from\":0,\"to\":10000}],\"labels\":{\"show\":true},\"invertColors\":false,\"style\":{\"bgFill\":\"#000\",\"bgColor\":false,\"labelColor\":false,\"subText\":\"\",\"fontSize\":60}}},\"aggs\":[{\"id\":\"1\",\"enabled\":true,\"type\":\"count\",\"schema\":\"metric\",\"params\":{}}]}",
        "uiStateJSON": "{}",
        "description": "",
        "version": 1,
        "kibanaSavedObjectMeta": {
          "searchSourceJSON": "{\"index\":\"90943e30-9a47-11e8-b64d-95841ca0b247\",\"query\":{\"query\":\"\",\"language\":\"lucene\"},\"filter\":[]}"
        }
      }
    },
    {
      "id": "90943e30-9a47-11e8-b64d-95841ca0b247",
      "type": "index-pattern",
      "updated_at": "2018-09-07T18:39:47.683Z",
      "version": 1,
      "attributes": {
        "title": "kibana_sample_data_logs",
        "timeFieldName": "timestamp",
        "fields": "<truncated for example>",
        "fieldFormatMap": "{\"hour_of_day\":{}}"
      }
    },
    {
      "id": "942dcef0-b2cd-11e8-ad8e-85441f0c2e5c",
      "type": "dashboard",
      "updated_at": "2018-09-07T18:41:05.887Z",
      "version": 1,
      "attributes": {
        "title": "Example Dashboard",
        "hits": 0,
        "description": "",
        "panelsJSON": "[{\"gridData\":{\"w\":24,\"h\":15,\"x\":0,\"y\":0,\"i\":\"1\"},\"version\":\"7.0.0-alpha1\",\"panelIndex\":\"1\",\"type\":\"visualization\",\"id\":\"80b956f0-b2cd-11e8-ad8e-85441f0c2e5c\",\"embeddableConfig\":{}}]",
        "optionsJSON": "{\"useMargins\":true,\"hidePanelTitles\":false}",
        "version": 1,
        "timeRestore": false,
        "kibanaSavedObjectMeta": {
          "searchSourceJSON": "{\"query\":{\"query\":\"\",\"language\":\"lucene\"},\"filter\":[]}"
        }
      }
    }
  ]
}
'

```