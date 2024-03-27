<template >
  
  <v-layout class="rounded rounded-md mt-0">
   

    <v-main class="d-flex justify-center mt-0" >
      <v-row>
        <v-spacer></v-spacer>
        <v-col cols="12" md="8">
            <v-card class="mx-auto mb-4">

            <v-card-title align="center" class="mb-3">
              <span class="text-primary text-h6">Sondeo de Percepción Docente</span>
            </v-card-title>
              <v-card-text>
                <v-form ref="form"
                  v-model="valid"
                  @submit="onSubmit" 
                  @submit.prevent="validate">
                  <v-row>
                    <v-col cols="12">Por favor, desarrollar el siguiente sondeo <strong>{{termCode || '...'}}</strong></v-col>
                  </v-row>
                  <v-row>
                    <v-col cols="12">Desde: <strong>{{dates.FDESDE == undefined ? '...' : $moment(dates.FDESDE).format('DD/MM/YYYY')}}</strong> 
                      - Hasta: <strong>{{dates.FHASTA == undefined ? '...' :  $moment(dates.FHASTA).format('DD/MM/YYYY')}}</strong></v-col>
                  </v-row>
                  <v-row>
                  <v-divider></v-divider>
                  </v-row>
                  <v-row class="mb-4">
                    <v-col
                      cols="12"
                    >
                      <v-select
                        v-model="entityData.nrc"
                        label="Elija el NRC de la entrevista"
                        :items="nrcs"
                        item-value="NRC"
                        item-title="CURSO"
                        density="compact"
                        :rules="[validators.requiredObject]"
                        @update:modelValue="getsurvey"
                      ></v-select>
                    </v-col>
                  </v-row>
                  <v-row  v-for="(question, i, j=0) in questions"  align="center">
                    <v-col
                      cols="12"
                      md="8"
                      align="justify"
                    > <span class="text-primary">Pregunta {{j+1}}: </span>
                      <p><strong>{{question}}</strong></p>
                    </v-col>
                    <v-col
                      cols="12"
                      md="4"
                    >
                      <v-select
                        v-model="entityData.answer[i]"
                        label="Respuesta"
                        :items="options"
                        item-value="CITEM"
                        item-title="DITEM"
                        density="compact"
                        :rules="[validators.requiredObject]"
                      ></v-select>
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
  import { requiredObject } from '@core/utils/validation.js'
  import { isEmpty } from '@core/utils/index.js'

  const $http = inject('http')
  const $moment = inject('moment')
  const $swal = inject('$swal')

  let { overlay } = useAppConfig()
  const validators = { requiredObject }

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
  let entityData = ref({nrc: null, answer: {}})


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
    $http.get('/students/survey')
      .then(resp => {
        setOverlay(false)
        dates.value = resp.data.dates
        termCode.value = resp.data.term_code

        const hoy = $moment().format('YYYY-MM-DD')

        if( hoy >= dates.value.FDESDE && hoy <= dates.value.FHASTA) {
          nrcs.value = resp.data.nrcs
          questions.value = resp.data.questions
          options.value = resp.data.options
        } else {
          loadAlert('Encuesta fuera de fecha', 'warning', 'Lo sentimos')
        }

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
     $http.post('/students/survey', entityData.value)
      .then(resp => {
        setOverlay(false)
        loadAlert('Encuesta del nrc '+entityData.value.nrc+ ', realizada con éxito!', 'success', 'Éxito')
        form.value.reset()

    }).catch(error => {
        setOverlay(false)
    })
  }

  function getsurvey(){
    if (entityData.value.nrc == null) {
      return
    }

    setOverlay(true)
    entityData.value.answer = {}
    entityData.value.termCode = termCode.value
    $http.post('/students/getsurvey', entityData.value)
      .then(resp => {
        setOverlay(false)
        console.log(resp.data)
        entityData.value.answer = resp.data
    }).catch(error => {
        setOverlay(false)
    })
  }

  function blankEntity(){
    entityData.value = ref({nrc: null, answer: {}})
  }



  onBeforeMount(() => {
    initialize()
  })

</script>
  
