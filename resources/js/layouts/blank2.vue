<template >
  <div class="layout-wrapper layout-blank " >
    <!-- <v-app-bar></v-app-bar> -->
    <v-app-bar app color="primary" density="compact" scroll-behavior="hide">
    <v-img
      :src="logoh"
      max-height="110"
      max-width="110"
      contain
      class="pl-2 ml-2"
    ></v-img>
    <v-toolbar-title class="pl-2 ml-2">
    
    <!--Modulos-->
    </v-toolbar-title>
     
     <UserProfile class="mr-2"/>
  </v-app-bar> 
  
  <v-row  class="pb-15">
    <v-col cols="12" md="12" >
      <v-spacer></v-spacer> 
    </v-col>
  </v-row>
  <RouterView />
  <v-overlay
      :model-value="store.state.appConfig.loadcontentshowoverlay"
      class="align-center justify-center"
      persistent
    >
      <v-progress-circular
        color="on-secondary"
        indeterminate
        size="50"
      ></v-progress-circular>
    </v-overlay>
  </div>
  
</template>
<script setup> 
import store from '@/store';

import logoh from '@images/logos/isil_logo.png';
import UserProfile from '@/layouts/components/UserProfile.vue'

</script>
<style>
.layout-wrapper.layout-blank {
  flex-direction: column;
}
</style>
