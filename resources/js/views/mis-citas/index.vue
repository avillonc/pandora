<template> 
  <VCard class="mx-auto mb-4">
    <VCardTitle
      align="center"
      class="mb-3"
    >
      <span class="font-weight-bold text-primary text-h5"> MIS CITAS</span>
    </VCardTitle>  
    <VForm 
      v-model="valid"
      @submit.prevent="buscarCursos"
    >
      <VRow class="mt-0 pt-0 text-center mb-8"> 
        <VCol
          cols="12"
          md="12"
          class="d-flex justify-space-between align-center m-0" 
        >
          <CitasTabla 
            :key="tableKey"
            class="mt-0 pt-0"
            :items="items" 
            :is-loading="isLoading"
            :headers="headers"
            :item-total="itemTotal"
            :items-page="itemsPerPage"
            :page="page"
            @change-page="changePage"
            @item-per-page="changeItemPerPage"
            @cancelar-cita="showMessageDelete"
          />
        </VCol> 
      </VRow>
    </VForm>

    <CancelarCita 
      ref="form"
      v-model:modelValue="showConfirm"  
      @cancel="closeModal"  
      @ok="cancelarCita"
    >
      <VCardText slot="resultado">
        <VRow>
          <VCol
            cols="12"
            md="12"
          > 
            <VTextarea
              v-model="entityData.observacion"
              outlined
              label="Motivo de cancelación"
              dense
              hide-details="auto"
              rows="3"
              :rules="[validators.requiredObject]"
            />  
          </VCol> 
        </VRow>  
      </VCardText>
    </CancelarCita>
  </VCard>
</template>

<script setup> 
import useAppConfig from '@core/@app-config/useAppConfig'
import { requiredObject } from '@core/utils/validation.js'
import Swal from 'sweetalert2'
import CancelarCita from './mis-citas-components/CancelarCita.vue'
import CitasTabla from './mis-citas-components/CitasTable.vue'

let items = ref([])
let tableKey = 0
let page = ref(1)
let itemsPerPage = ref(25)
let itemTotal = ref(0)
let isLoading = ref(false) 
let form = ref(null) 
let valid = ref(false)
const showConfirm = ref(false)
let { overlay } = useAppConfig()
let entityData = ref({ curso: '' })  
const $http = inject('http')
const validators = { requiredObject }

const setOverlay = value => {
  overlay.value = value
}

let validate = () => {
  form.value.validate()
}

const headers = [
  { title: 'ID CITA', key: 'id_sesion', filterable: true, width: '75', sortable: false },
  { title: 'PSICOLOGO', key: 'psicologo', align: 'center', filterable: true, width: '220', sortable: false },
  { title: 'TALLER', key: 'nombre_taller', align: 'center', filterable: true, width: '250', sortable: false },
  { title: 'FECHA CITA', key: 'fecha_cupo', filterable: true, width: '120', sortable: false },
  { title: 'HORA CITA', key: 'hora_ini', filterable: true, align: 'center', sortable: false },
  { title: 'TIPO', key: 'desc_tipocita', align: 'center', filterable: true, sortable: false },
  { title: 'SEDE', key: 'sede', align: 'center', sortable: false },
  { title: 'ENLACE', key: 'enlace', align: 'center', sortable: false },
  { title: 'ESTADO', key: 'desc_situacion', align: 'start', width: '100', sortable: false  },
  { title: 'OPCIONES', key: 'options', align: 'left', width: '100' },
]

function loadAlert(text, type = "warning", title = "Advertencia") {
  Swal.fire({
    title: title,
    text: text,
    icon: type,
    confirmButtonText: 'OK',
  })
}
function getCitas(){
  setOverlay(true)
  $http.post('programming/getCitas', entityData.value)
    .then(response => { 
      items.value = response.data.data
      setOverlay(false) 
    })  
}
function cancelarCita(){ 
  //  overlay.value = true
  
  console.log("cancelarCita" )
  overlay.value = true
  $http.post('programming/cancelarCita', entityData.value)
    .then(response => {
      closeModal()
      loadAlert('Cita cancelada exitosamente', 'success', 'Éxito')
      getCitas()
      overlay.value = false 
    })
    .catch(error => {
      overlay.value = false  
    }) 
}

function showMessageDelete(item) { 
  console.log("showConfirm"+item.value.id_sesion)
  entityData.value = item.value
  showConfirm.value = true
}
function  closeModal() {
  showConfirm.value = false
}
onMounted(() => { 

  getCitas()
})
</script>
