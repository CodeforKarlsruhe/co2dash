<template>
  <!-- need class for container div to set 100% height 
  (div needed for v-if on chart) 
  -->
  <div class="map" v-if="isMapLoaded">
  <vue-echarts :option="option" class="chart"  ref="chart" />
  </div>
  <div class="loading map"  v-else>
  Loading ...
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
                return this.mapLoaded && this.dataLoaded
            }
        }
    },
    data ()  {
        return {
            timer: null,
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
                    //console.log("Geo:", params.value)
                    const value = parseFloat(params.value).toFixed(3)
                    const valueStr = String(value).replace(",","").replace(".",",")
                    //console.log("Geo str:", value, " - ", valueStr)
                    return params.seriesName + '<br/>' + params.name + ': ' + valueStr;
                },
                position: [10, 10],
                },
                visualMap: {
                    left: 'left',
                    top:"center",
                    // piecewise
                    type: "piecewise",
                    /*
                    import seaborn as sns
                    p = sns.color_palette("Greens",6)
                    c = [f"#{int(255*x[0]):02x}{int(255*x[1]):02x}{int(255*x[2]):02x}" for x in p]
                    ["#ff0000","#0000ff",'#e1f3db', '#bbe4b5', '#8ed08b', '#56b567', '#2b944b', '#04702f']
                    ['#006829', '#1a833e', '#36a055', '#5cb86a', '#88cd86', '#addea7',
                    */
                    pieces: [
                        // Range of a piece can be specified by property min and max,
                        // where min will be set as -Infinity if ignored,
                        // and max will be set as Infinity if ignored.
                        {max: -.0001, color:"#ff4400"},
                        {min: -.0001,max: .001, color:"#cccc44"},
                        {min: .001,max: .01, color:"#addea7"},
                        {min: .01,max: .05, color:"#88cd86"},
                        {min: .05,max: .5, color:"#5cb86a"},
                        {min: .5,max: 1, color:"#36a055"},
                        {min: 1,max: 2, color:"#1a833e"},
                        {min: 2, color:"#006829"},
                    ],
                    itemGap: 3,
                    showLabel: true,
                    formatter: function (value, value2) {
                        if (!isFinite(value)) return "< " + String(value2)
                        if (!value2 || !isFinite(value2)) return "> " + String(value)
                        return String(value) + ' - ' + String(value2)
                    },
                    text: ["",'[CO2 t/Person]'],
                    // continous (default)
                    /*
                    min: -10,
                    max: 10,
                    inRange: {
                        color:
                        ['#ff0000', '#ff3300', '#ff6600', '#ff9900', '#ffcc00', '#ffff00', '#cce600', '#99cc00', '#66b300', '#339900']
                        //['#ff0000', '#cc0033', '#990066', '#660099', '#3300cc', '#0000ff', '#001acc', '#003399', '#004d66', '#006633']
                    },
                    text: ['Viel', 'Wenig\n[kg/Person * 100]'],
                    */
                    orient: "vertical",
                    align: "left",
                    calculable: false,
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
                    itemStyle: {
                        borderColor: "#000",
                        borderWidth: 1,
                    },
                    data:
                    [
                        /*
                        {'name': 'Innenstadt-Ost', 'value': -7},
                        {'name': 'Innenstadt-West', 'value': 71},
                        {'name': 'Südstadt', 'value': 19}, 
                        {'name': 'Südweststadt', 'value': 23},
                        {'name': 'Weststadt', 'value': -47},
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
                        {'name': 'Rintheim', 'value': -25},
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
                        */
                    ]
                   }
                ]
            }
          }
    },
    methods: {
        async readDistricts() {
            if (!this.mapLoaded) {
                await axios.get("/data/ka.geojson").then((r) => {
                    const geo = r.data
                    console.log(geo) 
                    echarts.registerMap('KA', {geoJSON: geo})
                    this.mapLoaded = true
                    console.log("Loaded",this.mapLoaded)
                    this.readDistricts()
                    })
            }

            //const r = await axios.get("/data/districts-mult.json")
            const urls = [
                "/rest.php?table=districts",
                "http://localhost:9000/rest.php?table=districts",
                "https://co2dash.karlsruhe.de/rest.php?table=districts"
            ]
            for (let url in urls) {
                try {
                    console.log(urls[url])
                    const r = await axios.get(urls[url])
                    const data = await r.data
                    if (typeof(data) == "string") {
                      throw ("districts invalid")
                    } 
                    console.log("Data Loaded",data)
                    const mapData = []
                    data.forEach(x => {
                        //let value = parseFloat(x.savingTotal)*100
                        let value = parseFloat(x.savingTotal)
                        // limit 
                        value = value > 11 ? 11 : value
                        value = value < -11 ? -11 : value
                        mapData.push({"name":x.name,"value":value})
                    })
                    this.option.series[0].data = mapData
                    this.dataLoaded = true
                    console.log(this.chart)
                    this.chart.setOption(this.option)
                    break;
                } catch (e) {
                    console.log("Axios failed: ",e.message)
                }
            }
        }
    },
    async beforeMount() {
        await this.readDistricts()
        this.timer = setInterval(this.readDistricts, 5000)
    },
    setup(){
        // https://echarts.apache.org/en/option.html#geo.map
        /*
        echarts.registerMap('USA', {geoJSON: map})
        console.log("Registered")
        */
        const chart = ref()
        const mapLoaded = ref(false)
        const dataLoaded = ref(false)
        //console.log("Mounted - Chart6:",chart6)
        //console.log("Mounted - Chart6-v:",chart6.value)
        //axios.get("/data/USA.json").then((r) => {
        //axios.get("/data/countries2.json").then((r) => {
        /*
        axios.get("/data/ka.geojson").then((r) => {
            const geo = r.data
            console.log(geo) 
            echarts.registerMap('KA', {geoJSON: geo})
            mapLoaded.value = true
            console.log("Loaded",mapLoaded.value)
            this.readDistricts()
            })
        */
        return {mapLoaded, dataLoaded, chart}
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
