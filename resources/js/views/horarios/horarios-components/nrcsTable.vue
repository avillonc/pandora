<template>

      <v-data-table-server
        class="mb-4 "
        :headers="headers"
        :items="items"
        :loading="isLoading"
        :items-per-page="-1"
        density="compact"
        no-data-text="No hay datos para mostrar"
        loading-text="Cargando..."
      >
        <template #[`item.options`]="{ item }">
          <v-tooltip location="top" text="Ver documentos" >
            <template v-slot:activator="{ props }">
              <v-avatar size="28" color="primary" v-bind="props">
                <v-icon size="20"  
                  @click="showDocForm(item)"
                  icon="mdi-eye"></v-icon>
              </v-avatar>
            </template>
          </v-tooltip>
        </template>
        
        <template #[`item.CODIGO`]="{item}">
          <slot name="nombres">
              <strong>{{item.value.CODIGO}}</strong>
          </slot>
        </template>

        <template #[`item.TITULO`]="{item}">
          <slot name="nombres">
              <span class="text-primary font-weight-medium">{{item.value.TITULO}}</span>
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
      let valueSelected = ref([])  
      let page = ref(props.page)
      let itemsPerPage = ref(props.itemsPage)
  
      return {
        page,
        itemsPerPage,
        valueSelected,
        msgConfirm: '',
        activemsgConfirm: false,
        msgConfirmReenvio: '',
        overlay,
        validators: { required, requiredObject},
        entityData,
      }
    },
    methods: { 
    }
  }
  </script>