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

import axios from 'axios'

const chartOption = {
  tooltip: {
    trigger: 'axis',
    axisPointer: {
      type: 'shadow'
    }
  },
  legend: {
    orient: 'vertical',
    right: 10,
  },
  grid:
    {
    left: '3%',
    right: '40%',
    top: '15%',
    bottom: '10%',
    containLabel: true
  },
  xAxis:
    {
      type: 'category',
      name: 'Klimabilanz Karlsruhe 2022',
      nameLocation:"center",
      nameGap: 20,
      data: ["CO2APP","Offiziell"],
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
    {
      name: 'Sector4',
      type: 'bar',
      stack: 'total',
      data: [3.9,5.3],
      label: {
      },
    },
    {
      name: 'Sector5',
      type: 'bar',
      stack: 'total',
      data: [3.9,5.3],
      label: {
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
          timer: null,

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
    methods: {
        async readBalance() {
            //if (!this.mapLoaded) return
            /*
            this.option.series[1].data = [Math.random()*10,Math.random()*20];
            this.option.series[2].data = [Math.random()*10,Math.random()*20];
            this.chart.setOption(this.option)
            console.log("update")
            */
            let balance
            let defaults
            let urls = ["/rest.php?table=balance","http://localhost:9000/rest.php?table=balance"]
            for (let url in urls) {
                try {
                    console.log(urls[url])
                    const r = await axios.get(urls[url])
                    balance = await r.data
                    console.log("balance Loaded",balance)
                    break;
                } catch (e) {
                    console.log("Axios failed: ",e.message)
                }
            }
            urls = ["/rest.php?table=defaults","http://localhost:9000/rest.php?table=defaults"]
            for (let url in urls) {
                try {
                    console.log(urls[url])
                    const r = await axios.get(urls[url])
                    defaults = await r.data
                    console.log("defaults Loaded",defaults)
                    break;
                } catch (e) {
                    console.log("Axios failed: ",e.message)
                }
            }
            if ((balance == undefined) || (balance.sector1 == undefined) 
            || (defaults == undefined) || (defaults.sector1 == undefined)) {
              console.log("No data")
              return
            }
            // set data
            const sums = [0,0]
            this.option.series[1].data = [parseFloat(balance.sector1),parseFloat(defaults.sector1)]
            this.option.series[2].data = [parseFloat(balance.sector2),parseFloat(defaults.sector2)]
            this.option.series[3].data = [parseFloat(balance.sector3),parseFloat(defaults.sector3)]
            this.option.series[4].data = [parseFloat(balance.sector4),parseFloat(defaults.sector4)]
            this.option.series[5].data = [parseFloat(balance.sector5),parseFloat(defaults.sector5)]
            sums[0] = parseFloat(balance.sector1) + parseFloat(balance.sector2) + 
              parseFloat(balance.sector3) + parseFloat(balance.sector4) + parseFloat(balance.sector5)
            sums[1] = parseFloat(defaults.sector1) + parseFloat(defaults.sector2) + 
              parseFloat(defaults.sector3) + parseFloat(defaults.sector4) + parseFloat(defaults.sector5)
            this.option.series[0].data = sums
            this.chart.setOption(this.option)
            console.log("Balance update")
        }
    },
    async beforeMount() {
        this.timer = setInterval(this.readBalance, 10000)
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
