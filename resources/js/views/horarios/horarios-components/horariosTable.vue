<template>
    <v-data-table-server
      class="mt-6 p-0 elevation-0"
      :headers="headers"
      :items="items"
      :loading="isLoading"
      density="compact"
      no-data-text="No hay datos para mostrar"
      loading-text="Cargando..."

    >
      <template #[`item.horario`]="{item}">
        <slot name="nombres">
            <strong>{{item.value.horario}}</strong>
        </slot>
      </template>

      <template #[`item.titulo`]="{item}">
        <slot name="nombres">
            <span class="font-weight-bold"> <small> {{item.value.titulo}}</small></span>
        </slot>
      </template>
      
      <template #[`item.lun`]="{item}" >
        <slot name="nombres">
            <span class="text-error font-weight-medium"><small>{{item.value.lun}}</small> </span>
        </slot>
      </template>

      <template #[`item.mar`]="{item}" >
        <slot name="nombres">
            <span class="font-weight-medium"><small> {{item.value.mar}}</small></span>
        </slot>
      </template>

      <template #[`item.mie`]="{item}" >
        <slot name="nombres">
            <span class="text-error font-weight-medium"> <small> {{item.value.mie}}</small></span>
        </slot>
      </template>

      <template #[`item.jue`]="{item}" >
        <slot name="nombres">
            <span class="text-secondary font-weight-medium"> <small>{{item.value.jue}}</small></span>
        </slot>
      </template>

      <template #[`item.vie`]="{item}" >
        <slot name="nombres">
            <span class="text-error font-weight-medium"> <small>{{item.value.vie}}</small> </span>
        </slot>
      </template>

      <template #[`item.sab`]="{item}" >
        <slot name="nombres">
            <span class="font-weight-medium"><small>{{item.value.sab}}</small></span>
        </slot>
      </template>

      <template v-slot:bottom></template>
      <template v-slot:loading>
        <div class="text-center py-4">
          <p>Obteniendo Data ...</p>
        </div>
      </template>

  </v-data-table-server>
</template>
  
  <script>
  import { ref } from 'vue'
  //import UCDialogQuestion from '@/components/UCDialogQuestion.vue'
  import useAppConfig from '@core/@app-config/useAppConfig'
import { required, requiredObject } from '@core/utils/validation.js'
  
  export default {
    components: {
     // UCDialogQuestion
    },
    props: {
      items: {
        type: Array,
        default: []
      },
      isLoading: {
        type: Boolean,
        default: false,
      },
      headers: {
        type: Array,
        required: true
      },
      sortBy: {
        type: String,
        default: "id"
      },
      periodo: {
        type: String
      },

    },
    setup(props) {
      //console.log(props.periodo)
      var { overlay } = useAppConfig()  
      const entityData = ref({})
    
      let page = ref(props.page)
      let itemsPerPage = ref(props.itemsPage)
  
      return {
        page,
        itemsPerPage,
        overlay,
        validators: { required, requiredObject},
        entityData,
      }
    },
    mounted(props){
      console.log(this.periodo)
    },
    methods: {
      
  
    }
  }
  </script>
    
<style>
  .row-pointer:hover {
    cursor: pointer;
  }
  .v-data-table__tbody tr:nth-of-type(odd) {
   background-color: rgba(0, 0, 0, .05) !important;
 }



</style>
    