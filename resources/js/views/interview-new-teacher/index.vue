<template >
  
  <v-layout class="rounded rounded-md mt-0">
   

    <v-main class="d-flex justify-center mt-0" >
      <v-row>
        <v-spacer></v-spacer>
        <v-col cols="12" md="8">
            <v-card class="mx-auto mb-4">

            <v-card-title align="center" class="mb-3">
              <span class="text-primary text-h6">Docente Nuevos: Entrevista Inicial</span>
            </v-card-title>
              <v-card-text>
                <v-form ref="form"
                  v-model="valid"
                  @submit="onSubmit" 
                  @submit.prevent="validate"
                  @update:modelValue="(valid) => {  if (valid == null && entityData.answer['DPREG1'] !== null) validate()  }">
                  <v-row>
                    <v-col cols="12">Por favor, desarrollar el siguiente cuestionario <strong>{{termCode || '...'}}</strong></v-col>
                  </v-row>
                  <v-row>
                    <v-col cols="12">Desde: <strong>{{dates.FDESDE == undefined ? '...' : $moment(dates.FDESDE).format('DD/MM/YYYY')}}</strong> 
                      - Hasta: <strong>{{dates.FHASTA == undefined ? '...' :  $moment(dates.FHASTA).format('DD/MM/YYYY')}}</strong></v-col>
                  </v-row>
                  <v-row>
                  <v-divider></v-divider>
                  </v-row>
                  <v-row  v-for="(question, i, j=0) in questions"  align="center" style="">
                    <v-col
                      cols="12"
                      align="justify"
                    > <span class="text-primary">Pregunta {{j+1}}: </span>
                      <p><strong>{{question}}</strong></p>
                    </v-col>
                    <v-col
                      cols="12"
                    >
                      <v-textarea
                        no-resize
                        rows="1"
                        v-model="entityData.answer[i]"
                        density="compact"
                        :rules="[validators.required, validators.maxlengthValidator(entityData.answer[i], 1024)]"
                      ></v-textarea>
                    </v-col>
                  </v-row>
                  <v-row>
                    <v-col
                      offset-md="8"
                      cols="12"
                      md="4"
                    >
                      <v-btn v-if="questions.DPREG1!=undefined"  block color="success" type="submit"
                        :disabled="overlay"
                        :loading="overlay">
                        <v-icon
                                  left
                                  dark
                                  icon="mdi-check-all"
                                  class="mr-2"
                                >
                                </v-icon>
                        CONFIRMAR 
                      </v-btn>
                    </v-col>
                  </v-row>
                </v-form>
                  
              </v-card-text>
    

            </v-card>
        </v-col>
        <v-spacer></v-spacer>
      </v-row>
      
    </v-main>
  </v-layout>
</template>
  
<script setup> 

  import useAppConfig from '@core/@app-config/useAppConfig';
  import { required, maxlengthValidator } from '@core/utils/validation.js'
  import { isEmpty } from '@core/utils/index.js'

  const $http = inject('http')
  const $moment = inject('moment')
  const $swal = inject('$swal')

  let { overlay } = useAppConfig()
  const validators = { required, maxlengthValidator }

  const valid = ref(false)
  const form = ref(null)
  let validate = () => {
    form.value.validate()
  }

  let nrcs = ref([])
  let dates = ref({})
  let questions = ref({})
  let termCode = ref('')
  let options = ref([])
  let entityData = ref({answer: {}})


  const setOverlay = (value) => {
      overlay.value = value
  }

  function loadAlert(text, type="error", title="Advertencia"){
      $swal.fire({
              title: title,
              text: text,
              icon: type,
              confirmButtonText: 'OK',
            })
  }

  function  initialize() {
    setOverlay(true)
    $http.get('/students/interview-new')
      .then(resp => {
        setOverlay(false)
        dates.value = resp.data.dates
        termCode.value = resp.data.term_code

        const hoy = $moment().format('YYYY-MM-DD')

        //if( hoy >= dates.value.FDESDE && hoy <= dates.value.FHASTA) {
          questions.value = resp.data.questions
          options.value = resp.data.options
          entityData.value.answer = resp.data.answer
        //} else {
          //loadAlert('Encuesta fuera de fecha', 'warning', 'Lo sentimos')
        //}
    }).catch(error => {
        setOverlay(false)
        loadAlert(error.response.data.message, 'warning', 'Lo sentimos')
    })
  }

  function onSubmit(){
    if (!valid.value) {
        return
    }
    setOverlay(true)
     entityData.value.termCode = termCode.value
     $http.post('/students/interview-new', entityData.value)
      .then(resp => {
        setOverlay(false)
        loadAlert('Encuesta del '+entityData.value.termCode+ ', realizada con éxito!', 'success', 'Éxito')

    }).catch(error => {
        setOverlay(false)
    })
  }

  function blankEntity(){
    entityData.value = ref({answer: {}})
  }



  onBeforeMount(() => {
    initialize()
  })

</script>
  
