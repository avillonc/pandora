<template >
  
  <v-layout class="rounded rounded-md mt-0">
   

    <v-main class="d-flex justify-center mt-0" >
      <v-row>
        <v-spacer></v-spacer>
        <v-col cols="12" md="6">
            <v-card class="mx-auto">

            <v-card-title align="center" class="mb-3">
              <span class="text-primary text-h6">Solicitud de Servicios</span>
            </v-card-title>
              <v-card-text v-show ="step == 1">
                  <v-row >
                    <v-col
                      cols="12"
                    >
                      <v-select
                        v-model="entityData.service"
                        label="Selecciona el servicio"
                        :items="services"
                        item-value="CCONST"
                        item-title="DCONST"
                        density="compact"
                        :rules="[validators.requiredObject]"
                        @update:modelValue="loadPhoto"
                      ></v-select>
                    </v-col>
                  </v-row>
                  <v-row >
                    <v-col
                      cols="12"
                    >
                      <v-card :loading="loading"
                       elevation="0">
                      <v-img
                        max-height="300"
                        :src="photo"
                      ></v-img>
                    </v-card>
                    </v-col>
                  </v-row>            
                  <v-row>
                    <v-col
                      offset-md="8"
                      cols="12"
                      md="4"
                    >
                      <v-btn v-if="entityData.service!=null" block color="success" 
                        @click="getStep2"
                        :loading="loading">
                        CONTINUAR
                        <v-icon
                                  left
                                  dark
                                  icon="mdi-arrow-right-thick"
                                  class="ml-2"
                                >
                                </v-icon>
                         
                      </v-btn>
                    </v-col>
                  </v-row>
              </v-card-text>
    
              <v-card-text v-show ="step == 2">
                <p><span class="mb-4 font-weight-bold">Confirma tus datos</span></p>
                <v-form ref="form"
                  v-model="valid"
                  @submit="onSubmit" 
                  @submit.prevent="validate">
                  <v-row >
                    <v-col
                      cols="12"
                      md="6"
                    >
                      <v-text-field
                        label="Nombres"
                        v-model="entityData.first_name"
                        variant="outlined"
                        density="compact"
                        hide-details="auto"
                        :rules="[validators.required]"
                        readonly
                      ></v-text-field>
                    </v-col>
                    <v-col
                      cols="12"
                      md="6"
                    >
                      <v-text-field
                        label="Apellidos"
                        v-model="entityData.last_name"
                        variant="outlined"
                        density="compact"
                        hide-details="auto"
                        :rules="[validators.required]"
                        readonly
                      ></v-text-field>
                    </v-col>
                    <v-col
                      cols="12"
                      md="6"
                    >
                      <v-text-field
                        label="Nro documento"
                        v-model="entityData.documento"
                        variant="outlined"
                        density="compact"
                        hide-details="auto"
                        :rules="[validators.required]"
                        readonly
                      ></v-text-field>
                    </v-col>
                    <v-col
                      cols="12"
                      md="6"
                    >
                      <v-text-field
                        label="Correo"
                        v-model="entityData.email"
                        variant="outlined"
                        density="compact"
                        hide-details="auto"
                        :rules="[validators.required]"
                        readonly
                      ></v-text-field>
                    </v-col>
                    <v-col
                      cols="12"
                    >
                    <v-select
                        v-model="entityData.major_code"
                        label="Selecciona carrera"
                        :items="majors"
                        item-value="SORLFOS_MAJR_CODE"
                        item-title="STVMAJR_DESC"
                        density="compact"
                        return-object
                        :rules="[validators.requiredObject]"
                      ></v-select>
                    </v-col>
                  </v-row>
                  <v-row v-if="entityData.service == 'CCPP'">
                    <v-col
                      cols="12"
                    >
                      <v-text-field
                        label="Nombre de la empresa"
                        v-model="entityData.organization"
                        variant="outlined"
                        density="compact"
                        hide-details="auto"
                        :rules="[validators.required]"
                      ></v-text-field>
                    </v-col>
                    <v-col
                      cols="12"
                    >
                      <v-text-field
                        label="Persona a Cargo"
                        v-model="entityData.coordinator"
                        variant="outlined"
                        density="compact"
                        hide-details="auto"
                        :rules="[validators.required]"
                      ></v-text-field>
                    </v-col>
                    <v-col
                      cols="12"
                    >
                      <v-text-field
                        label="Cargo"
                        v-model="entityData.job"
                        variant="outlined"
                        density="compact"
                        hide-details="auto"
                        :rules="[validators.required]"
                      ></v-text-field>
                    </v-col>
                  </v-row>
                  <v-row>
                    <v-col
                      cols="12"
                    >
                      <v-checkbox v-model="entityData.check"
                        :true-value="true">
                        <template v-slot:label>
                          <div>
                            He leido y acepto las <a href="/downloads/terminos_servicios.pdf" target="_blank">Politicas, Términos y condiciones</a>
                          </div>
                        </template>
                      </v-checkbox>
                    </v-col>
                  </v-row>

                  <v-row>
                    <v-spacer></v-spacer>
                    <v-col
                      cols="12"
                      xs="4"
                      md="4"
                    >
                      <v-btn block color="primary" type="submit"
                        :disabled="!entityData.check"
                        >FINALIZAR
                        <v-icon
                                  left
                                  dark
                                  icon="mdi-check-all"
                                  class="ml-2"
                                >
                                </v-icon>
                         
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
  import { requiredObject, required, maxlengthValidator } from '@core/utils/validation.js'
  import { isEmpty } from '@core/utils/index.js'

  let filename = ref("CCDT")

  //import photo from "`@images/formatos/CCDT.png`"

  const $http = inject('http')
  const $moment = inject('moment')
  const $swal = inject('$swal')

  let { overlay } = useAppConfig()
  const validators = { requiredObject, maxlengthValidator, required }

  const valid = ref(false)
  const form = ref(null)
  let loading = ref(false)
  let step = ref(1)

  let validate = () => {
    form.value.validate()
  }

  let services = ref([])
  let majors = ref([])
  let entityData = ref({service: null, 
    check: false, 
    documento: null,
    })
  let photo = ref(null)

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
    $http.get('/students/service')
      .then(resp => {
        setOverlay(false)
        services.value = resp.data
    }).catch(error => {
        setOverlay(false)
        loadAlert(error.response.data.message, 'warning', 'Lo sentimos')
    })
  }

  function getStep2() {
    step.value = 2
    setOverlay(true)
    $http.post('/students/getdatos', {})
      .then(resp => {
        entityData.value.first_name = resp.data.identity.SPRIDEN_FIRST_NAME
        entityData.value.last_name = resp.data.identity.SPRIDEN_LAST_NAME
        entityData.value.email = resp.data.identity.EMAIL
        entityData.value.documento = resp.data.identity.DOC
        majors.value = resp.data.majors
        setOverlay(false)
    }).catch(error => {
        setOverlay(false)
        loadAlert(error.response.data.message, 'warning', 'Lo sentimos')
    })
  }

  function onSubmit(){
    if (!valid.value) {
        return
    }

    if (!entityData.value.check) {
        loadAlert('Revise y acepte los Términos y condiciones', 'warning', 'Importante')
    }

    setOverlay(true)
     $http.post('/students/service', entityData.value)
      .then(resp => {
        setOverlay(false)

        $swal.fire({
          icon: "success",
          title: "Éxito",
          text: "Estás a un paso de obtener tu documento digital, solo debes realizar el pago correspondiente y luego se te enviará a tu correo.",
          confirmButtonText: '<a href="https://ecommerce.isil.pe/alumnos/saldo/consultar" style="color: white;" target="_blank">PAGAR</a>'
        });
        step.value = 1
        blankEntity()
        form.value.reset()
    }).catch(error => {
        setOverlay(false)
    })
  }

  function blankEntity(){
    entityData.value = ref({service: null, check: false})
  }

  function loadPhoto(){
      loading.value = true
      $http.get('students/service/'+entityData.value.service)
          .then(response => {
              photo.value = response.data     
              loading.value = false     
      })
  }

  onBeforeMount(() => {
    initialize()
  })

</script>
  
