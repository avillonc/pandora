<template> 
  <VCard class="mx-auto mb-4">
    <VCardTitle
      align="center"
      class="mb-3"
    >
      <span class="font-weight-bold text-primary text-h5">MIS DOCUMENTOS</span>
    </VCardTitle> 
    <VForm
      ref="form"
      v-model="valid"
      @submit.prevent="buscarCursos"
    >
      <VRow class="mt-0 pt-0 text-center mb-3">
        <VCol
          cols="12"
          md="2"
        />
        <VCol
          cols="12"
          md="8"
          class="d-flex justify-space-between align-center m-0" 
        >
          <BloquesTabla 
            :key="tableKey"
            class="mt-0 pt-0"
            :items="itemsInform" 
            :is-loading="isLoading"
            :headers="headers"
            :item-total="itemTotal"
            :items-page="itemsPerPage"
            :page="page"
            @change-page="changePage"
            @item-per-page="changeItemPerPage"
            @ver-ficha="showFicha"
          />
        </VCol>
        <VCol
          cols="12"
          md="2"
        /> 
      </VRow> 
      <VRow>
        <VCol
          cols="12"
          md="2"
        />
        <VCol
          cols="12"
          md="10" 
        >
          <VCardTitle class="justify-center flex-column">
            <span class="text-sm info--text font-weight-semibold text-primary">ADJUNTAR / VER DOCUMENTOS ADJUNTADOS:</span>   
            <VDivider class="mb-0" /> 
            <VCardText>
              <div
                v-for="docum in items"
                :key="docum.id_registro"
              >
                <VRow class="mt-0 pt-0 text-center mb-0"> 
                  <VCol
                    v-if="!docum.url"
                    cols="12"
                    md="8"
                  >
                    <VFileInput
                      :key="docum.id_registro"
                      ref="fileInput"
                      v-model="filesAc[docum.id_registro]"
                      name="files"
                      :label="docum.tipo_doc"  
                      hide-details="auto"
                      :prepend-inner-icon="iconName" 
                      :prepend-icon="null"
                      outlined
                      clearable
                      density="compact"
                      accept=".pdf"
                      multiple 
                      @change="uploadfilesAc(docum.id_registro)"
                    /> 
                  </VCol> 
                 <!--
                  
                 --> <VCol
                    v-if="docum.url"
                    cols="12"
                    md="8"
                    class="d-flex align-items-center"
                  >
                  <VTooltip 
                      v-if="docum.url"
                      location="top"
                      text="Eliminar documento cargado"
                    >
                      <template #activator="{ props }">
                        <VAvatar
                          size="28"
                          color="error"
                          v-bind="props"
                        >
                          <VIcon
                            size="20"  
                            icon="mdi-delete"
                            @click="deleteFile(docum.id_documento, docum.tipo_doc)"
                          />
                        </VAvatar>
                      </template>
                    </VTooltip>  
                    <div style="width: 16px;" />  
                    <VTooltip 
                      v-if="docum.url"
                      location="top"
                      text="Ver documento cargado"
                    >
                      <template #activator="{ props }">
                        <VAvatar
                          size="28"
                          color="primary"
                          v-bind="props"
                        >
                          <a
                            v-if="docum.url"
                            :href="'/programming/view-document/' + limpiandoRuta(docum.url)"
                            target="_blank"
                            class="d-inline-flex align-items-center" 
                          >
                            <VIcon
                              size="20"  
                              color="white"
                              icon="mdi-file"
                              @click="deleteFile(docum.id_documento, docum.tipo_doc)"
                            />

                          </a>
                        </VAvatar>
                      </template>
                    </VTooltip> 
                    <div style="width: 16px;" />  
                    <span class="text-sm info--text font-weight-bold text-primary mb-2">{{ docum.tipo_doc }}</span>
                  </VCol> 
                </VRow>
              </div>
            </VCardText>
          </VCardTitle> 
        </VCol>
      </VRow>

      <VRow class="mt-0 pt-0 text-center mb-3">
        <VCol
          cols="12"
          md="4"
        />
        <VCol
          cols="12"
          md="3"
        >
          <VBtn
            block
            color="info"
            @click="grabarArchivos"
          >
            <VIcon left>
              mdi-content-save
            </VIcon>
            CARGAR ARCHIVO(S)
          </VBtn>
        </VCol>
      </VRow>
    </VForm>
    <FichaTabla 
      ref="form"
      v-model:modelValue="showConfirm"    
      v-model:showConfirm="showConfirmButton"
      @cancel="closeModal"  
      @ok="grabarFicha"
    />
  </VCard>
  <UCDialogQuestion
    :visible="activeMsgDelete"
    :message="msgDelete"
    title="Eliminar"
    @cancel="closeMsgDelete"
    @ok="deleteEntity"
  />
</template>

<script setup> 
import UCDialogQuestion from '@/components/UCDialogQuestion.vue'
import useAppConfig from '@core/@app-config/useAppConfig'
import Swal from 'sweetalert2'
import BloquesTabla from './documentos-components/DocumentosTable.vue'
import FichaTabla from './documentos-components/FichaForm.vue'

const files = ref(null)
const iconName = 'mdi-paperclip' 
let itemsInform = ref([])
let items = ref([])
let tableKey = 0
let page = ref(1)
let itemsPerPage = ref(25)
let itemTotal = ref(0)
let isLoading = ref(false) 
let form = ref(null) 
let valid = ref(false)
let activeMsgDelete = ref(false)

//let closeMsgDelete = ref(false)

let indexArchivo = ref(null)
let { overlay } = useAppConfig()
let entityData = ref({ curso: '' }) 
let entityDocumento= ref({}) 
let filesAc= ref({}) 
const $http = inject('http')
const showConfirm = ref(false)
const showConfirmButton = ref(false)
const msgDelete = ref(null) 

const handleFileChange = selectedFiles => {
  // Manejar la lógica cuando se seleccionan archivos
  console.log('Archivos seleccionados:', selectedFiles)
}

const setOverlay = value => {
  overlay.value = value
} 

const headers = [
  { title: 'INFORME', key: 'tipo_doc', align: 'center', filterable: true, sortable: false }, 
  { title: '¿CONFIRMADO?', key: 'situacion', align: 'center', filterable: true, sortable: false }, 
  { title: 'FECHA CONFIRMACIÓN', key: 'fecha_envio', filterable: true, align: 'center', sortable: false },
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
function getDocumentos(){
  setOverlay(true)
  $http.post('programming/getDocumentos', { id: '' })
    .then(response => { 
      items.value = response.data.data
      setOverlay(false) 
    })  
}
function getInformes(){
  setOverlay(true)
  $http.post('programming/getInformes', { id: '' })
    .then(response => { 
      itemsInform.value = response.data.data
      setOverlay(false) 
    })  
}

function showFicha(item) {  
  entityData.value = item.value
  showConfirmButton.value = item.value.situacion !== 'SI'
  console.log("showConfirmButton.value" + showConfirmButton.value)
  showConfirm.value = true
}
function grabarFicha(){
  console.log("grabarFicha")
  overlay.value = true
  $http.post('programming/registrarInforme', entityData.value)
    .then(response => {
      closeModal()
      loadAlert('Ficha de confidencialidad confirmada exitosamente', 'success', 'Éxito')
      getInformes()
      overlay.value = false 
    })
    .catch(error => {
      overlay.value = false  
    }) 

}

function  closeModal() {
  showConfirm.value = false
}

function uploadfilesAc(tipoDocumento) {
  // Obtener los archivos seleccionados para este tipo de documento
  const archivosSeleccionados = filesAc[tipoDocumento]

  console.log("tipoDocumento " + tipoDocumento)
 
}

function   limpiandoRuta(ruta) {
  if (ruta) {

    var cadena = ruta
    var arreglo = cadena.split('/')
    
    return arreglo[arreglo.length - 1]
  }
  
  return false
}
    
function grabarArchivos() {
  overlay.value = true  

  let tieneArchivos = false
  for (const key of Object.keys(filesAc.value)) {
    if (filesAc.value[key].length > 0) {
      tieneArchivos = true
      for (const file of filesAc.value[key]) {
        if (file.size > 2 * 1024 * 1024) {
          loadAlert(`El archivo "${file.name}" supera el tamaño máximo permitido de 2 MB`, 'error', 'Error')
          overlay.value = false
          
          return 
        }
      }
    }
  }

  if (!tieneArchivos) {
    loadAlert('Debes seleccionar al menos un archivo para grabar', 'error', 'Error')
    overlay.value = false
    
    return
  }

  let formData = new FormData()
 
  Object.keys(filesAc.value).forEach(key => {
    filesAc.value[key].forEach((file, index) => {
      formData.append(`inputfile[${key}][${index}]`, file) // Añadir archivo a FormData
      formData.append(`tipo_docu[${key}][${index}]`, key)
      console.log("file" + file)
    }) 
  })

  /*for (let [key, value] of formData.entries()) {
    console.log(`${key}: ${value}`)
  }*/

 
  $http.post('programming/grabarDocumentos', formData, {
    headers: {
      'Content-Type': 'multipart/form-data',
    },
  })
    .then(response => {
      loadAlert('Tus documentos fueron cargados exitosamente', 'success', 'Éxito')

      //console.log(response)
    })
    .catch(error => {
      console.error(error)
    })
    .finally(() => {
      overlay.value = false
    }) 
}
 
function deleteFile(id_documento, nombre_archivo){
  console.log(id_documento)
  activeMsgDelete.value = true
  indexArchivo = id_documento 
  entityDocumento.value.id = id_documento
  msgDelete.value = "Eliminar archivo: " + nombre_archivo
}

function deleteEntity() {

  overlay.value = true 
 
  if (entityDocumento.value.id) {
    $http.post('programming/eliminarDocumento', entityDocumento.value).then(response => { 
      overlay.value = false
      loadAlert('Archivo eliminado con éxito', 'success')
      getDocumentos()
    }).catch(error => {
      overlay.value = false
      loadAlert('Ocurrió un error al intentar eliminar el archivo', 'error')
    })
  }

  closeMsgDelete()
}

function closeMsgDelete() {
  activeMsgDelete.value = false
}

onBeforeMount(() => {
  getDocumentos()

  getInformes()
})
</script>
