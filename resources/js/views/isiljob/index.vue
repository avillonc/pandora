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
          
          <p>Te estamos redireccionando a la bolsa laboral.</p>
        
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
    

     
        
      </v-row>            
          
  </v-container>
        </VCol>
      
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

function getMostrarDatosX(){
  setOverlay(true)
  $http.post('alumnos/datos')
    .then(response => { 
      

      entityAlumno.value.apellidos =response.data.data[0].apellidos
      entityAlumno.value.nombres =response.data.data[0].nombres
      entityData.apellidos =response.data.data[0].apellidos
      entityData.nombres =response.data.data[0].nombres
     
    }) 
 
}

function getMostrarDatos(){
  setOverlay(true)
  $http.post('alumnos/datos-bolsalaboral')
    .then(response => { 
        
      let form = document.createElement("form")
     if(response.data.data === "0"){
            form.action = 'https://isiljob.hiringroomcampus.com/check-access';
     }else{
            form.action = "https://escuelaisil.hiringroomcampus.com/check-access"
     }

          form.method = "post"
  
   
          var tokenInput = document.createElement("input")
          tokenInput.type = "hidden"
          tokenInput.name = "token"
          tokenInput.value = response.data.token
  
      
          form.appendChild(tokenInput)
  
        
          document.body.appendChild(form)
  
         
          form.submit()        

    
    }) 
  
 
}

onMounted(() => {
 

  getMostrarDatosX()
  getMostrarDatos()
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