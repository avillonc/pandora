<template> 
  <VCard class="mx-auto">
    <VRow class=" pt-1 ">
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
        <div class="text-sm text-center   px-4 "  style="position: relative; top: -15px;">
          <!-- -->
          <h2 >
            Términos y Condiciones de Matrícula
          </h2>
          
       
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
        <div class="text-sm text-center ">
          <!-- -->
          <h2 class="">
            <strong
              v-if="entityAlumno.nombres"
              class="text-xl text-primary"
            >{{ entityAlumno.nombres  }} {{entityAlumno.apellidos}}</strong>
          </h2>
          
         
        </div>
      </VCol> 
    </VRow>    
    

    <VRow >
      <VCol
        cols="12"
        md="1"
      />
      <VCol
        cols="12"
        md="10"
        class="m-0 m-0"
      >
        <div class="text-sm text-center "  style="position: relative; top: -25px;">
          <!-- -->
 
      
        <small style="text-align: justify; display: block;" class="px-4 ">El presente documento consolida la información concerniente a las estipulaciones reglamentarias que rigen el acto de matrícula en las distintas carreras de ISIL, así como los alcances que se derivan de la condición de alumno matriculado en cualquier ciclo académico. Los presentes términos y condiciones de Matrícula ISIL rigen la relación alumno-institución educativa, en tanto sus alcances no sean materia de modificación e información por ISIL.</small>
        <small style="text-align: justify; display: block;" class="px-4 ">La inscripción y/o matrícula en cualquier carrera de ISIL, implica la aceptación y conformidad por parte de los alumnos y/o padres o apoderados, de las disposiciones contenidas en los presentes Términos y Condiciones que rigen la matrícula en ISIL, sin perjuicio de la aceptación y/o conformidad expresa que pueda obtenerse a través del empleo de medios electrónicos que ponga a disposición ISIL, cuyo uso se reconoce como plenamente válido, para todos los efectos legales.</small>
        <small style="text-align: justify; display: block;" class="px-4 ">
          <ol  style="text-align: justify; display: block;" class="px-4 ">

            <li>La matrícula es el acto formal y voluntario que otorga y acredita la condición de alumno de ISIL y que origina, de pleno derecho, la sujeción a las disposiciones contenidas en los Reglamentos de ISIL, cuyos textos son puestos a disposición en la intranet de Servicios e Información (ISILNet) y son materia de plena información e inherente al proceso de matrícula.</li>
            <li>La matrícula es responsabilidad exclusiva del alumno, quien para ejecutar dicho acto deberá tener en cuenta los artículos pertinentes del Reglamento General de Estudios.</li>
            <li>El responsable de las obligaciones derivadas del acto de matrícula, es el propio alumno matriculado, quien asume como obligación principal el pago de las pensiones de enseñanza dentro del plazo establecido y se somete a las disposiciones reglamentarias que sobre el particular contiene el Reglamento General de Estudios y disposiciones conexas.</li>
            <li>El alumno matriculado se compromete a mantener actualizada la información de sus datos personales, incluyendo su domicilio de residencia, teléfonos fijos y celulares, correo electrónico o cualquier otro medio de contacto que en un futuro se establezca a fin de garantizar la comunicación con ISIL.</li>
            <li>El acto de matrícula no admite, ni permite cruce de horario, entendiéndose por cruce la coincidencia total o parcial de horas entre dos o más cursos.</li>
            <li>El monto de las cuotas correspondientes a las pensiones de ense&ntilde;anza, derivadas del acto de matr&iacute;cula, se reajustan en funci&oacute;n al n&uacute;mero de cursos o cr&eacute;ditos matriculados, recuerda que desde el per&iacute;odo anterior, cualquier excedente a 26 cr&eacute;ditos, tendr&aacute; un costo adicional por cr&eacute;dito. El alumno declara conocer y aceptar el tarifario de pensiones de ense&ntilde;anza a aplicarse en el presente ciclo acad&eacute;mico.</li>
            <li>Es obligación de los alumnos verificar sus horarios, hasta una (1) semana después de iniciadas las clases, a fin de advertir e informarse por ese medio de posibles casos de cierre de bloques o cambios de profesores, en función de la disponibilidad horaria.</li>
        
          </ol>
        </small>
        <small style="text-align: justify; display: block;" class="px-3 ">Por el acto de matrícula efectuado, el alumno declara conocer y aceptar el <a target="_blank" href="https://isilnet.isil.pe/documents/12902/13340/Reglamento+general+de+estudios+202320/37403948-a46b-43fb-860e-c5f3e83abc49"> Reglamento General de Estudios</a> vigente, al cual ha dado minuciosa lectura de manera previa en este formulario y que tambien puede ser consultado en la intranet de Servicios e información (ISILNET).</small>
    <VForm
      ref="form"
      v-model="valid"
      @submit.prevent="terminos"
    >
          <v-row>
              <VCol
                cols="12"
                md="4"
              />    
            <v-col
              cols="12"
              sm="12"
              md="4"
            
            >
          
              <v-radio-group
                inline 
                style="position: relative; top: -5px;"
                :rules="[validators.required]"
                v-model="entityData.radio"
                @change="handleRadioChange"
             
              >
                <v-radio
                  label="ACEPTO LOS TÉRMINOS Y CONDICIONES"
                  value="1"
                  
                  class="mr-15"
                ></v-radio>
            
              </v-radio-group>
            </v-col>
                  <VCol
                    cols="12"
                    md="12"
                    style="position: relative; top: -30px;"
                    class="ml-1"
                  >
                    <VBtn
                      color="primary"
                      type="submit"

                    >
                      Guardar
                    </VBtn>
                  </VCol>    
          </v-row>
     </VForm>
        <VRow class="mt-0 pt-0 text-center mb-3">

        </VRow>  



        </div>
      </VCol> 
    </VRow>
    
  </VCard>
</template>

<script setup> 
import useAppConfig from '@core/@app-config/useAppConfig'
import Swal from 'sweetalert2'
import { required, maxlengthValidator } from '@core/utils/validation.js'

 
let  ex7= 'red'
let  ex8= 'primary'
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
let entityData = ref({ periodo: '',cantidads:'',total:'' ,nombres:'',apellidos:'',radio:'' }) 
let entityAlumno= ref({}) 
const validators = { required}
const $http = inject('http')

const setOverlay = value => {
  overlay.value = value
}

const handleRadioChange = (value) => {
  
  if(value)
  {
    entityData.radio = true
  }
  
};

function loadAlert(text, type = "warning", title = "Advertencia") {
  Swal.fire({
    title: title,
    text: text,
    icon: type,
    confirmButtonColor: '#00BFFF', 
    confirmButtonText: 'ACEPTAR',
  }).then((result) => {
    // Verificar si el usuario hizo clic en 'Aceptar'
    if (result.isConfirmed) {

      // Redirigir al usuario después de hacer clic en 'Aceptar'
      window.location.href = 'https://isilbap.isil.pe/StudentRegistrationSsb/ssb/term/termSelection?mode=registration';
    }
  });
}






function getPeriodoActual(){ 
  $http.post('data/getConfiguration')
    .then(response => { 
      periodo.value = response.data.termcode
      periodoLbl.value = response.data.descripcion  
      entityData.periodo = response.data.termcode

      validateTerminos()
    })
}
function terminos() {
  if (!valid.value) {
      return
    }  
  setOverlay(true)


  $http.post('alumnos/terminos-condiciones-save',{ periodo: entityData.periodo, radio: entityData.radio })
    .then(response => { 

      loadAlert('Se guardó satisfactoriamente', 'success', 'Éxito')
      setOverlay(false)
    })   

}
function validateTerminos() {
  $http.post('alumnos/terminos-validate',{ periodo: entityData.periodo })
    .then(response => { 
      if (response.data.data.length > 0 && response.data.data[0].hasOwnProperty('CAGREE') && response.data.data[0]['CAGREE']) {
        // La propiedad 'CAGREE' existe y su valor es true
        window.location.href = 'https://isilbap.isil.pe/StudentRegistrationSsb/ssb/term/termSelection?mode=registration';
      } else {
        // La propiedad 'CAGREE' no existe o su valor no es true
        setOverlay(false);
      }

    
    
    })     
}
onMounted(() => {
  setOverlay(true)
  entityData.radio =''
  getPeriodoActual()

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