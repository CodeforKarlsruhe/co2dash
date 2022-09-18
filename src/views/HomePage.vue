<template>
  <ion-page>

    <ion-header class="topHeader">
        <ion-item class="headline-container">
          <ion-thumbnail class="logo" slot="start">
            <img alt="Logo" src="/img/kalogo.svg" />
          </ion-thumbnail>
          <ion-label class="headline">CO<sub>2</sub> runter: Dashboard</ion-label>
        </ion-item>
    </ion-header>
    
    <ion-content :fullscreen="true"  class="onepnt5">
    <ion-grid>
      <ion-row class="toprow">
        <ion-col size="12">
          <ion-card class="heading1">
            <ion-card-header>
              <ion-card-title>CO<sub>2</sub> runter - Mein Beitrag für KA</ion-card-title>
              <ion-card-subtitle>Dashboard</ion-card-subtitle>
            </ion-card-header>
            <!--
            <ion-card-header>
              <ion-card-title>CO<sub>2</sub> runter – mein Beitrag für KA</ion-card-title>
              </ion-card-header>
              -->
              <ion-card-content >
                Wie viel CO<sub>2</sub> kann ich durch einen veränderten Lebensstil einsparen und 
                wie viel macht es in meinem Stadtteil aus, wenn ich noch andere in meinem Umfeld davon überzeuge? 
                <p>
                Die zwei Aspekte zeigt spielerisch diese App, die auf einer vereinfachten Version des CO<sub>2</sub> Rechners 
                des Bundesumweltamtes basiert.
                In dieser Klima-Challenge werden nicht nur die persönlichen Ambitionen zum Klimaschutz gezeigt, 
                sondern auch die Einsparungen, die erreicht werden können, wenn wir noch andere Menschen in 
                unserem Umfeld für den Klimaschutz begeistern. 
                Persönliche Maßnahmen für den Klimaschutz werden erfolgreicher, wenn wir auch andere Menschen davon überzeugen.
                </p>
                <span class="mitmachen">Machen Sie mit: 
                <ion-button expand="inline" fill="outline" href="https://co2app.karlsruhe.de">CO<sub>2</sub> App</ion-button>
                </span>
                <!--
                <InfoChart></InfoChart>
                -->
                <p>
                Das Paris Ziel von 1,5°C ist sehr ambitioniert und bedeutet einen verbleibenden 
                jährlichen CO<sub>2</sub> pro Kopf Ausstoß für Karlsruhe bei 2,6 Tonnen pro Person 
                bis 2030 (<em>Paris-Diagramm</em>, grüne Linie, gestrichelt).
                </p>
                <p>
                Die Stadt favorisiert bisher das 1,75°C Ziel, bei dem noch 4,1 Tonnen pro Person 
                bis 2040 verbleiben (<em>Paris-Diagramm</em>, blaue Linie, gepunktet).
                </p>



              </ion-card-content>
          </ion-card>
        </ion-col>

      </ion-row>

      <ion-row>
          <ion-col  size-md="8" size-sm="12">
  
            <ion-grid>
  
              <ion-row>
                <ion-col>
                  <ion-card>
                    <ion-card-header>
                      <ion-card-title>CO<sub>2</sub> Bilanz</ion-card-title>
                    </ion-card-header>
                    <ion-card-content>
                      <BalanceChart 
                        @balanceUpdated="balanceUpdated($event)"
                      ></BalanceChart>
                    </ion-card-content>
                  </ion-card>
                </ion-col>
              </ion-row>

              <ion-row>
                <ion-col size-md="6" size-sm="12">
                  <ion-card>
                    <ion-card-header>
                      <ion-card-title>Paris Limits</ion-card-title>
                      </ion-card-header>
                      <ion-card-content>
                        <ParisChart></ParisChart>
                      </ion-card-content>
                  </ion-card>
                </ion-col>
                <ion-col  size-md="6" size-sm="12">
                  <ion-card>
                    <ion-card-header>
                      <ion-card-title>Einsparung nach Stadtteil</ion-card-title>
                      </ion-card-header>
                      <ion-card-content>
                        <GeoChart></GeoChart>
                      </ion-card-content>
                  </ion-card>
                </ion-col>
              </ion-row>
            </ion-grid>
          </ion-col>


          <ion-col size-md="4" size-sm="12" >
                <ion-card>
                  <ion-card-header>
                    <ion-card-title>Beteiligung</ion-card-title>
                    </ion-card-header>
                    <ion-card-content class="geochart">
                      <ParticipantChart></ParticipantChart>
                    </ion-card-content>
                </ion-card>
          </ion-col>

      </ion-row>



      <ion-row>
      <ion-col class="okl" size="7">
            <ion-img class="okl-image" src="/img/logo.svg" style="height:30px;"><a href="https://ok-lab-karlsruhe.de" target=_blank></a></ion-img>
            <ion-label class="okl-label">Design: OK Lab Karlsruhe</ion-label>
      </ion-col>
      <ion-col class="imprint" size="5">
      <!--
      <ion-button expand="block" fill="outline" class="routelink" href="https://ok-lab-karlsruhe.de/impressum/">Impressum</ion-button>
      -->

      <!--
      -->
      <ion-button expand="block" fill="outline" class="routelink okl-button" href="https://www.karlsruhe.de/impressum">Impressum</ion-button>
      </ion-col>
      </ion-row>

    </ion-grid>
    </ion-content>
  </ion-page>
</template>

<script lang="ts">
import { IonContent, IonHeader, IonPage,
  IonGrid, IonRow, IonCol,
  IonImg,IonButton,
  IonCard, IonCardTitle, IonCardHeader, IonCardContent, 
  IonItem, IonLabel, IonThumbnail,
} from '@ionic/vue';
import { defineComponent, ref } from 'vue';

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
    IonImg,IonButton,
    IonCard, IonCardTitle, IonCardHeader, IonCardContent, 
    BalanceChart,
    ParisChart,
    //InfoChart,
    GeoChart,
    ParticipantChart,
    IonItem, IonLabel, IonThumbnail,

  },
  data () {
    return {
    }
  },
  methods: {
    balanceUpdated(){
      console.log("Home: Balance update")
      //this.updated++
    },
  },
  setup () {
    const updated = ref(0)
    return { updated }
  }

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

ion-card-subtitle {
  font-size: 1rem;
  font-weight: bold;
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
  padding: 0;
  object-position: left;
}


.headline-container {
  --inner-border-width: 0;
}

.headline {
  font-size: 2rem;
  font-weight: bold;
  margin-bottom: -.4rem;
  white-space: break-spaces;
}


/* smaller content on large screen */
@media only screen and (min-width: 992px) {
  .card-md {
    max-width: 960px;
    margin-left:auto;
    margin-right:auto;
  }
}

/* smaller padding on small screen */
@media only screen and (max-width: 599px) {
ion-item {
  --padding-start: 5px;
  }
  .logo {
    height: 1.5rem;
  }
  .headline {
    font-size: 1.3rem;
  }
}

/* smaller padding on small screen */
@media only screen and (max-width: 399px) {
  .logo {
    height: 1.4rem;
  }
  .headline {
    font-size: 1.1rem;
  }
}


.mitmachen {
  font-size: 120%;
  font-weight: bold;
}

.infotext {
  height: 210px;
}

.okl-image {
  display: inline-block;
  margin-right: .5rem;
}
.okl-label {
  vertical-align: top;
  font-size: 80%;
}

.okl-button {
  margin-left: 10px;
  margin-right: 10px;
}

ion-thumbnail {
  width: unset;
  height: unset;
}

</style>
