<template> 
  <VCard class="mx-auto mb-4">
    <VRow class="mt-1 pt-1 mb-4">
      <VCol
        cols="12"
        md="12"
      >
        <span class="white--text text-center mb-0 pt-0 text-primary"><h2> Bloques disponibles {{ periodoLbl }} {{ periodo }}</h2></span>
      </VCol>
    </VRow> 
    <VRow v-if="!isShowEntityActive">
      <VCol
        cols="12"
        md="2"
      />
      <VCol
        cols="12"
        md="8"
        class="m-0 m-0"
      >
        <div class="text-sm text-center mb-4">
          <!-- -->
          <h2 class="mb-4">
            Hola <strong
              v-if="entityAlumno.nombres"
              class="text-xl text-primary"
            >{{ entityAlumno.nombres }}</strong>
          </h2>
          
          <p>Consulta aquí los bloques (NRCs) que se abrirán en el periodo {{ periodoLbl }} {{ periodo }}</p>
        </div>
      </VCol> 
    </VRow>
    <VForm
      ref="form"
      v-model="valid"
      @submit.prevent="buscarCursos"
    >
      <VRow
        v-if="!isShowEntityActive"
        justify="center mb-4"
      >
        <VCol 
          cols="8"
          md="4"
          class="d-flex justify-space-between align-center" 
        >
          <VTextField
            v-model="entityData.curso"
            label="Curso: Ej. MATEMATICA"
            placeholder="Ingresa el nombre del curso"
            outlined
            dense
          />
          <VBtn
            color="primary"
            type="submit"
            @click="buscarCursos"
          >
            Buscar
          </VBtn>
        </VCol>
      </VRow>
      <VRow
        v-if="isShowEntityActive"
        class="mt-0 pt-0 text-center mb-8"
      >
        <VCol
          cols="12"
          md="1"
        />
        <VCol
          cols="12"
          md="10"
          class="d-flex justify-space-between align-center m-0" 
        >
          <BloquesTabla 
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
          />
        </VCol>
        <VCol
          cols="12"
          md="1"
        />
        <VRow class="mt-0 pt-0 text-center mb-8">
          <VCol
            cols="12"
            md="12"
          >
            <VBtn
              color="primary"
              type="submit"
              @click="nuevaBusqueda"
            >
              NUEVA BUSQUEDA
            </VBtn>
          </VCol>
        </VRow>
      </VRow>
    </VForm>
  </VCard>
</template>

<script setup> 
import useAppConfig from '@core/@app-config/useAppConfig'
import Swal from 'sweetalert2'
import BloquesTabla from './bloques-components/BloquesTable.vue'

let items = ref([])
let tableKey = 0
let page = ref(1)
let itemsPerPage = ref(25)
let itemTotal = ref(0)
let isLoading = ref(false)
let isShowEntityActive = ref(false)
let form = ref(null) 
let valid = ref(false)
let periodo = ref(null)
let periodoLbl = ref(null)
let { overlay } = useAppConfig()
let entityData = ref({ curso: '' }) 
let entityAlumno= ref({}) 
const $http = inject('http')

const setOverlay = value => {
  overlay.value = value
}




const headers = [
  { title: 'NRC', key: 'codigo', filterable: true, width: '65', sortable: false },
  { title: 'CURSO', key: 'curso', filterable: true, width: '300', sortable: false },
  { title: 'TIPO', key: 'tipo', filterable: true, align: 'center', sortable: false },
  { title: 'CRÉDITOS', key: 'creditos', align: 'center', filterable: true, sortable: false },
  { title: 'CAMPUS', key: 'campus', align: 'center', sortable: false },
  { title: 'HORARIO', key: 'horario', align: 'center', sortable: false },
  { title: 'PROFESOR', key: 'profesor', align: 'start', width: '250', sortable: false  },
  { title: 'CUPOS', key: 'cupos', align: 'center', sortable: false },
]

function loadAlert(text, type = "warning", title = "Advertencia") {
  Swal.fire({
    title: title,
    text: text,
    icon: type,
    confirmButtonText: 'OK',
  })
}
function getBloques(){
  setOverlay(true)
  $http.post('alumnos/bloques-disponibles', { curso: entityData.value.curso, perio: periodo.value })
    .then(response => { 
      items.value = response.data.data
      setOverlay(false)
      isShowEntityActive.value= true
    })  
}

function nuevaBusqueda(){
  entityData.value = {}
  isShowEntityActive.value= false
}

function buscarCursos() {
  // Primero valida 
  if (entityData.value.curso.length < 4) {
    loadAlert("Ingresa al menos 4 caracteres para realizar tu búsqueda.") 
    
    return  
  }

  if (form.value) {
    form.value.validate().then(isValid => {
      if (isValid) {
        getBloques()
      }
    })
  }
}
function getMostrarDatos(){
  setOverlay(true)
  $http.post('alumnos/datos')
    .then(response => { 
      entityAlumno.value= response.data.data[0] 
      setOverlay(false) 
    }) 
 
}
function getPeriodoActual(){ 
  $http.post('data/getConfiguration')
    .then(response => { 
      periodo.value = response.data.termcode
      periodoLbl.value = response.data.descripcion  
    })
}
onMounted(() => {
  getMostrarDatos()
  getPeriodoActual()
})
</script>
