<template>

  <v-card class="mx-auto">
    <v-layout>
      <v-row>
        <v-col cols="12" md="12">
          <VTabs 
            v-model="userTab"
            show-arrows
            class="user-tabs"
            align-tabs="center"
          >
            <v-tab 
              v-for="tab in tabs" 
              :key="tab.title"
              :value="tab.tab"
              >
              <span>{{ tab.title }}</span>
            </v-tab>
          </VTabs>
          <VDivider />
          <VWindow
            v-model="userTab"
            class="mt-5 disable-tab-transition"
          >
            <VWindowItem value="mis_datos">
              <tab-mis-datos 
                :pidm="1"
                :entityData="entityData"
                >
              </tab-mis-datos>
            </VWindowItem>
            <VWindowItem value="mis_documentos">
              <tab-mis-documentos
                :elegido="45"
                :entityData="entityData"
              >
              </tab-mis-documentos>
            </VWindowItem>
            <VWindowItem value="estado_documentos">
              <tab-mis-estados 
                :pidm="1"
                :entityData="entityData"
              >
              </tab-mis-estados>
            </VWindowItem>
          </VWindow>

        </v-col>
      </v-row>
    </v-layout>
  </v-card>
</template>
  
  <script setup> 
    import store from '@/store';
import useAppConfig from '@core/@app-config/useAppConfig';
import tabMisDatos from './applicants-components/tabMisDatos.vue';
import tabMisDocumentos from './applicants-components/tabMisDocumentos.vue';
    let userTab = ref('observation') 
    let entityData = ref({})
    let { overlay } = useAppConfig()
    const setOverlay = (value) => {
        overlay.value = value
    }
   
    const tabs = [
      { title: 'Mis Datos', tab: 'mis_datos' },
      { title: 'Mis Documentos', tab: 'mis_documentos'  },
      { title: 'Estado de mis documentos', tab: 'estado_documentos'  },
      ]


    function initialize() {
      setOverlay(true)
     
    }
    function logout(){
      //this.overlay = true
      store.dispatch('app/AUTH_LOGOUT').then(() => {
        window.location.href = "/app/logout";
      })
      
    }
    onBeforeMount(() => {
      
    initialize()
  })
  </script>
  
  <style>

  .row-pointer:hover {
    cursor: pointer;
  }

  </style>
    