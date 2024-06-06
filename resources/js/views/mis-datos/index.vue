<template> 
  <VCard class="mx-auto mb-4">
    <VCardTitle
      align="center"
      class="mb-3"
    >
      <span class="font-weight-bold text-primary text-h5">MIS DATOS</span>
    </VCardTitle> 
    <VForm
      ref="form"
      v-model="valid"
      @submit.prevent="validate"
      @submit="onSubmit" 
    >
      <VCardText> 
        <VDivider class="mb-4" />
        <VRow>
          <VCol
            cols="12"
            md="4"
          >
            <VTextField
              v-model="entityData.dni"
              label="Nro. Documento"
              outlined
              dense
              hide-details="auto"
              readonly
              filled
            /> 
          </VCol>
          <VCol
            cols="12"
            md="4"
          >
            <VTextField
              v-model="entityData.nombre_completo"
              label="Nombre"
              outlined
              dense
              hide-details="auto"
              readonly
              filled
            /> 
          </VCol>
          <VCol
            cols="12"
            md="4"
          >
            <VTextField
              v-model="entityData.nickname"
              label="Nickname"
              outlined
              dense
              hide-details="auto" 
              filled
            /> 
          </VCol>
        </VRow> 
        <VRow>
          <VCol
            cols="12"
            md="4"
          >
            <VSelect
              v-model="entityData.genero"
              label="Género"
              outlined
              density="compact"
              :items="generos"
              item-title="name"
              item-value="id"
              :menu-props="{ offsetY: true }"
              hide-details="auto" 
            /> 
          </VCol>
          <VCol
            cols="12"
            md="4"
          >
            <VSelect
              v-model="entityData.estado_civil"
              label="Estado Civil"
              outlined
              density="compact"
              :items="estadosCiviles"
              item-title="name"
              item-value="id"
              :menu-props="{ offsetY: true }"
              hide-details="auto" 
            />  
          </VCol>
          <VCol
            cols="12"
            md="4"
          >
            <VTextField
              v-model="entityData.fecha_nac"
              label="Fecha nacimiento"
              :rules="[validators.requiredObject]"
              outlined
              dense
              hide-details="auto"  
              type="date"
            /> 
          </VCol>
        </VRow> 
           
        <VRow>
          <VCol
            cols="12"
            md="4"
          >
            <VTextField
              v-model="entityData.celular" 
              :rules="[validators.requiredObject]"
              label="Teléfono"
              outlined
              dense
              hide-details="auto" 
              filled
              @keypress="onlyNumbers($event)"
            /> 
          </VCol>
          <VCol
            cols="12"
            md="4"
          >
            <VTextField
              v-model="entityData.correo" 
              :rules="[validators.requiredObject , validators.emailValidator]"
              label="Correo personal"
              outlined
              dense 
              hide-details="auto" 
              filled
            /> 
          </VCol> 
        </VRow>
        <br>
        <VDivider class="mb-4" />
        <VRow>
          <VCol
            cols="12"
            md="4"
          >
            <VSelect
              v-model="entityData.id_parentesco"
              label="Tipo parentesco"
              outlined
              density="compact"
              :items="parentescos"
              item-title="name"
              item-value="id"
              :menu-props="{ offsetY: true }"
              hide-details="auto" 
            />  
          </VCol>
          <VCol
            cols="12"
            md="4"
          >
            <VTextField
              v-model="entityData.celular_contacto"
              :rules="[validators.requiredObject]" 
              label="Celular contacto emergencia"
              outlined
              dense
              hide-details="auto" 
              filled
              @keypress="onlyNumbers($event)"
            /> 
          </VCol>
          <VCol
            cols="12"
            md="4"
          >
            <VTextField
              v-model="entityData.nombre_contacto"
              :rules="[validators.requiredObject]" 
              label="Nombre contacto emergencia"
              outlined
              dense
              hide-details="auto" 
              filled
              @keypress="onlyLetters($event)"
            /> 
          </VCol>
        </VRow> 
        <VRow class="mt-0 pt-0 text-center mb-3">
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
              color="info"
              type="submit"
            >
              <VIcon left>
                mdi-content-save
              </VIcon>
              GRABAR
            </VBtn>
          </VCol>
        </VRow>
      </VCardText>
    </VForm> 
  </VCard>
</template>

<script setup> 
import useAppConfig from '@core/@app-config/useAppConfig'
import { emailValidator, requiredObject } from '@core/utils/validation.js'
import Swal from 'sweetalert2'

let items = ref([])
let tableKey = 0
let page = ref(1)
let itemsPerPage = ref(25)
let itemTotal = ref(0)
let isLoading = ref(false) 
let form = ref(null) 
let valid = ref(false) 
let { overlay } = useAppConfig() 
let entityData= ref({}) 
const $http = inject('http')
const showConfirm = ref(false)
let generos = ref([]) 
let estadosCiviles = ref([])
let parentescos = ref([])

const validators = { requiredObject, emailValidator }
let validate = () => {
  form.value.validate()
}
   
const setOverlay = value => {
  overlay.value = value
}




const headers = [
  { title: 'DOCUMENTO', key: 'tipo_doc', align: 'center', filterable: true, sortable: false },
  { title: 'DESCARGAR', key: 'inicio', filterable: true, sortable: false },
  { title: 'FECHA ENVIO', key: 'fin', filterable: true, align: 'center', sortable: false },
  { title: 'ESTADO', key: 'situacion', align: 'center', filterable: true, sortable: false }, 
  { title: 'OPCIONES', key: 'options', align: 'center', filterable: true, sortable: false }, 
]

function loadAlert(text, type = "warning", title = "Advertencia") {
  Swal.fire({
    title: title,
    text: text,
    icon: type,
    confirmButtonText: 'OK',
  })
}

function getDatos(){
  setOverlay(true)
  $http.post('programming/getPaciente', { id: '' })
    .then(response => { 
      entityData.value = response.data.data[0]
      setOverlay(false) 
    })  
}
function showFicha(item) { 
  console.log("showConfirm" )
  entityData.value = item.value
  showConfirm.value = true
}
function grabarFicha(){
  
}

function initialize() { 
  overlay.value = true 
  $http.post('data/get-maestras', { idTabla: '19' })
    .then(response => {
      generos.value = response.data.data
      overlay.value = false 
    }).catch(error => {
      overlay.value = false
    }) 

  $http.post('data/get-maestras', { idTabla: '20' })
    .then(response => {
      estadosCiviles.value = response.data.data
      overlay.value = false 
    }).catch(error => {
      overlay.value = false
    })    

  $http.post('data/get-maestras', { idTabla: '21' })
    .then(response => {
      parentescos.value = response.data.data
      overlay.value = false 
    }).catch(error => {
      overlay.value = false
    })    
}
function  closeModal() {
  showConfirm.value = false
}
function onSubmit(){
  console.log("emitOk" + valid.value)

  form.value.validate()
  if ( valid.value) {
    overlay.value = true
    $http.post('programming/actualizarDatos', entityData.value)
      .then(response => {
        overlay.value = false 
        loadAlert('Datos actualizados correctamente', 'success', 'Éxito')
      })
      .catch(error => {
        overlay.value = false  
      })
  
  } else { 
    console.log("Validation failed")  
  }
}
function onlyNumbers(event) {
  const charCode = event.keyCode

  // Permitir solo números del 0 al 9 y teclas de navegación como Flechas, Retroceso, Inicio y Fin
  if (charCode < 48 || charCode > 57) {
    event.preventDefault()
  }
}
 
function onlyLetters(event) {
  const charCode = event.keyCode

  // Aceptar letras y el espacio (código 32)
  if ((charCode < 65 || charCode > 90) && (charCode < 97 || charCode > 122) && charCode !== 32) {
    event.preventDefault()
  }
}

onBeforeMount(() => { 
  initialize()
  getDatos()
})
</script>
