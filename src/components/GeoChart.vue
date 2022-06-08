<template>
  <!-- need class for container div to set 100% height 
  (div needed for v-if on chart) 
  -->
  <div class="map" v-if="isMapLoaded">
  <vue-echarts :option="option" class="chart"  ref="chart" />
  </div>
  <div class="map"  v-else>
  Map not loaded yet
  </div>

</template>

<script>

import * as echarts from 'echarts';
import { VueEcharts } from 'vue3-echarts';
import axios from 'axios'


import { ref } from 'vue';


export default {
    name:"GeoChart",
    components: {
        VueEcharts, 
    },
    computed: {
        isMapLoaded: {
            get() {
                console.log("Getting map: ",this.mapLoaded)
                return this.mapLoaded
            }
        }
    },
    data ()  {
        return {
            option : {
                title: {
                show: false,
                text: 'nach Stadtteilen',
                left: 'center'
                },
                tooltip: {
                trigger: 'item',
                showDelay: 0,
                transitionDuration: 0.2,
                formatter: function (params) {
                    const value = (params.value + '').split('.');
                    const valueStr = value[0].replace(
                    /(\d{1,3})(?=(?:\d{3})+(?!\d))/g,
                    '$1,'
                    );
                    return params.seriesName + '<br/>' + params.name + ': ' + valueStr;
                }
                },
                visualMap: {
                    left: 'left',
                    top:"center",
                    min: 1,
                    max: 100,
                    inRange: {
                        color: [
                        '#313695',
                        '#4575b4',
                        '#74add1',
                        '#abd9e9',
                        '#e0f3f8',
                        '#ffffbf',
                        '#fee090',
                        '#fdae61',
                        '#f46d43',
                        '#d73027',
                        '#a50026'
                        ]
                    },
                },
                toolbox: {
                    show: false,
                },
                series: [
                {
                    name: 'Karlsruhe',
                    type: 'map',
                    roam: true,
                    map: 'KA',
                    emphasis: {
                    label: {
                        show: true
                    }
                    },
                    data:
                    [
                        {'name': 'Innenstadt-Ost', 'value': 7},
                        {'name': 'Innenstadt-West', 'value': 71},
                        {'name': 'Südstadt', 'value': 19}, 
                        {'name': 'Südweststadt', 'value': 23},
                        {'name': 'Weststadt', 'value': 47},
                        {'name': 'Nordweststadt', 'value': 40},
                        {'name': 'Oststadt', 'value': 1},
                        {'name': 'Mühlburg', 'value': 5},
                        {'name': 'Daxlanden', 'value': 9},
                        {'name': 'Knielingen', 'value': 9},
                        {'name': 'Grünwinkel', 'value': 52},
                        {'name': 'Oberreut', 'value': 52},
                        {'name': 'Beiertheim-Bulach', 'value': 63},
                        {'name': 'Weiherfeld-Dammerstock', 'value': 75},
                        {'name': 'Rüppurr', 'value': 90},
                        {'name': 'Waldstadt', 'value': 88},
                        {'name': 'Rintheim', 'value': 25},
                        {'name': 'Hagsfeld', 'value': 11}, 
                        {'name': 'Durlach', 'value': 66}, 
                        {'name': 'Grötzingen', 'value': 76}, 
                        {'name': 'Stupferich', 'value': 56},
                        {'name': 'Hohenwettersbach', 'value': 71},
                        {'name': 'Wolfartsweier', 'value': 14}, 
                        {'name': 'Grünwettersbach', 'value': 78}, 
                        {'name': 'Palmbach', 'value': 33},
                        {'name': 'Neureut', 'value': 77},
                        {'name': 'Nordstadt', 'value': 96}
                    ]
                   }
                ]
            }
          }
    },
    setup(){
        // https://echarts.apache.org/en/option.html#geo.map
        /*
        echarts.registerMap('USA', {geoJSON: map})
        console.log("Registered")
        */
        const mapLoaded = ref(false)
        //console.log("Mounted - Chart6:",chart6)
        //console.log("Mounted - Chart6-v:",chart6.value)
        //axios.get("/data/USA.json").then((r) => {
        //axios.get("/data/countries2.json").then((r) => {
        axios.get("/data/ka.geojson").then((r) => {
            const geo = r.data
            console.log(geo) 
            echarts.registerMap('KA', {geoJSON: geo})
            mapLoaded.value = true
            console.log("Loaded",mapLoaded.value)
            })

        return {mapLoaded}
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.map {
    height:200px;
}
.chart {
    /*height:400px;*/
    height:200px;
    /*height:100%;*/
    width:100%;
    margin-left:auto;
    margin-right:auto;
}
</style>
