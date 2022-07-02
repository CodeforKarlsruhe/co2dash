<template>
  <ion-page>
    <ion-header class="topHeader">
      <ion-grid>
        <ion-row>
          <ion-col size="7" size-sm="4">
            <ion-img src="/img/kalogo.svg" class="logo"></ion-img>
          </ion-col>
          <ion-col size="5" size-sm="8">
            <div class="headlineContainer">
              <span class="headline">CO2 runter – mein Beitrag für KA</span>
            </div>
          </ion-col>
        </ion-row>
      </ion-grid>
      <!--      
      <ion-item>
      <ion-img src="/img/kalogo.svg" class="logo" slot="start"></ion-img>
      <ion-title slot="start">CO2App</ion-title>
      </ion-item>
      -->
    </ion-header>
    
    <ion-content :fullscreen="true"  class="onepnt5">
    <ion-grid>
      <ion-row class="toprow">
        <ion-col size="12" size-sm="4">
          <ion-card class="heading">
            <ion-card-header class="qr-header">
              <ion-card-title>Scannen Sie diesen Code</ion-card-title>
              </ion-card-header>
              <ion-card-content>
                <ion-img 
                  :src="qrcode" 
                  class="qr"
                >
                </ion-img>
                </ion-card-content>
          </ion-card>
        </ion-col>

        <ion-col size="12" size-sm="8">
          <ion-card class="heading">
            <!--
            <ion-card-header>
              <ion-card-title>CO2 runter – mein Beitrag für KA</ion-card-title>
              </ion-card-header>
              -->
              <ion-card-content >
                Wie viel CO2 kann ich durch einen veränderten Lebensstil einsparen und 
                wie viel macht es in meinem Stadtteil aus, wenn ich noch andere in meinem Umfeld davon überzeuge? 
                <p>
                Die zwei Aspekte zeigt spielerisch diese App, die auf einer vereinfachten Version des CO2 Rechners 
                des Bundesumweltamtes basiert.
                In dieser Klima-Challenge werden nicht nur die persönlichen Ambitionen zum Klimaschutz gezeigt, 
                sondern auch die Einsparungen, die erreicht werden können, wenn wir noch andere Menschen in 
                unserem Umfeld für den Klimaschutz begeistern. 
                Persönliche Maßnahmen für den Klimaschutz werden erfolgreicher, wenn wir auch andere Menschen davon überzeugen.
                </p>
                <p class="mitmachen">Machen Sie mit: Nutzen Sie die App über den QR-Code</p>
              </ion-card-content>
          </ion-card>
        </ion-col>

      </ion-row>

      <ion-row>
        <ion-col size="12" size-sm="4">
          <ion-card>
            <ion-card-header>
              <ion-card-title>Beteiligung</ion-card-title>
              </ion-card-header>
              <ion-card-content class="geochart">
                <ParticipantChart></ParticipantChart>
              </ion-card-content>
          </ion-card>
        </ion-col>

        <ion-col size="12" size-sm="8">

        <!--
         <ion-row>
          <ion-col size="12" size-sm="6">
            <div style='background:#f00;height:200px;width:100%;'>
            </div>
          </ion-col>
          <ion-col size="12" size-sm="6">
            <div style='background:#f00;height:200px;width:100%;'>
            </div>
          </ion-col>
         </ion-row>
         <ion-row>
          <ion-col size="12" size-sm="6">
            <div style='background:#f00;height:200px;width:100%;'>
            </div>
          </ion-col>
          <ion-col size="12" size-sm="6">
            <div style='background:#f00;height:200px;width:100%;'>
            </div>
          </ion-col>
         </ion-row>
        -->
         <ion-row>
          <ion-col size="12" size-sm="6">
          <ion-card>
            <ion-card-header>
              <ion-card-title>Einsparung nach Stadtteil</ion-card-title>
              </ion-card-header>
              <ion-card-content>
                <GeoChart></GeoChart>
              </ion-card-content>
          </ion-card>
          </ion-col>
          <ion-col size="12" size-sm="6">
          <ion-card>
            <ion-card-header>
              <ion-card-title>CO2 Bilanz</ion-card-title>
              </ion-card-header>
              <ion-card-content>
                <BalanceChart></BalanceChart>
              </ion-card-content>
          </ion-card>
          </ion-col>
         </ion-row>
         <ion-row>
          <ion-col size="12" size-sm="6">
          <ion-card>
            <ion-card-header>
              <ion-card-title>Ziele</ion-card-title>
              </ion-card-header>
              <ion-card-content class="infotext">
                <!--
                <InfoChart></InfoChart>
                -->
                <p>
                Das Paris Ziel von 1,5°C ist sehr ambitioniert und bedeutet einen verbleibenden 
                jährlichen CO2 pro Kopf Ausstoß für Karlsruhe bei 2,6 Tonnen pro Person 
                bis 2030 (grüne Linie, gestrichelt).
                </p>
                <p>
                Die Stadt favorisiert bisher das 1,75°C Ziel, bei dem noch 4,1 Tonnen pro Person 
                bis 2040 verbleiben (blaue Linie, gepunktet).
                </p>


              </ion-card-content>
          </ion-card>
          </ion-col>
          <ion-col size="12" size-sm="6">
          <ion-card>
            <ion-card-header>
              <ion-card-title>Paris Limits</ion-card-title>
              </ion-card-header>
              <ion-card-content>
                <ParisChart></ParisChart>
              </ion-card-content>
          </ion-card>
          </ion-col>
         </ion-row>

        </ion-col>
<!--
          <ion-card>
            <ion-card-header>
              <ion-card-title>CO2 Bilanz</ion-card-title>
              </ion-card-header>
              <ion-card-content class="co2chart">
                <BalanceChart></BalanceChart>
              </ion-card-content>
          </ion-card>
        </ion-col>
      </ion-row>

      <ion-row>

        <ion-col size="12" size-sm="4">
          <ion-card>
            <ion-card-header>
              <ion-card-title>Einsparungen</ion-card-title>
              </ion-card-header>
              <ion-card-content class="geochart">
                <GeoChart></GeoChart>
              </ion-card-content>
          </ion-card>
        </ion-col>

        <ion-col size="12" size-sm="8">
          <ion-card>
            <ion-card-header>
              <ion-card-title>Paris Limits</ion-card-title>
              </ion-card-header>
              <ion-card-content class="co2chart">
                <ParisChart></ParisChart>
              </ion-card-content>
          </ion-card>
        </ion-col>

-->
      </ion-row>

      <ion-row>
      <ion-col size="12">
      </ion-col>
            <ion-img src="/img/logo.svg" style="height:30px;"><a href="https://ok-lab-karlsruhe.de" target=_blank></a></ion-img>
            <ion-label>OK Lab Karlsruhe</ion-label>
      </ion-row>

    </ion-grid>
    </ion-content>
  </ion-page>
</template>

<script lang="ts">
import { IonContent, IonHeader, IonPage,
  IonGrid, IonRow, IonCol,
  IonImg,
  IonCard, IonCardTitle, IonCardHeader, IonCardContent, 
} from '@ionic/vue';
import { defineComponent } from 'vue';

import BalanceChart from '../components/BalanceChart.vue'
import ParisChart from '../components/ParisChart.vue'
//import InfoChart from '../components/InfoChart.vue'
import GeoChart from '../components/GeoChart.vue'
import ParticipantChart from '../components/ParticipantChart.vue'

import axios from 'axios'


export default defineComponent({
  name: 'HomePage',
  components: {
    IonContent,
    IonHeader,
    IonPage,
    IonGrid, IonRow, IonCol,
    IonImg,
    IonCard, IonCardTitle, IonCardHeader, IonCardContent, 
    BalanceChart,
    ParisChart,
    //InfoChart,
    GeoChart,
    ParticipantChart,
  },
  data () {
    return {
      qrcode: "/img/qrcode.png",
      timer: 0,
    }
  },
  methods: {
      async readQr() {
          const urls = ["/rest.php?table=qr","http://localhost:9000/rest.php?table=qr"]
          for (let url in urls) {
              try {
                  console.log(urls[url])
                  const r = await axios.get(urls[url])
                  const data = await r.data
                  console.log("Data Loaded",data)
                  this.qrcode = data.qr
                  break;
              } catch (e: any) {
                  console.log("Axios failed: ",e.message)
              }
          }
      }
  },
  async beforeMount() {
      this.timer = setInterval(this.readQr, 10000)
      await this.readQr();
  },

});
</script>

<style scoped>
#container {
}


ion-card-content ion-img::part(image) {
  min-height: 100px;
  max-height: 150px;
  /*
  min-height: 150px;
  max-height: 200px;
  */
}


ion-card-title {
  text-align: center;
}

ion-card-content, ion-card-content p {
    font-size: 16px;
}


/* custom */
.routelink, .submit {
  margin-left: 20%;
  margin-right: 20%;
}


.topHeader {
  background: white;
}
/*
.logo {
  height: 4rem;
  max-width: 40%;
  padding: .5rem 1rem .5rem .5rem;
}
*/
.logo {
  height: 3rem;
  width: 100%;
  padding: 0;
  object-position: left;
}

.headlineContainer {
  display: flex;
  justify-content: left;
  align-items: flex-end;
  height: 100%;
  font-size: 2rem;
  font-weight: bold;
}
.headline {
  margin-bottom: -.4rem;
}

.heading {
    height:200px;
}

.qr-header {
  padding-bottom: 0;
}

.mitmachen {
  font-size: 120%;
  font-weight: bold;
}

.infotext {
  height: 210px;
}
</style>
