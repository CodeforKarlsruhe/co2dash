<template>

  <vue-echarts :option="option"  class="chart" ref="chart" />

</template>

<script>


import { VueEcharts } from 'vue3-echarts';

import { ref } from "vue"

//  npm install  vue-window-size
import { useWindowSize } from 'vue-window-size';

const chartOption = {
  legend: {
    show:false
  },
  grid:
    {
    left: '3%',
    right: '4%',
    top: '15%',
    bottom: '10%',
    containLabel: true
  },
   graphic: [
    {
      type: 'group',
      left: "left", //'10%',
      top: "top", // "center"
      children: [
        {
          type: 'text',
          z: 100,
          left: 'left', // center
          top: 'top', // middle
          style: {
            fill: '#333',
            width: 350,
            overflow: 'break',
            text: "Das Paris Ziel von 1,5°C ist sehr ambitioniert und bedeutet einen verbleibenden " + 
                "jährlichen CO2 pro Kopf Ausstoß für Karlsruhe bei 2,6 Tonnen pro Person bis 2040 (grüne Linie).\n\n" + 
                "Die Stadt favorisiert bisher das 1,75°C Ziel, bei dem noch 4,1 Tonnen pro Person bis 2040 verbleiben (rote Linie).\n",
            font: '16px sans-serif'
          }
        }
      ]
    },
   ],
  xAxis: 
    {
      type: 'category',
      show:false,
    },
  yAxis:
    {
      type: 'category',
      show:false,
    },
  series: [
    {
      name: 'Info',
      type: 'line',
      data: []
    }
  ]   
};


export default {
  name: 'InfoChart',
      components: {
        VueEcharts,
    },
    data ()  {
        return {
        }
    },
    watch: {
      wheight(n) {
        console.log("h",n)
        if (this.chart) {
          //console.log(this.chart)
          //console.log(this.chart.chart)
          this.chart.chart.resize({height:Math.round(n/3)})
        }
      }
    },
    mounted() {
      this.wheight++ // trigger resize
    },
    setup () {
        const chart = ref({})
        const option = ref(chartOption)
        //const height = ref()
        const { width, height } = useWindowSize();
        return { chart, option, wwidth: width, wheight:height }
    }
}
</script>

<style scoped>
.chart {
    height:200px;
    max-width:100%;
    margin-left:auto;
    margin-right:auto;
}
</style>
