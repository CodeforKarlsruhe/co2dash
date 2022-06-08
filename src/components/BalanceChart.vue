<template>

<teleport to="head">
<meta name="description" content="Chart1"/>
</teleport>

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
      name: 'Bilanztyp 2022',
      nameLocation:"center",
      nameGap: 20,
      data: ["NOW","KA"],
      axisLine: {
        show: true,
        symbol: "none",
        lineStyle: {
          type: 'solid',
          width: 2,
          //color: "#00f",
          // ...
        }
      }
    },
  yAxis:
    {
      type: 'value',
      name: 'Emission',
      min: 0,
      max: 20,
      position: 'left',
      axisLabel: {
        formatter: '{value} t CO2'
      },
      axisLine: {
        show: true,
        symbol: ["none",'arrow'],
        lineStyle: {
          type: 'solid',
          width: 2,
          //color: "#00f",
          // ...
        }
      }
    },
  series: [
    {
      name: 'Summe Sektoren',
      type: 'bar',
      barWidth: 1,
      data: [12.6,12],
      label: {
        show:false,
      },
      markLine: {
        lineStyle: {
          type: 'dashed',
          width: 3,
        },
        symbol:["none","none"],
        data: [
          {
            lineStyle: {
              type: 'solid',
              color: "#f00",
              width: 3,
            },
            label: {
              show:true,
              formatter: "1,75C, 67% Wahrscheinlichkeit",
              fontSize: 14,
              position: "insideStartTop"
            },
            yAxis: 4.1,
          },
          {
            lineStyle: {
              type: 'solid',
              color: "#0f0",
              width: 3,
            },
            label: {
              show:true,
              fontSize: 14,
              formatter: "1,5C, 50%",
              position: "middle"
            },
            yAxis: 2.6,
          },
          {
            lineStyle: {
              type: 'solid',
              color: "#00f",
              width: 3,
            },
            label: {
              show:true,
              formatter: "Klimaneutral",
              fontSize: 14,
              position: "insideEndTop"
            },
            yAxis: .5,
          },
        ]
      }
    },
    {
      name: 'Sector1',
      type: 'bar',
      //barWidth: 100,
      stack: 'total',
      data: [4,3.9],
      emphasis: {
         focus: "none", //'series',
      }
    },
    {
      name: 'Sector2',
      type: 'bar',
      stack: 'total',
      data: [4.7,2.8]
    },
    {
      name: 'Sector3',
      type: 'bar',
      stack: 'total',
      data: [3.9,5.3],
      label: {
      /*
        normal: {
          // Options: 'left', 'right', 'top', 'bottom', 'inside', 'insideTop', 'insideLeft', 'insideRight', 'insideBottom', 'insideTopLeft', 'insideTopRight', 'insideBottomLeft', 'insideBottomRight'
          position: 'top',
          distance: 10,
          show: true,
          formatter: ['{b}'].join('\n'),
          backgroundColor: '#eee',
          borderColor: '#555',
          borderWidth: 2,
          borderRadius: 5,
          padding: 10,
          fontSize: 18,
          color: '#000'
        },
        */
      },
    },

  ]
};


export default {
  name: 'BalanceChart',
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
