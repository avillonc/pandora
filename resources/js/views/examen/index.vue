<template> 
  <VCard class="mx-auto mb-4">
    <VRow class="mt-1 pt-1 mb-4">
      <VCol
        cols="12"
        md="12"
      >
        <span class="white--text text-center mb-0 pt-0 text-primary"><h2> Rol de Exámenes: {{ periodoLbl }} {{ periodo }}</h2></span>
      </VCol>
    </VRow> 
    <VRow>
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
          <h2 class="mb-4">
            Hola <strong
              v-if="entityAlumno.nombres"
              class="text-xl text-primary"
            >{{ entityAlumno.nombres }}</strong>
          </h2>
          <p>Ten en cuenta estas fechas para que rindas tus exámenes:</p>
        </div>
      </VCol> 
    </VRow>
    <VForm
      ref="form"
      v-model="valid"
      @submit.prevent="buscarCursos"
    > 
      <VRow class="mt-0 pt-0 text-center mb-8">
        <VCol
          cols="12"
          md="3"
        />
        <VCol
          cols="12"
          md="6"
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
          md="3"
        /> 
      </VRow>
    </VForm>
  </VCard>
</template>

<script setup> 
import useAppConfig from '@core/@app-config/useAppConfig'
import Swal from 'sweetalert2'
import BloquesTabla from './examen-components/ExamenTable.vue'

let items = ref([])
let tableKey = 0
let page = ref(1)
let itemsPerPage = ref(25)
let itemTotal = ref(0)
let isLoading = ref(false) 
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
  { title: 'FECHA', key: 'fecha', filterable: true, sortable: false },
  { title: 'INICIO', key: 'inicio', filterable: true, sortable: false },
  { title: 'FIN', key: 'fin', filterable: true, align: 'center', sortable: false },
  { title: 'CURSO', key: 'curso', align: 'center', filterable: true, sortable: false },
  { title: 'AULA', key: 'aula', align: 'center', sortable: false }, 
]

function loadAlert(text, type = "warning", title = "Advertencia") {
  Swal.fire({
    title: title,
    text: text,
    icon: type,
    confirmButtonText: 'OK',
  })
}

function getExamenes(pidm, periodo){
  setOverlay(true)
  $http.post('alumnos/examenes', { pidm: pidm, perio: periodo.value })
    .then(response => { 
      items.value = response.data.data
      setOverlay(false) 
    })  
}
 
function getMostrarDatos(){
  setOverlay(true)
  $http.post('alumnos/datos')
    .then(response => { 
      entityAlumno.value= response.data.data[0] 

      //console.log("pidm "+entityAlumno.value.pidm)
      getExamenes(entityAlumno.value.pidm, periodo)
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
onBeforeMount(() => {
  getMostrarDatos()
  getPeriodoActual()
})
</script>
