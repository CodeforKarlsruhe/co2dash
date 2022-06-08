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
    data ()  {
        return {
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
                    }
                },
                xAxis: {
                    type: 'value',
                    min:0,
                    //boundaryGap: [0, 0.01]
                },
                yAxis: {
                    type: 'category',
                    data: []
                },
                series: [
                    {
                        name: 'Teilnehmer',
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
        try {
        const r = await axios.get("/data/districts-mult.json")
        const data = await r.data
        this.mapLoaded = true
        console.log("Data Loaded",data)
        data.forEach(x => {
            this.option.yAxis.data.push(x.name)
            this.option.series[0].data.push(x.value)
            this.option.series[1].data.push(x.mult)
        })
        //console.log(ydata)
        //this.option.yAxis.data = ydata
        } catch (e) {
            console.log("Axios failed: ",e.message)
        }
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
.map {
    height:200px;
}
.chart {
    height:200px;
    width:100%;
    margin-left:auto;
    margin-right:auto;
}
</style>
