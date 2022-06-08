<template>

  <vue-echarts :option="option"  class="chart" ref="chart" />

</template>

<script>

//import * as echarts from 'echarts';

//var chartDom = document.getElementById('main');
//var myChart = echarts.init(chartDom);

import { VueEcharts } from 'vue3-echarts';

import { ref } from "vue"

//  npm install  vue-window-size
import { useWindowSize } from 'vue-window-size';

const chartOption = {
  tooltip: {
    trigger: 'axis',
    axisPointer: {
      type: 'shadow'
    }
  },
  legend: {},
  grid:
    {
    left: '3%',
    right: '4%',
    top: '15%',
    bottom: '10%',
    containLabel: true
  },
  xAxis: 
    {
      type: 'category',
      name: 'Jahr',
      nameLocation:"center",
      nameGap: 20,
      data: [2022,2025,2030,2035,2040],
      axisLine: {
        symbol: ["none",'arrow'],
      }
    },
  yAxis:
    {
      type: 'value',
      min: 0,
      max: 20,
      show: true,
      axisLine: {
        show: true, //false,
        symbol: ["none",'arrow'],
      },
      axisLabel: {
        show: true, //false,
        formatter: '{value} t CO2'
      },
    },
  series: [
    {
      name: 'Summe Sektoren',
      type: 'bar',
      //barWidth: 5,
      data: [12,7,0,0,0],
      markpoint: {
        symbol: "pin",
        symbolSize: 50,
        //symbolOffset: [0, '50%'],
        label: {
          show:true,
          position: 'right',
          distance: 2,
        },
        data: [
        {
            name: 'fixed x position',
            yAxis: 5,
            x: '50%'
          }, 
        ] 
      },
      markLine: {
        lineStyle: {
          type: 'dashed',
          width: 3,
        },
        data: [
          [{
            // Mark line with a fixed X position in starting point. This is used to generate an arrow pointing to maximum line.
              name: "Paris 1.5 Grad Ziel",
              lineStyle: {
                type: 'dashed',
                width: 7,
              },
              label: {
                show:true,
                position: "middle"
              },
              yAxis: 'max',
              xAxis: '2022'
          }, {
              yAxis: 0, //'min',
              xAxis: "2030", //"90%"
          }],
          [{
            // Mark line with a fixed X position in starting point. This is used to generate an arrow pointing to maximum line.
              name: "KA Klimaschutz",
              lineStyle: {
                type: 'dashed',
                width: 7,
              },
              label: {
                show:true,
                position: "middle"
              },
              yAxis: 'max',
              xAxis: '2022'
          }, {
              yAxis: 0, //'min',
              xAxis: "2040", //"90%"
          }],
          /*
          {
            name: 'A horizontal line with Y valued 10',
            lineStyle: {
              type: 'solid',
              width: 3,
            },
            label: {
              show:true,
              position: "middle"
            },
            yAxis: 10
          },
          {
            name: 'average line',
            label: {
              show:true,
              position: "end"
            },
            type: 'average'
          },
          */
        ]
      },

    },

  ]
};


export default {
  name: 'ParisChart',
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

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.chart {
    height:200px;
    max-width:100%;
    margin-left:auto;
    margin-right:auto;
}
</style>
