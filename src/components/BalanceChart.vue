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
  /*
  grid: {
    left: '3%',
    right: '4%',
    bottom: '3%',
    containLabel: true
  },
  */
  grid: [
    {
    left: '3%',
    right: '65%',
    bottom: '3%',
    containLabel: true
  },
    {
    left: '38%',
    right: '4%',
    bottom: '3%',
    containLabel: true
  },
  ],
  xAxis: [
    {
      type: 'category',
      name: 'Bilanztyp 2022',
      nameLocation:"center",
      nameGap: 20,
      data: ["UBA","NOW","KA"],
      gridIndex: 0,
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
    {
      type: 'category',
      name: 'Jahr',
      nameLocation:"center",
      nameGap: 20,
      data: [2022,2025,2030,2035,2040],
      gridIndex: 1 ,
      axisLine: {
        symbol: ["none",'arrow'],
      }
    }
  ],
  yAxis: [
    {
      type: 'value',
      gridIndex: 0,
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
    {
      type: 'value',
      min: 0,
      max: 20,
      gridIndex: 1,
      show: true,
      axisLine: {
        show: false,
      },
      axisLabel: {
        show: false,
        formatter: '{value} t CO2'
      },
    }
  ],
  series: [
    {
      name: 'Summe Sektoren',
      type: 'bar',
      barWidth: 1,
      data: [11.3,12.6,12],
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
              fontSize: 16,
              position: "middle"
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
              fontSize: 16,
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
              fontSize: 16,
              position: "middle"
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
      data: [5,4,3.9],
      emphasis: {
         focus: "none", //'series',
      }
    },
    {
      name: 'Sector2',
      type: 'bar',
      stack: 'total',
      data: [3.2,4.7,2.8]
    },
    {
      name: 'Sector3',
      type: 'bar',
      stack: 'total',
      data: [3.1,3.9,5.3],
      label: {
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
      },
    },

    // 
    {
      name: 'Summe Sektoren',
      type: 'bar',
      xAxisIndex: 1, yAxisIndex: 1 ,
      /*
      label: {
        normal: {
          // Options: 'left', 'right', 'top', 'bottom', 'inside', 'insideTop', 'insideLeft', 'insideRight', 'insideBottom', 'insideTopLeft', 'insideTopRight', 'insideBottomLeft', 'insideBottomRight'
          position: 'top',
          distance: 10,
          show: true,
          formatter: ['Summe'].join('\n'),
          backgroundColor: '#eee',
          borderColor: '#555',
          borderWidth: 2,
          borderRadius: 5,
          padding: 10,
          fontSize: 18,
          color: '#000'
        },
      },
      */
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
    /*height:400px;*/
    min-height:400px;
    height:100%;
    max-width:100%;
    margin-left:auto;
    margin-right:auto;
}
</style>
