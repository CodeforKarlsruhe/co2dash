<template>

  <vue-echarts v-if="dataLoaded" :option="option"  class="chart" ref="chart" />
  <div v-else class="loading chart">
    Loading ...
  </div>

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
    // type: plain or scroll
    // height: adjust for mobile
    //type: "scroll",
    //height: 50,
    orient: 'vertical',
    top: 20,
    width: "40%",
    left: "60%",
    right: 10,
  },
  grid:
    {
    left: '3%',
    right: '50%',
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
      data: ["CO2APP","Stadt"],
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
      barWidth: 3,
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
      name: 'Wohnen - Industrie+Priv',
      type: 'bar',
      //barWidth: 100,
      stack: 'total',
      data: [4,3.9],
      emphasis: {
         focus: "none", //'series',
      }
    },
    {
      name: 'Mobilität - Verkehr',
      type: 'bar',
      stack: 'total',
      data: [4.7,2.8]
    },
    {
      name: 'Ernährung - Gewerbe',
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
      name: 'Konsum - Konsum',
      type: 'bar',
      stack: 'total',
      data: [.9,.9],
      label: {
      },
    },
    {
      name: 'Allgemein - Stadt',
      type: 'bar',
      stack: 'total',
      data: [.9,.3],
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
      },
      wwidth(n) {
        console.log("h",n)
        if (this.chart) {
          //console.log(this.chart)
          //console.log(this.chart.chart)
          this.chart.chart.resize()
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
            // overwrite defaults with klimabilanz kennzahlen except sector4 (privater konsum)
            /* see https://transparenz.karlsruhe.de/dataset/7306d25b-8b18-445f-9351-6eec030c7753/resource/fd9de911-5142-4083-9d1b-5e09788022b3/download/treibhausgase.csv
            2019	Private Haushalte	real	548,4206526	BICO2BW-Bilanz	=>	1,80157961637392
            2019	Gewerbe+Sonstiges	real	574,8490281	BICO2BW-Bilanz	=>	1,88839768635168
            2019	Industrie	real	474,1086754	BICO2BW-Bilanz	=>	1,55746236305521
            2019	Stadt	real	47,19236622	BICO2BW-Bilanz	=>	0,155028452388383
            2019	Verkehr	real	706,5434952	BICO2BW-Bilanz	=>	2,32101827857732
            2019	Summe	real	2351,114218	BICO2BW-Bilanz	=>	7,72348639832332
            2019	Einwohner	Einwohner	304411	https://web5.karlsruhe.de/Stadtentwicklung/statistik/pdf/2020/2020-jahrbuch.pdf		
            */
            defaults.sector1 = (1.801 + 1.557) // Privat + Industrie, ~3.4
            defaults.sector2 = (2.32) // Verkehr
            defaults.sector3 = (1.889) // Gewerbe
            defaults.sector5 = (.155) // Stadt
            if ((balance == undefined) || (balance.sector1 == undefined) 
            || (defaults == undefined) || (defaults.sector4 == undefined)) {
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
        this.dataLoaded = true
        this.timer = setInterval(this.readBalance, 5000)
    },
    mounted() {
      this.wheight++ // trigger resize
    },
    setup () {
        const chart = ref({})
        const option = ref(chartOption)
        const dataLoaded = ref(false)
        //const height = ref()
        const { width, height } = useWindowSize();
        return { chart, option, dataLoaded, wwidth: width, wheight:height }
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
