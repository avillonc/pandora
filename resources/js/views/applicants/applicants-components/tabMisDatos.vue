<template>
    <v-card-text class="mt-3">
        <v-form ref="form"
            v-model="valid"
            @submit="onSubmit" 
            @submit.prevent="validate">
            <v-row>
                <v-col :key="2" cols="12" md="2" ></v-col>
                <v-col :key="2" cols="12" md="8" >
                    <v-row >
                        <v-col cols="12" md="12" class="mb-0 pb-0">
                        <h4 class="mb-0">Datos principales: </h4>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12"> <v-divider></v-divider></v-col>
                    </v-row> 
                    <v-row>
                        <v-col cols="12" md="6" class="pb-0">
                            <v-text-field 
                            label="Nombres"
                            variant="outlined"
                            density="compact"
                            show-size
                            v-model="entityData.nombres"                            
                            ></v-text-field>
                            
                            <input type="hidden" v-model="entityData.pidm"> 
                        </v-col>
                        <v-col cols="12" md="6" class="pb-0">
                            <v-text-field                            
                            label="Apellidos"
                            v-model="entityData.apellidos"
                            density="compact"
                            show-size
                            :rules="[validators.required]"           
                            ></v-text-field>
                        </v-col>
                        
                    </v-row>
                    <v-row  >
                        <v-col cols="12" md="4" class="pb-0">
                            <v-text-field                                
                                label="Pais"
                                variant="outlined"
                                v-model="entityData.pais"
                                density="compact"
                                show-size                        
                                ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="4" class="pb-0">
                            <v-text-field                                
                                label="Estado"
                                variant="outlined"
                                v-model="entityData.estado"
                                density="compact"
                                show-size                        
                                ></v-text-field>
                        </v-col>
                        
                        <v-col cols="12" md="4" class="pb-0">
                            <v-text-field                                
                                label="Ciudad"
                                variant="outlined"
                                v-model="entityData.ciudad"
                                density="compact"
                                show-size                        
                                ></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row >
                        <v-col
                        cols="12"
                        md="4"
                        class="pb-0"
                        >
                        <v-text-field
                            label="Código postal"
                            variant="outlined"
                            density="compact"
                            v-model="entityData.cod_postal"
                        ></v-text-field>
                        </v-col>
                        <v-col
                        cols="12"
                        md="8"
                        class="pb-0"
                        >
                        <v-text-field
                            label="Dirección"
                            variant="outlined"
                            density="compact"
                            v-model="entityData.direccion"
                            :rules="[validators.required]"
                        ></v-text-field>
                        </v-col> 
                    </v-row>
                    <v-row >
                        <v-col cols="12" md="4" class="pb-0">
                        <v-text-field
                            label="Teléfono celular"
                            variant="outlined"
                            density="compact"
                            v-model="entityData.celular"                   
                        ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="4" class="pb-0">
                        <v-text-field
                            label="Teléfono de casa"
                            variant="outlined"
                            density="compact"
                            v-model="entityData.tel_casa"
                        ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="4" class="pb-0">
                        <v-text-field
                            label="E-mail"
                            variant="outlined"
                            density="compact"
                            v-model="entityData.email"
                        ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row >
                        <v-col cols="12" md="4" class="pb-4">
                            <v-text-field
                            label="Fecha de nacimiento"
                            outlined
                            type="date"            
                            dense
                            density="compact"
                            v-model="entityData.fec_nacimiento"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="4" class="pb-4">
                            <v-text-field
                                label="Número de identificación"
                                variant="outlined"
                                density="compact"
                                v-model="entityData.num_identificacion"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="3" class="pb-0">
                                <v-radio-group
                                        v-model="entityData.sexo"
                                        inline
                                    >
                                <v-radio
                                    label="Femenino"
                                    value="1"
                                ></v-radio>
                                <v-radio
                                    label="Masculino"
                                    value="2"
                                ></v-radio>
                            </v-radio-group>
                        </v-col> 
                    </v-row>
                    </v-col>
                    <v-col :key="2" cols="12" md="2" ></v-col>
            </v-row>
            <v-row>
                <v-col :key="2" cols="12" md="2"></v-col>
                <v-col :key="2" cols="12" md="8">
                    <v-row >
                        <v-col cols="12" md="8" class="mb-0 pb-0">
                            <h4 >Información para admisiones: </h4>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12" > <v-divider></v-divider></v-col>
                    </v-row> 
                    <v-row >
                        <v-col cols="12" md="12">
                            <v-autocomplete
                            label="Programa"
                            v-model="entityData.majr_code"
                            variant="outlined"
                            density="compact"
                            :items="programs"
                            item-title="name"
                            item-value="majr_code"
                            :menu-props="{ offsetY: true }"
                            hide-details="auto"
                            single-line
                            @update:modelValue="changeProgram"
                            :rules="[validators.required]"
                            ></v-autocomplete>
                        </v-col>              
                    </v-row>
                    <v-row>
                        <v-col cols="12" md="12" >
                            <v-autocomplete
                                label="Forma de pago"
                                v-model="entityData.forma_pago"
                                variant="outlined"
                                density="compact"
                                :items="formas_pago"
                                item-title="descripcion"
                                item-value="id"
                                :menu-props="{ offsetY: true }"
                                hide-details="auto"
                                :rules="[validators.requiredObject]"
                            ></v-autocomplete>
                        </v-col>
                    </v-row>
                    <v-row >
                        <v-col cols="12" md="6"  >
                            <v-select
                                label="Semestre"                 
                                variant="outlined"
                                density="compact"                  
                                :items="termscode"
                                item-title="period_desc"
                                item-value="period_val"
                                v-model="entityData.term_code"
                                single-line
                                :rules="[validators.required]"                                
                            ></v-select>
                        </v-col>

                        <v-col cols="12" md="6" >
                        <v-select
                            label="Tipo de estudiante"                 
                            variant="outlined"
                            density="compact"   
                            :items="tipos_est"
                            item-title="descr"
                            item-value="id"               
                            v-model="entityData.tipo_estudiante"
                            single-line
                            :rules="[validators.requiredObject]"
                        ></v-select>
                        </v-col>
                    </v-row>
                </v-col>
                <v-col
                :key="2"
                cols="12"
                md="2"
                >
                </v-col>
            </v-row>

            <v-row v-if="entityData.tipo_estudiante==3">
                <v-col :key="2" cols="12" md="2"></v-col>
                <v-col :key="2" cols="12" md="8">
                    <v-row >
                        <v-col cols="12" md="8" class="mb-0 pb-0">
                            <h4 >Estudiante Transferido: </h4>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12" > <v-divider></v-divider></v-col>
                    </v-row> 
                    <v-row >
                        <v-col cols="12" md="8" class="pb-0">
                            <v-text-field
                            
                            label="Nombre de la institución"
                            variant="outlined"
                            density="compact"
                            show-size
                            v-model="entityData.nom_institucion"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-text-field
                            
                            label="Teléfono"
                            variant="outlined"
                            density="compact"
                            show-size
                            v-model="entityData.tel_institucion"
                            ></v-text-field>
                        </v-col>
                    </v-row> 
                    <v-row >
                        <v-col cols="12" md="4"  >
                            <v-text-field
                                label="Desde"
                                outlined
                                type="date"            
                                dense
                                density="compact"
                                v-model="entityData.desde"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="4" >
                            <v-text-field
                                label="Hasta"
                                outlined
                                type="date"            
                                dense
                                density="compact"
                                v-model="entityData.hasta"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="4" >
                            <v-text-field                            
                            type="number"
                            label="Cantidad de créditos cursados"
                            variant="outlined"
                            density="compact"
                            show-size
                            v-model="entityData.creditos"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12" md="12">
                            <i>Atendiste otras instituciones de educación superior</i>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12" md="2">
                            <v-radio-group
                                    v-model="entityData.otrasInst"
                                    inline
                                >
                                    <v-radio
                                        label="SI"
                                        value="radio-1"
                                    ></v-radio>
                                    <v-radio
                                        label="NO"
                                        value="radio-2"
                                    ></v-radio>
                                </v-radio-group>
                        </v-col>
                        <v-col cols="12" md="8">
                            <v-tooltip location="top" text="Agregar">
                                <template v-slot:activator="{ props }">
                                    <v-avatar size="28" color="primary" v-bind="props" class="mr-1">
                                        <v-icon size="20" icon="mdi-plus" color="white">
                                        </v-icon>
                                    </v-avatar>
                                </template>
                            </v-tooltip>
                        </v-col>
                    </v-row>

                </v-col>
                <v-col
                :key="2"
                cols="12"
                md="2"
                >
                </v-col>
            </v-row>

            <v-row v-if="entityData.tipo_estudiante==1">
                <v-col :key="2" cols="12" md="2"></v-col>
                <v-col :key="2" cols="12" md="8">
                    <v-row >
                        <v-col cols="12" md="8" class="mb-0 pb-0">
                            <h4 >Estudiante Nuevo: </h4>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12" > <v-divider></v-divider></v-col>
                    </v-row> 
                    <v-row >
                        <v-col cols="12" md="3" class="pb-0">
                            <v-label>Secundaria</v-label>
                                <v-radio-group
                                        v-model="entityData.secundaria"
                                        inline
                                    >
                                <v-radio
                                    label="SI"
                                    value="1"
                                ></v-radio>
                                <v-radio
                                    label="NO"
                                    value="2"
                                ></v-radio>
                            </v-radio-group>
                        </v-col> 
                        <v-col cols="12" md="3" class="pb-0">
                            <v-label>Asociado (carrera técnica)</v-label>
                                <v-radio-group
                                    v-model="entityData.carr_tecnica"
                                    inline
                                >
                                <v-radio
                                    label="SI"
                                    value="1"
                                ></v-radio>
                                <v-radio
                                    label="NO"
                                    value="2"
                                ></v-radio>
                            </v-radio-group>
                        </v-col> 
                        <v-col cols="12" md="3" class="pb-0">
                            <v-label>Programas de bachelor</v-label>
                                <v-radio-group
                                    v-model="entityData.bachelor"
                                    inline
                                >
                                <v-radio
                                    label="SI"
                                    value="1"
                                ></v-radio>
                                <v-radio
                                    label="NO"
                                    value="2"
                                ></v-radio>
                            </v-radio-group>
                        </v-col> 
                        <v-col cols="12" md="3" class="pb-0">
                            <v-label>Programas de máster</v-label>
                                <v-radio-group
                                    v-model="entityData.master"
                                    inline
                                >
                                <v-radio
                                    label="SI"
                                    value="1"
                                ></v-radio>
                                <v-radio
                                    label="NO"
                                    value="2"
                                ></v-radio>
                            </v-radio-group>
                        </v-col> 
                    </v-row> 
                </v-col>
            </v-row>
            <v-row>
                <v-col :key="2" cols="12" md="2"></v-col>
                <v-col :key="2" cols="12" md="8">
                    <v-row class="mb-5">
                        <v-col cols="12" md="8"></v-col>
                        <v-col cols="12" md="4">
                            <v-btn  block color="success" type="submit">
                            <v-icon
                                left
                                dark
                                icon="mdi-content-save"
                            >
                            </v-icon>
                            Guardar
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-col>
                <v-col :key="2" cols="12" md="2"></v-col>
            </v-row>

        </v-form>
    </v-card-text>
</template>

<script>

import useAppConfig from '@core/@app-config/useAppConfig';
import { minNumber, required, requiredObject } from '@core/utils/validation.js';
import { ref } from 'vue';
//import * as moment from 'moment'

export default {
    props: {
        entityData: {
            type: Object,
            required: true,
        },
        pidm : {
            type: String,
            required: true
        }
    },
  setup() {    
    let { overlay } = useAppConfig()
    //const $swal = inject('$swal')
    let termscode = ref([])
    let programs = ref([])
    let pmethods = ref([])
    let formas_pago = ref([])
    //let entityData = ref({})
    let tipos_est = ref([{id: 1, descr: 'Nuevo'}, {id: 2, descr:'Readmitido'},  {id: 3, descr:'Transferido'}])
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
            requiredObject},
        //entityData,
        termscode,
        programs,
        formas_pago,
        tipos_est,
        pmethods,
        overlay
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
                  window.scrollTo({ top: 0, behavior: 'smooth' });
                  this.overlay = false
                  
                  this.loadAlert(response.data.mensaje, 'success', 'Éxito')
                
              }).catch(err =>{
                  

              });
              /*.catch(error => {     
                    this.overlay = false
                    this.$emit('load-alert', error.response.data.message)
            }) */      
        } else {
          this.validate()
          this.loadAlert('Tiene campos incompletos');
          let elementsInErrors = document.getElementsByClassName('error--text');
            if (elementsInErrors && elementsInErrors.length > 0) {
              elementsInErrors[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
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
            }).then((result) => {
              if (result.isConfirmed) {
                //document.querySelectorAll("#btnRegresar").forEach(el=>el.click())
                //document.querySelectorAll("#btnConsultar").forEach(el=>el.click())
                
              }
            })
    },
    formatDate(date) {
        if (date !== null) {
          return this.$moment(date).format('MM-DD-YYYY');
        } 

        return '-';
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
    }
  }
}
</script>