<template> 
  <VCard class="mx-auto mb-4">
    <VCardTitle
      align="center"
      class="mb-3"
    >
      <span class="font-weight-bold text-primary text-h5"> 
        {{ isShowNew ? 'CASOS ESPECIALES' : 'LISTA DE CASOS ESPECIALES' }}</span>
    </VCardTitle>  
    <UCToolbar
      :show-form="isShowNew"
      @on-create="createEntityOrClose"
      @on-read="initialize"
    />
    <VCardText
      v-if="!isShowNew"
      class="my-0"
    >
      <VForm 
        v-model="valid"
        @submit.prevent="getCasoEspeciales"
      >
        <!-- 
          <VRow class="mt-0 pt-0 text-center mb-4">
          <VCol
          cols="12"
          md="9"
          />
          <VCol
          cols="12"
          md="3"
          >
          <VBtn
          block
          color="success"
          type="submit"
          :loading="isLoading"
          >
          <VIcon
          id="btnConsultar"
          left
          dark
          > 
          mdi-magnify
          </VIcon>
          Consultar
          </VBtn>
          </VCol>
          </VRow>
        --> 


        <VRow class="mt-0 pt-0 text-center mb-8"> 
          <VCol
            cols="12"
            md="12"
            class="d-flex justify-space-between align-center m-0" 
          >
            <CitasTabla 
              v-if="!isShowNew"
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
              @edit="editEntity"
            /> 
          </VCol> 
        </VRow>
      </VForm>
    </VCardText>
    <EsperaForm
      v-if="isShowNew"
      :entity-data="entityData"
      @update:entityData="handleResetEntityData"
      @create="onCreateEntityProg"
      @on-backward="isShowNew = !isShowNew"
      @load-alert="loadAlert"
      @reload="initialize"
    />
  </VCard>
</template>

<script setup> 
import useAppConfig from '@core/@app-config/useAppConfig'
import { requiredObject } from '@core/utils/validation.js'
import Swal from 'sweetalert2'
import { computed, ref } from 'vue'
import CitasTabla from './casos-especiales-components/CasosTable.vue'
import EsperaForm from './casos-especiales-components/SpecialForm.vue'
import UCToolbar from './casos-especiales-components/UCToolbar.vue'

let items = ref([])
let tableKey = 0
let page = ref(1)
let itemsPerPage = ref(25)
let itemTotal = ref(0)
let isLoading = ref(false) 
let isShowNew= ref(false)
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
  { title: 'NRC', key: 'nrc', filterable: true, width: '75', sortable: false },
  { title: 'PERIODO', key: 'periodo', align: 'center', filterable: true, sortable: false }, 
  { title: 'CARRERA', key: 'carrera', align: 'center', sortable: false },
  { title: 'CURSO', key: 'curso', align: 'center', filterable: true, width: '300', sortable: false },
  { title: 'ALUMNO', key: 'nombre', align: 'center', filterable: true, width: '350', sortable: false },
  { title: 'CELULAR', key: 'celular', align: 'center', filterable: true, width: '150', sortable: false },
  { title: 'CORREO', key: 'correo', filterable: true, align: 'center', width: '150', sortable: false },
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
function getCasoEspeciales(){
  setOverlay(true)
  $http.post('programming/getCasoEspeciales', entityData.value)
    .then(response => { 
      items.value = response.data.data
      setOverlay(false) 
    })  
}
 
function initialize(){
  getCasoEspeciales()
}

function showMessageDelete(item) {  
  entityData.value = item.value
  showConfirm.value = true
}
function createEntityOrClose() {
  blankentity_event()
  isShowNew.value = !isShowNew.value
}
function     blankentity_event() {
  entityData.value = {}
} 
function showFotoPsicologo(item) {  
  entityData.value = item.value
  console.log(entityData.value)
  imageSource.value="https://isilcom.isil.pe/fotos_banner/"+entityData.value.dni+".jpg"
  showFoto.value = true
}
function editEntity(item) {
  entityData.value = item.raw
  isShowNew.value = true
}
function  closeModal() {
  showConfirm.value = false
}
function  closeModalFoto() {
  showFoto.value = false
}


onMounted(() => { 

  getCasoEspeciales()
})
</script>
