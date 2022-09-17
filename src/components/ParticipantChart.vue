<template>
  <!-- need class for container div to set 100% height 
  (div needed for v-if on chart) 
  -->
  <div  v-if="isMapLoaded">
  <vue-echarts :option="option" class="chart"  ref="chart" />
  </div>
  <div class="loading chart"  v-else>
  Map not loaded yet
  </div>

</template>

<script>

//import * as echarts from 'echarts';
import { VueEcharts } from 'vue3-echarts';
import axios from 'axios'


import { ref } from 'vue';


export default {
    name:"ParticipantChart",
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
    methods: {
        async readDistricts() {
            //const r = await axios.get("/data/districts-mult.json")
            const urls = ["/rest.php?table=districts",
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
                    this.option.yAxis.data = []
                    this.option.series[0].data = []
                    this.option.series[1].data = []
                    // sort array to have highest value at bottom (first)
                    data.sort((a,b)=>{return a.name < b.name}).forEach(x => {
                        this.option.yAxis.data.push(x.name)
                        this.option.series[0].data.push(parseInt(x.users))
                        this.option.series[1].data.push(parseInt(x.mults))
                    })
                    if (this.isMapLoaded) this.chart.setOption(this.option)
                    //this.option.yAxis.data = ydata
                    break;
                } catch (e) {
                    console.log("Axios failed: ",e.message)
                }
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
                left: 'center',
                },
                grid: {
                    left: '3%',
                    top: '15%',
                    bottom: '5%',
                    /*
                    right: '4%',
                    */
                    containLabel: true
                },
                legend: {
                    /*
                    orient: 'vertical',
                    right: 10,
                    top: 'center'
                    */
                },
                tooltip: {
                    trigger: 'axis',
                    axisPointer: {
                    type: 'shadow'
                    },
                    position: ["50%",10],

                },
                xAxis: {
                    type: 'value',
                    min:0,
                    //boundaryGap: [0, 0.01]
                },
                yAxis: {
                    type: 'category',
                    data: [],
                    interval:0,
                    axisLabel: {
                        fontSize: 10,
                        //formatter: '{value} t CO2'
                    },
                    axisTick: {
                        interval: 0
                    },
                },
                series: [
                    {
                        name: 'Teilnehmer:Innen',
                        type: 'bar',
                        data: []
                   },
                    {
                        name: 'Mitstreiter:Innen',
                        type: 'bar',
                        data: []
                   },
                ]
            }
          }
    },
    async beforeMount() {
        this.timer = setInterval(this.readDistricts, 5000)
        await this.readDistricts();
        this.mapLoaded = true
    },
    setup(){
        const chart = ref()
        const mapLoaded = ref(false)
        return {chart, mapLoaded}
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.default {
    height:200px;
}
.chart {
    height:500px;
    width:100%;
    margin-left:auto;
    margin-right:auto;
}
</style>
