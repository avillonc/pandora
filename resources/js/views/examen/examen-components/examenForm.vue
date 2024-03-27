<template>
  <VCard class="mx-auto">
    <VLayout class="mt-12">
      <VRow>
        <VCol
          cols="12"
          md="12"
        >
          saa
        </VCol>
      </VRow>
    </VLayout>
  </VCard>

  <VCardText class="mt-12">
    <VForm
      ref="form"
      v-model="valid"
      @submit="onSubmit" 
      @submit.prevent="validate"
    >
      <VRow>
        <VCol
          :key="2"
          cols="12"
          md="2"
        />
        <VCol
          :key="2"
          cols="12"
          md="8"
        >
          <VRow>
            <VCol
              cols="12"
              md="12"
              class="mb-0 pb-0"
            >
              <h4 class="mb-0">
                Datos principales:
              </h4>
            </VCol>
          </VRow>
          <VRow>
            <VCol cols="12">
              <VDivider />
            </VCol>
          </VRow> 
          <VRow>
            <VCol
              cols="12"
              md="6"
              class="pb-0"
            >
              <VTextField 
                v-model="entityData.nombres"
                label="Nombres"
                variant="outlined"
                density="compact"
                show-size                            
              />
                            
              <input
                v-model="entityData.pidm"
                type="hidden"
              > 
            </VCol>
            <VCol
              cols="12"
              md="6"
              class="pb-0"
            >
              <VTextField                            
                v-model="entityData.apellidos"
                label="Apellidos"
                density="compact"
                show-size
                :rules="[validators.required]"           
              />
            </VCol>
          </VRow>
          <VRow>
            <VCol
              cols="12"
              md="4"
              class="pb-0"
            >
              <VTextField                                
                v-model="entityData.pais"
                label="Pais"
                variant="outlined"
                density="compact"
                show-size                        
              />
            </VCol>
            <VCol
              cols="12"
              md="4"
              class="pb-0"
            >
              <VTextField                                
                v-model="entityData.estado"
                label="Estado"
                variant="outlined"
                density="compact"
                show-size                        
              />
            </VCol>
                        
            <VCol
              cols="12"
              md="4"
              class="pb-0"
            >
              <VTextField                                
                v-model="entityData.ciudad"
                label="Ciudad"
                variant="outlined"
                density="compact"
                show-size                        
              />
            </VCol>
          </VRow>

          <VRow>
            <VCol
              cols="12"
              md="4"
              class="pb-0"
            >
              <VTextField
                v-model="entityData.cod_postal"
                label="Código postal"
                variant="outlined"
                density="compact"
              />
            </VCol>
            <VCol
              cols="12"
              md="8"
              class="pb-0"
            >
              <VTextField
                v-model="entityData.direccion"
                label="Dirección"
                variant="outlined"
                density="compact"
                :rules="[validators.required]"
              />
            </VCol> 
          </VRow>
          <VRow>
            <VCol
              cols="12"
              md="4"
              class="pb-0"
            >
              <VTextField
                v-model="entityData.celular"
                label="Teléfono celular"
                variant="outlined"
                density="compact"                   
              />
            </VCol>
            <VCol
              cols="12"
              md="4"
              class="pb-0"
            >
              <VTextField
                v-model="entityData.tel_casa"
                label="Teléfono de casa"
                variant="outlined"
                density="compact"
              />
            </VCol>
            <VCol
              cols="12"
              md="4"
              class="pb-0"
            >
              <VTextField
                v-model="entityData.email"
                label="E-mail"
                variant="outlined"
                density="compact"
              />
            </VCol>
          </VRow>
          <VRow>
            <VCol
              cols="12"
              md="4"
              class="pb-4"
            >
              <VTextField
                v-model="entityData.fec_nacimiento"
                label="Fecha de nacimiento"
                outlined            
                type="date"
                dense
                density="compact"
              />
            </VCol>
            <VCol
              cols="12"
              md="4"
              class="pb-4"
            >
              <VTextField
                v-model="entityData.num_identificacion"
                label="Número de identificación"
                variant="outlined"
                density="compact"
              />
            </VCol>
            <VCol
              cols="12"
              md="3"
              class="pb-0"
            >
              <VRadioGroup
                v-model="entityData.sexo"
                inline
              >
                <VRadio
                  label="Femenino"
                  value="1"
                />
                <VRadio
                  label="Masculino"
                  value="2"
                />
              </VRadioGroup>
            </VCol> 
          </VRow>
        </VCol>
        <VCol
          :key="2"
          cols="12"
          md="2"
        />
      </VRow>
      <VRow>
        <VCol
          :key="2"
          cols="12"
          md="2"
        />
        <VCol
          :key="2"
          cols="12"
          md="8"
        >
          <VRow>
            <VCol
              cols="12"
              md="8"
              class="mb-0 pb-0"
            >
              <h4>Información para admisiones: </h4>
            </VCol>
          </VRow>
          <VRow>
            <VCol cols="12">
              <VDivider />
            </VCol>
          </VRow> 
          <VRow>
            <VCol
              cols="12"
              md="12"
            >
              <VAutocomplete
                v-model="entityData.majr_code"
                label="Programa"
                variant="outlined"
                density="compact"
                :items="programs"
                item-title="name"
                item-value="majr_code"
                :menu-props="{ offsetY: true }"
                hide-details="auto"
                single-line
                :rules="[validators.required]"
                @update:modelValue="changeProgram"
              />
            </VCol>              
          </VRow>
          <VRow>
            <VCol
              cols="12"
              md="12"
            >
              <VAutocomplete
                v-model="entityData.forma_pago"
                label="Forma de pago"
                variant="outlined"
                density="compact"
                :items="formas_pago"
                item-title="descripcion"
                item-value="id"
                :menu-props="{ offsetY: true }"
                hide-details="auto"
                :rules="[validators.requiredObject]"
              />
            </VCol>
          </VRow>
          <VRow>
            <VCol
              cols="12"
              md="6"
            >
              <VSelect
                v-model="entityData.term_code"                 
                label="Semestre"
                variant="outlined"                  
                density="compact"
                :items="termscode"
                item-title="period_desc"
                item-value="period_val"
                single-line
                :rules="[validators.required]"                                
              />
            </VCol>

            <VCol
              cols="12"
              md="6"
            >
              <VSelect
                v-model="entityData.tipo_estudiante"                 
                label="Tipo de estudiante"
                variant="outlined"   
                density="compact"
                :items="tipos_est"
                item-title="descr"               
                item-value="id"
                single-line
                :rules="[validators.requiredObject]"
              />
            </VCol>
          </VRow>
        </VCol>
        <VCol
          :key="2"
          cols="12"
          md="2"
        />
      </VRow>

      <VRow v-if="entityData.tipo_estudiante==3">
        <VCol
          :key="2"
          cols="12"
          md="2"
        />
        <VCol
          :key="2"
          cols="12"
          md="8"
        >
          <VRow>
            <VCol
              cols="12"
              md="8"
              class="mb-0 pb-0"
            >
              <h4>Estudiante Transferido: </h4>
            </VCol>
          </VRow>
          <VRow>
            <VCol cols="12">
              <VDivider />
            </VCol>
          </VRow> 
          <VRow>
            <VCol
              cols="12"
              md="8"
              class="pb-0"
            >
              <VTextField
                            
                v-model="entityData.nom_institucion"
                label="Nombre de la institución"
                variant="outlined"
                density="compact"
                show-size
              />
            </VCol>
            <VCol
              cols="12"
              md="4"
            >
              <VTextField
                            
                v-model="entityData.tel_institucion"
                label="Teléfono"
                variant="outlined"
                density="compact"
                show-size
              />
            </VCol>
          </VRow> 
          <VRow>
            <VCol
              cols="12"
              md="4"
            >
              <VTextField
                v-model="entityData.desde"
                label="Desde"
                outlined            
                type="date"
                dense
                density="compact"
              />
            </VCol>
            <VCol
              cols="12"
              md="4"
            >
              <VTextField
                v-model="entityData.hasta"
                label="Hasta"
                outlined            
                type="date"
                dense
                density="compact"
              />
            </VCol>
            <VCol
              cols="12"
              md="4"
            >
              <VTextField                            
                v-model="entityData.creditos"
                type="number"
                label="Cantidad de créditos cursados"
                variant="outlined"
                density="compact"
                show-size
              />
            </VCol>
          </VRow>
          <VRow>
            <VCol
              cols="12"
              md="12"
            >
              <i>Atendiste otras instituciones de educación superior</i>
            </VCol>
          </VRow>
          <VRow>
            <VCol
              cols="12"
              md="2"
            >
              <VRadioGroup
                v-model="entityData.otrasInst"
                inline
              >
                <VRadio
                  label="SI"
                  value="radio-1"
                />
                <VRadio
                  label="NO"
                  value="radio-2"
                />
              </VRadioGroup>
            </VCol>
            <VCol
              cols="12"
              md="8"
            >
              <VTooltip
                location="top"
                text="Agregar"
              >
                <template #activator="{ props }">
                  <VAvatar
                    size="28"
                    color="primary"
                    v-bind="props"
                    class="mr-1"
                  >
                    <VIcon
                      size="20"
                      icon="mdi-plus"
                      color="white"
                    />
                  </VAvatar>
                </template>
              </VTooltip>
            </VCol>
          </VRow>
        </VCol>
        <VCol
          :key="2"
          cols="12"
          md="2"
        />
      </VRow>

      <VRow v-if="entityData.tipo_estudiante==1">
        <VCol
          :key="2"
          cols="12"
          md="2"
        />
        <VCol
          :key="2"
          cols="12"
          md="8"
        >
          <VRow>
            <VCol
              cols="12"
              md="8"
              class="mb-0 pb-0"
            >
              <h4>Estudiante Nuevo: </h4>
            </VCol>
          </VRow>
          <VRow>
            <VCol cols="12">
              <VDivider />
            </VCol>
          </VRow> 
          <VRow>
            <VCol
              cols="12"
              md="3"
              class="pb-0"
            >
              <VLabel>Secundaria</VLabel>
              <VRadioGroup
                v-model="entityData.secundaria"
                inline
              >
                <VRadio
                  label="SI"
                  value="1"
                />
                <VRadio
                  label="NO"
                  value="2"
                />
              </VRadioGroup>
            </VCol> 
            <VCol
              cols="12"
              md="3"
              class="pb-0"
            >
              <VLabel>Asociado (carrera técnica)</VLabel>
              <VRadioGroup
                v-model="entityData.carr_tecnica"
                inline
              >
                <VRadio
                  label="SI"
                  value="1"
                />
                <VRadio
                  label="NO"
                  value="2"
                />
              </VRadioGroup>
            </VCol> 
            <VCol
              cols="12"
              md="3"
              class="pb-0"
            >
              <VLabel>Programas de bachelor</VLabel>
              <VRadioGroup
                v-model="entityData.bachelor"
                inline
              >
                <VRadio
                  label="SI"
                  value="1"
                />
                <VRadio
                  label="NO"
                  value="2"
                />
              </VRadioGroup>
            </VCol> 
            <VCol
              cols="12"
              md="3"
              class="pb-0"
            >
              <VLabel>Programas de máster</VLabel>
              <VRadioGroup
                v-model="entityData.master"
                inline
              >
                <VRadio
                  label="SI"
                  value="1"
                />
                <VRadio
                  label="NO"
                  value="2"
                />
              </VRadioGroup>
            </VCol> 
          </VRow> 
        </VCol>
      </VRow>
      <VRow>
        <VCol
          :key="2"
          cols="12"
          md="2"
        />
        <VCol
          :key="2"
          cols="12"
          md="8"
        >
          <VRow class="mb-5">
            <VCol
              cols="12"
              md="8"
            />
            <VCol
              cols="12"
              md="4"
            >
              <VBtn
                block
                color="success"
                type="submit"
              >
                <VIcon
                  left
                  dark
                  icon="mdi-content-save"
                />
                Guardar
              </VBtn>
            </VCol>
          </VRow>
        </VCol>
        <VCol
          :key="2"
          cols="12"
          md="2"
        />
      </VRow>
    </VForm>
  </VCardText>
</template>

<script>
import useAppConfig from '@core/@app-config/useAppConfig'
import { minNumber, required, requiredObject } from '@core/utils/validation.js'
import { ref } from 'vue'

//import * as moment from 'moment'

export default {
  props: {
    entityData: {
      type: Object,
      required: true,
    },
    pidm: {
      type: String,
      required: true,
    },
  },
  setup() {    
    let { overlay } = useAppConfig()

    //const $swal = inject('$swal')
    let termscode = ref([])
    let programs = ref([])
    let pmethods = ref([])
    let formas_pago = ref([])

    //let entityData = ref({})
    let tipos_est = ref([{ id: 1, descr: 'Nuevo' }, { id: 2, descr: 'Readmitido' },  { id: 3, descr: 'Transferido' }])
    const valid = ref(false)
    const form = ref(null)
    const $http = inject('http')

    const validate = () => {
      form.value.validate()
    }

    
    return {
      valid,
      form,
      validate,
      validators: { 
        minNumber,
        required,              
        requiredObject },

      //entityData,
      termscode,
      programs,
      formas_pago,
      tipos_est,
      pmethods,
      overlay,
    }
  },
  beforeMount(){
    //this.entityData.tipo_estudiante = null
  },
  mounted(){
    this.overlay = true

    //this.pidm = 99
    
    this.getMisDatos()
    this.getPrograms()
    this.getTermCodes()
    this.getPmethods()
  },
  methods: {
    onSubmit(){
      //console.log(this.valid); return;
      if (this.valid) {
        this.overlay = true

        //console.log(this.entityData.value); return; 
        this.$http.post('mis-datos/save', this.entityData)
          .then(response => {
            window.scrollTo({ top: 0, behavior: 'smooth' })
            this.overlay = false
                  
            this.loadAlert(response.data.mensaje, 'success', 'Éxito')
                
          }).catch(err =>{
                  

          })

        /*.catch(error => {     
                    this.overlay = false
                    this.$emit('load-alert', error.response.data.message)
            }) */      
      } else {
        this.validate()
        this.loadAlert('Tiene campos incompletos')
        let elementsInErrors = document.getElementsByClassName('error--text')
        if (elementsInErrors && elementsInErrors.length > 0) {
          elementsInErrors[0].scrollIntoView({ behavior: 'smooth', block: 'center' })
        }
      }
    },
    loadAlert(text, type="error", title="Advertencia"){
      //this.$store.commit('appConfig/TOGGLE_SNACKBAR', {show: true, text: text, color: type})
      this.$swal.fire({
        title: title,
        text: text,
        icon: type,
        confirmButtonText: 'OK',
      }).then(result => {
        if (result.isConfirmed) {
          //document.querySelectorAll("#btnRegresar").forEach(el=>el.click())
          //document.querySelectorAll("#btnConsultar").forEach(el=>el.click())
                
        }
      })
    },
    formatDate(date) {
      if (date !== null) {
        return this.$moment(date).format('MM-DD-YYYY')
      } 

      return '-'
    },
    getTermCodes(){
      this.$http.get('data/termcode')
        .then(response => {
          this.termscode = response.data

          // setOverlay(false)
          this.overlay = false
        })
    },
    getPrograms() {
      this.$http.get('data/getPrograms')
        .then(response => {
          this.programs = response.data
        })
    },
    getPmethods(){
      this.$http.post('data/getPaymentMethods')
        .then(response => {
          this.formas_pago = response.data
          this.$forceUpdate()
        })
    },
    changeProgram(){
        
      if(this.entityData.majr_code=='HMKT' || this.entityData.majr_code=='HADM' || this.entityData.majr_code=='HADS' || this.entityData.majr_code=='HMKS'){
        this.entityData.program_type=1 
      }else{
        this.entityData.program_type=2
      }
    },
    getMisDatos(){
        
      this.$http.post('data/getMisDatos')
        .then(response => { 
            
          this.entityData.nombres = response.data.result.NOMBRES
          this.entityData.apellidos = response.data.result.APELLIDOS
          this.entityData.pais = response.data.result.IDPAIS
          this.entityData.estado = response.data.result.IDDEPARTAMENTO
          this.entityData.ciudad = response.data.result.IDPROVINCIA
          this.entityData.cod_postal = response.data.result.IDDISTRITO
          this.entityData.direccion = response.data.result.DIRECCION
          this.entityData.celular = response.data.result.TELEF_CEL
          this.entityData.tel_casa = response.data.result.TELEF_CASA
          this.entityData.email = response.data.result.EMAIL
          this.entityData.fec_nacimiento = response.data.result.FECHANAC
          this.entityData.num_identificacion = response.data.result.SSN
          this.entityData.pidm = response.data.result.PIDM

          //console.log(this.entityData)
        })  
    },
  },
}
</script>
