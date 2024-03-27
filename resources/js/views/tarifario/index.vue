<template> 
  <VCard class="mx-auto mb-4">
    <VRow class="mt-1 pt-1 mb-4">
      <VCol
        cols="12"
        md="12"
      >

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
          
          <p>Aquí podrás calcular el valor de tus cuotas de este ciclo según el número de creditos que llevarás.</p>
          <center><b>¿Cuántos creditos llevarás este ciclo {{periodo}}?</b></center>
        </div>
      </VCol> 
    </VRow>
    <VRow v-if="isShowEntityActive">
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
            <strong
              v-if="entityAlumno.nombres"
              class="text-xl text-primary"
            >{{ entityAlumno.nombres  }} {{entityAlumno.apellidos}}</strong>
          </h2>
          
         
        </div>
      </VCol> 
    </VRow>    
    <VForm
      ref="form"
      v-model="valid"
      @submit.prevent="buscarCursos"
      justify="center mb-4"
    >
      <VRow
        v-if="!isShowEntityActive"
       
      >
      <VCol    cols="8" md="4"    >
      </VCol>
        <VCol    cols="4" md="3"   >
          <VTextField
            v-model="entityData.cantidad"
            label="Ingrese la cantidad de créditos"
            placeholder="Ingrese la cantidad de créditos"
            outlined
            :rules="[validators.required, numericValidationRule]"
            dense
          />
        </VCol>
        <VCol  cols="4"  md="4"   class="mr-4"  >
          <VBtn
            color="primary"
            type="submit"
            @click="buscarCursos"
          >
            Calcular
          </VBtn>
        </VCol>
      </VRow>



      <VRow
        v-if="isShowEntityActive"
        class="mt-0 pt-0 text-center "
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
  <v-container>
        
      <v-row class="bg-green">
        <v-col cols="4" class="text-end ">
      
        
        </v-col>

        <v-col cols="2" class="celeste-border-background mr-1" rounded>
           <b>Carga académica</b>  
          <v-sheet class="pa-2 ma-2 " rounded>
            <div class="content-center">
              <b> {{entityAlumno.cantidad}}</b> 
            </div>
          </v-sheet>

        
        </v-col>

        <v-col cols="2" class="celeste-border-background" rounded>
          <b>Inversión total</b>          
          <v-sheet class="pa-2 ma-2 " rounded >
            <div class="content-center">
             <b> {{entityAlumno.total}}</b> 
            </div>
          </v-sheet>
        </v-col>

      </v-row>
      <v-row class="bg-green">
        <v-col cols="4" class="text-end ">
      
        
        </v-col>

        <v-col cols="4" class=" ">
           <b>Este pago se dividirá de la siguiente manera:</b>  
        </v-col>
        <v-col cols="4" class="text-end ">
      
        
        </v-col>
        
      </v-row>      
      <v-row class="bg-green">
        <v-col cols="4" class="text-end ">
      
        
        </v-col>

        <v-col cols="4" class=" ">
            <v-table>
              <thead>
                <tr>
               
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="item in entityAlumno"
                  :key="item.GLOSA"
                >
                  <td>{{ item.GLOSA }}</td>
                  <td>S/. {{ item.SFRRGFE_PER_CRED_CHARGE }}</td>
                </tr>
              </tbody>
            </v-table>
        </v-col>
        <v-col cols="4" class="text-end ">
      
        
        </v-col>
        
      </v-row>            
          
  </v-container>
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
              Realizar otro cálculo
            </VBtn>
          </VCol>
        </VRow>
      </VRow>
    </VForm>

    <VRow >
      <VCol
        cols="12"
        md="3"
      />
      <VCol
        cols="12"
        md="6"
        class="m-0 m-0"
      >
        <div class="text-sm text-center mb-4">
          <!-- -->
 
          <p align="justify">
          <small align ="justify" v-if="!isShowEntityActive">Ten en cuenta que <b>entre 13 y 26</b> creditos el valor de cuota es el mismo.<br></small>
          <small align ="justify">Si tienes alguna duda o deseas conocer sobre otras formas y medios de pago, comunícate a Plataforma de Servicios para tener mayor información.<br></small>
          <small align ="justify"><b>A.</b> Evita el pago de interés moratorio cancelando hasta la fecha de vencimiento de cada cuota.<br></small>
          <small align ="justify"><b>B.</b> Los precios podrían variar si es que tienes algún beneficio pendiente.<br></small>
          <small align ="justify"><b>C.</b> Estos precios rigen por el presente ciclo académico e incluyen los beneficios que ISIL haya otorgado al alumno, los cuales podrán ser renovados de acuerdo a las directivas administrativas de la institución.<br></small>
          <small align ="justify"><b>D.</b> Estos precios no incluyen los materiales adicionales que alguno(s) de los cursos requiera(n).</small>
      
       </p>
       <img src="/images/logo-isil-nuevo.png" height="70">
        </div>
      </VCol> 
    </VRow>
    
  </VCard>
</template>

<script setup> 
import useAppConfig from '@core/@app-config/useAppConfig';
import { required } from '@core/utils/validation.js';
import Swal from 'sweetalert2';


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
let entityData = ref({ periodo: '',cantidads:'',total:'' ,nombres:'',apellidos:'' }) 
let entityAlumno= ref({}) 
const validators = { required}
const $http = inject('http')

const setOverlay = value => {
  overlay.value = value
}




function loadAlert(text, type = "warning", title = "Advertencia") {
  Swal.fire({
    title: title,
    text: text,
    icon: type,
    confirmButtonText: 'OK',
  })
}

const numericValidationRule = (value) => {
    const numericValue = Number(value)
    const isNumeric = !isNaN(numericValue)
    const isWithinRange = isNumeric && numericValue >= 1 && numericValue <= 70
    const isValid = isWithinRange
    return isValid || 'Ingrese un valor numérico válido entre 1 y 70.'
}


function nuevaBusqueda(){
  entityData.value = {}
  isShowEntityActive.value= false
}

function buscarCursos() {
  // Primero valida 

  if (!valid.value) {
      return
    }  
  isShowEntityActive.value= true

  getMostrarDatos()  

  }
function getMostrarDatos(){
  setOverlay(true)

  entityData.cantidads = entityData.value.cantidad
  $http.post('alumnos/datos-tarifario', { periodo: entityData.periodo, cantidad: entityData.cantidads })
    .then(response => { 

      console.log(response.data.data )
      entityAlumno.value= response.data.data 
      entityAlumno.value.total = `S/. ${response.data.total} `

      entityAlumno.value.cantidad = `${entityData.cantidads} créditos `
      entityAlumno.value.apellidos =  entityData.apellidos 
      entityAlumno.value.nombres = entityData.nombres
     console.log(entityAlumno)
      setOverlay(false) 
    }) 
 
}
function getMostrarDatosX(){
  setOverlay(true)
  $http.post('alumnos/datos')
    .then(response => { 
      

      entityAlumno.value.apellidos =response.data.data[0].apellidos
      entityAlumno.value.nombres =response.data.data[0].nombres
      entityData.apellidos =response.data.data[0].apellidos
      entityData.nombres =response.data.data[0].nombres
      setOverlay(false) 
    }) 
 
}
function getPeriodoActual(){ 
  $http.post('data/getConfiguration')
    .then(response => { 
      periodo.value = response.data.termcode
      periodoLbl.value = response.data.descripcion  
      entityData.periodo = response.data.termcode
    })
}

onMounted(() => {
 
  getPeriodoActual()
  getMostrarDatosX()
})
</script>

<style>
.celeste-border-background {

  border: 1px solid #00AEEF;
  border-radius: 5px;
}


.content-center {
  text-align: center;
}
</style>