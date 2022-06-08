<template>
  <ion-page>
    <ion-header class="topHeader">
      <ion-grid>
        <ion-row>
          <ion-col size="7">
            <ion-img src="/img/kalogo.svg" class="logo"></ion-img>
          </ion-col>
          <ion-col size="5">
            <div class="headlineContainer">
              <span class="headline">CO2Dash</span>
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
        <ion-col size="4" >
          <ion-card>
            <ion-card-header>
              <ion-card-title>Scannen Sie diesen Code</ion-card-title>
              </ion-card-header>
              <ion-card-content>
                <ion-img 
                  src="/img/qrcode.png" 
                  class="qr"
                >
                </ion-img>
                </ion-card-content>
          </ion-card>
        </ion-col>

        <ion-col size="4" >
          <ion-card>
            <ion-card-header>
              <ion-card-title>Teilnehmer:Innen</ion-card-title>
              </ion-card-header>
              <ion-card-content class="geochart">
                <ParticipantChart></ParticipantChart>
              </ion-card-content>
          </ion-card>
        </ion-col>

        <ion-col size="4" >
          <ion-card>
            <ion-card-header>
              <ion-card-title>Einsparungen</ion-card-title>
              </ion-card-header>
              <ion-card-content class="geochart">
                <GeoChart></GeoChart>
              </ion-card-content>
          </ion-card>
        </ion-col>

      </ion-row>


      <ion-row>
        <ion-col size="12" >
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
import GeoChart from '../components/GeoChart.vue'
import ParticipantChart from '../components/ParticipantChart.vue'



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
    GeoChart,
    ParticipantChart,
  }
});
</script>

<style scoped>
#container {
}


ion-card-content ion-img::part(image) {
  min-height: 150px;
  max-height: 200px;
}


ion-card-title {
  text-align: center;
}

.co2chart {
  min-height: 300px;
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



</style>
