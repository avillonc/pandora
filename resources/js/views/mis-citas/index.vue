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
            :headers="visibleHeaders"
            :item-total="itemTotal"
            :items-page="itemsPerPage"
            :page="page"
            @change-page="changePage"
            @item-per-page="changeItemPerPage"
            @cancelar-cita="showMessageDelete"
            @ver-foto="showFotoPsicologo"
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
    <Foto 
      ref="form"
      v-model:modelValue="showFoto"  
      @cancel="closeModalFoto"   
    >
      <VCardText slot="resultado">
        <VRow>
          <VCol
            cols="12"
            md="12"
            class="align-center"
          >  
            <img
              :src="imageSource"
              alt="Foto"
              style="width: 70%; height: auto;"
            > 
          </VCol> 
        </VRow>  
      </VCardText>
    </Foto>
  </VCard>
</template>

<script setup> 
import useAppConfig from '@core/@app-config/useAppConfig'
import { requiredObject } from '@core/utils/validation.js'
import Swal from 'sweetalert2'
import { computed, ref } from 'vue'
import CancelarCita from './mis-citas-components/CancelarCita.vue'
import CitasTabla from './mis-citas-components/CitasTable.vue'
import Foto from './mis-citas-components/Foto.vue'

let items = ref([])
let tableKey = 0
let page = ref(1)
let itemsPerPage = ref(25)
let itemTotal = ref(0)
let isLoading = ref(false) 
let imageSource = ref('') 
let form = ref(null) 
let valid = ref(false)
const showConfirm = ref(false)
const showFoto = ref(false)
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

const headers = ref([
  { title: 'ID CITA', key: 'id_sesion', filterable: true, width: '75', sortable: false },
  { title: 'PSICOLOGO', key: 'psicologo', align: 'center', filterable: true, width: '220', sortable: false },
  { title: 'TALLER', key: 'nombre_taller', align: 'center', filterable: true, width: '250', sortable: false },
  { title: 'FECHA CITA', key: 'fecha_cupo', filterable: true, width: '120', sortable: false },
  { title: 'HORA CITA', key: 'hora_ini', filterable: true, align: 'center', sortable: false },
  { title: 'TIPO', key: 'desc_tipocita', align: 'center', filterable: true, sortable: false },
  { title: 'SEDE', key: 'sede', align: 'center', sortable: false },
  { title: 'ENLACE', key: 'enlace', align: 'center', sortable: false },
  { title: 'ESTADO', key: 'desc_situacion', align: 'start', width: '100', sortable: false  },
  { title: '', key: 'dni', filterable: true, width: '75', sortable: false, visible: false },
  { title: 'OPCIONES', key: 'options', align: 'left', width: '100' },
])

const visibleHeaders = computed(() => {
  return headers.value.filter(header => header.visible !== false)
})

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
  entityData.value = item.value
  showConfirm.value = true
}
function showFotoPsicologo(item) {  
  entityData.value = item.value
  console.log(entityData.value)
  imageSource.value="https://isilcom.isil.pe/fotos_banner/"+entityData.value.dni+".jpg"
  showFoto.value = true
}
function  closeModal() {
  showConfirm.value = false
}
function  closeModalFoto() {
  showFoto.value = false
}

onMounted(() => { 

  getCitas()
})
</script>
