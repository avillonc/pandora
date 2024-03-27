<template> 
  <VCard class="mx-auto">
    <VCardText class="mt-2">
      <VRow class="mt-1 pt-1 mb-4">
        <VCol
          cols="12"
          md="12"
        >
          <span class="white--text text-center mb-0 pt-0 text-primary"><h2> Avance Curricular</h2></span>
        </VCol>
      </VRow>  
      <div class="text-sm text-center mb-4">
        <strong
          v-if="entityAlumno.nombres"
          class="text-xl text-primary"
        >{{ entityAlumno.nombres }}</strong>
            
        <label class="text-base"> tienes <strong> {{ entityAlumno.creditos_acumulados }} </strong> creditos acumulados</label>
      </div>  
      <VRow>
        <VCol
          v-for="(datos, area) in agrupados"
          :key="area"
          cols="12"
          md="4"
        >
          <div class="card "> 
            <VCardTitle :class="`card-header c${datos.orden} ` "> 
              <strong>
                <p class="pa-2 text-base curso-area-desc">
                  {{ datos.descripcion }}
                </p> 
              </strong> 
            </VCardTitle>
            <div
              v-for="curso in datos.cursos"
              :key="curso.curso"
            >
              <VRow class="pa-2">
                <VCol 
                  cols="9"
                  md="9"
                > 
                  <p>{{ curso.titulo }}</p>
                  <p>Créditos:  <strong>{{ curso.creditos }}</strong></p>
                  <p>Período:<strong>{{ curso.periodo }}</strong> </p>
                  <p v-if="getPrerequisitosConcatenados(curso)">
                    Pre Requisitos: <strong>{{ getPrerequisitosConcatenados(curso) }}</strong> 
                  </p>
                </VCol>
                <VCol
                  class="text-right"
                  cols="3"
                  md="3"
                > 
                  <p class="nota">
                    {{ curso.nota }}
                  </p>
                  <p class="descripcion">
                    Nota
                  </p>
                </VCol>
              </VRow>
              <VDivider /> 
            </div>
          </div>
        </VCol>
      </VRow> 
    </VCardText>
  </VCard>
</template>

<script setup> 
import useAppConfig from '@core/@app-config/useAppConfig'
import Swal from 'sweetalert2'
import { ref } from 'vue'

let items = ref([]) 
let isLoading = ref(false) 
let form = ref(null) 
let valid = ref(false)
let currentArea = ""
let currentOrden = 0
let count = 0
let { overlay } = useAppConfig()
let entityData = ref({ curso: '' }) 
let entityAlumno= ref({}) 
const $http = inject('http')
const agrupados = ref({})

const setOverlay = value => {
  overlay.value = value
}

const getPrerequisitosConcatenados = curso => {
  // Asume que 'curso' es un objeto que puede tener prerequisito1, prerequisito2, prerequisito3
  // Concatena los prerequisitos disponibles en una cadena
  const prerequisitos = []
  if (curso.prerequisito1) prerequisitos.push(curso.prerequisito1)
  if (curso.prerequisito2) prerequisitos.push(curso.prerequisito2)
  if (curso.prerequisito3) prerequisitos.push(curso.prerequisito3)

  return prerequisitos.join('/ ')
}

const updateAreaAndOrden = curso => {
  if (currentArea !== curso.area_desc) {
    currentOrden += 1
    currentArea = curso.area_desc
  }
}



const headers = [
  { title: 'FECHA', key: 'fecha', filterable: true, sortable: false },
  { title: 'INICIO', key: 'inicio', filterable: true, sortable: false },
  { title: 'FIN', key: 'creditos_acumulados', filterable: true, align: 'center', sortable: false },
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

function getCursos(pidm, periodo, ccar){
  setOverlay(true)
  entityAlumno.value.creditos_acumulados = 0
  $http.post('alumnos/cursos', { pidm: pidm, perio: periodo, ccarr: ccar })
    .then(response => { 
      entityAlumno.value.creditos_acumulados = response.data.data[0].creditos_acumulados
      items.value = response.data.data
      let localAgrupados = {} 

      items.value.forEach(curso => {
        if (!localAgrupados[curso.area_desc]) {
          localAgrupados[curso.area_desc] = {
            descripcion: curso.area_desc,
            orden: curso.orden,
            cursos: [],
          }
        }
        localAgrupados[curso.area_desc].cursos.push(curso)
      })

      agrupados.value = { ...localAgrupados } 
      setOverlay(false) 
    })
}

 
function getMostrarDatos(){
  setOverlay(true)
  $http.post('alumnos/datos')
    .then(response => { 
      entityAlumno.value= response.data.data[0]  
      getCursos(entityAlumno.value.pidm, entityAlumno.value.periodo, entityAlumno.value.codcar)
      setOverlay(false)   
    })  
}
 
onBeforeMount(() => {
  getMostrarDatos()
})
</script>

<style>
body {
  font-size: 16px;
}

p {
  margin: 0;
}

.header {
  padding: 1em;
  background-color: #00aeef;
  color: #fff;
  font-size: 1em;
}

.header h5 {
  margin: 0;
}

.card {
  box-shadow: 0 0 8px #ccc;
}

.descripcion {
  color: #a3a3a3;
  font-size: 0.8em;
}

.container-fluid {
  padding-block-end: 100px;
}

.curso {
  font-size: 0.8em;
  font-weight: bold;
}

.disponible {
  color: #00aeef;
}

.nota {
  font-size: 1.4em;
  font-weight: bold;
  padding-inline-end: 0.1em;
}

.add {
  float: inline-start;
}

.c1 {
  background: #0080001f;
}

.c2 {
  background: #0080802e;
}

.c3 {
  background: #66669942;
}

.c4 {
  background: #fb00ff40;
}

.c5 {
  background: #ccff007a;
}

.c7 {
  background: #ff660030;
}

.c8 {
  background: #ff000047;
}

.c99,
.cc {
  background: #ffc04c54;
}

.observaciones p,
li {
  font-size: 0.8em;
}

.expand {
  font-size: 2em;
}

hr {
  margin-block: 0.5em;
  margin-inline: 0;
}

.resaltado {
  color: #00aeef;
}

.error {
  color: #f00;
}

.hidden {
  display: none;
}

.curso-area-desc {
  overflow-wrap: break-word; /* Permite que las palabras largas se rompan y pasen a la siguiente línea */
  white-space: normal; /* Asegura que el espacio blanco se maneje de forma normal, permitiendo saltos de línea */
  word-break: break-word; /* Asegura que las palabras se rompan correctamente al llegar al final de la línea */
}
</style>
