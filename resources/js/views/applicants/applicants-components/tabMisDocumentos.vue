<template>
    <v-card-text class="mt-3">
        <v-form ref="form"
        v-model="valid"
        @submit="onSubmit" 
        @submit.prevent="validate">
            <!-- PROGRAMAS DE BACHILLER-->
            <v-row v-if="entityData.program_type==1">
                <v-col
                    :key="2"
                    cols="12"
                    md="2"
                >
                </v-col>
                <v-col
                    :key="2"
                    cols="12"
                    md="8"
                >
                    <v-row class="pb-0">
                        <v-col cols="12" md="8" class="pb-0">
                            <h4 class="mb-2">Documentación para programas de Bachelor: </h4>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12" md="6" >
                            <v-file-input
                            label="Documento de identidad vigente (con fotografía)"
                            prepend-inner-icon="mdi-paperclip"
                            :prepend-icon="null"
                            density="compact"
                            show-size
                            accept="image/*, application/msword, application/pdf, application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                            :rules="[validators.fileValidator]"
                            @change="selectFile1"
                            ></v-file-input>
                        </v-col>
                        <v-col cols="12" md="6" >
                            <v-file-input
                            label="Diploma oficial de escuela secundaria o GED"
                            prepend-inner-icon="mdi-paperclip"
                            :prepend-icon="null"
                            density="compact"
                            show-size
                            v-model="entityData.doc_ofi_ged"
                            :rules="[validators.fileValidator]"
                            accept="image/*, application/msword, application/pdf, application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                            @change="selectFile2"
                            ></v-file-input>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12" md="6" >
                            <v-file-input
                            label="Pre-certificado oficial de notas de escuela secundaria"
                            prepend-inner-icon="mdi-paperclip"
                            :prepend-icon="null"
                            density="compact"
                            show-size
                            v-model="entityData.doc_precerti_notas_secund"
                            :rules="[validators.fileValidator]"
                            accept="image/*, application/msword, application/pdf, application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                            @change="selectFile3"
                            ></v-file-input>
                        </v-col>
                        <v-col cols="12" md="6" >
                            <v-file-input
                            label="Carrera técnica (asociado)"
                            prepend-inner-icon="mdi-paperclip"
                            :prepend-icon="null"
                            density="compact"
                            show-size
                            :rules="[validators.fileValidator]"
                            accept="image/*, application/msword, application/pdf, application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                            v-model="entityData.doc_ct"
                            @change="selectFile4"
                            ></v-file-input>
                        </v-col>
                    </v-row>
                    
                    <v-row>
                        <v-col cols="12" md="6" >
                            <v-file-input
                            label="Pre-certificado oficial de notas de carrera técnica"
                            prepend-inner-icon="mdi-paperclip"
                            :prepend-icon="null"
                            density="compact"
                            show-size
                            :rules="[validators.fileValidator]"
                            accept="image/*, application/msword, application/pdf, application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                            v-model="entityData.doc_preceti_notas_ct"
                            @change="selectFile5"
                            ></v-file-input>
                        </v-col>
                    </v-row>
                    <v-row class="mb-5">
                        <v-col cols="12" md="4"></v-col>
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
                        <v-col cols="12" md="4">
                            <v-btn block color="primary" type="submit" disabled>
                            <v-icon
                                left
                                dark
                                icon="mdi-content-send"                                
                            >
                            </v-icon>
                            Enviar Información
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>

            <!-- PROGRAMAS DE MASTER-->
            <v-row v-if="entityData.program_type==2">
                <v-col
                    :key="2"
                    cols="12"
                    md="2"
                >
                </v-col>
                <v-col
                    :key="2"
                    cols="12"
                    md="8"
                >
                    <v-row class="pb-0">
                        <v-col cols="12" md="8" class="pb-0">
                            <h4 class="mb-2">Documentación para programas de Master: </h4>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12" md="6" >
                            <v-file-input
                            label="Documento de identidad vigente (con fotografía)"
                            prepend-inner-icon="mdi-paperclip"
                            :prepend-icon="null"
                            density="compact"
                            show-size
                            :rules="[validators.fileValidator]"
                            accept="image/*, application/msword, application/pdf, application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                            v-model="entityData.doc_preceti_notas_ct2"
                            @change="selectFile6"
                            ></v-file-input>
                        </v-col>
                        <v-col cols="12" md="6" >
                            <v-file-input
                            label="Título de bachillerato"
                            prepend-inner-icon="mdi-paperclip"
                            :prepend-icon="null"
                            density="compact"
                            show-size
                            :rules="[validators.fileValidator]"
                            accept="image/*, application/msword, application/pdf, application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                            v-model="entityData.doc_tit_bachi"
                            @change="selectFile7"
                            ></v-file-input>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12" md="6" >
                            <v-file-input
                            label="Pre-certificado oficial de notas del programa de Bachillerato"
                            prepend-inner-icon="mdi-paperclip"
                            :prepend-icon="null"
                            density="compact"
                            show-size
                            :rules="[validators.fileValidator]"
                            accept="image/*, application/msword, application/pdf, application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                            v-model="entityData.doc_precerti_notas_bachi"
                            @change="selectFile8"
                            ></v-file-input>
                        </v-col>
                        <v-col cols="12" md="6" >
                            <v-file-input
                            label="Carta de recomendación firmada 1"
                            prepend-inner-icon="mdi-paperclip"
                            :prepend-icon="null"
                            density="compact"
                            show-size
                            :rules="[validators.fileValidator]"
                            accept="image/*, application/msword, application/pdf, application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                            v-model="entityData.doc_carta_recom_1"
                            @change="selectFile9"
                            ></v-file-input>
                        </v-col>
                    </v-row>
                    
                    <v-row>
                        <v-col cols="12" md="6" >
                            <v-file-input
                            label="Carta de recomendación firmada 2"
                            prepend-inner-icon="mdi-paperclip"
                            :prepend-icon="null"
                            density="compact"
                            show-size
                            :rules="[validators.fileValidator]"
                            accept="image/*, application/msword, application/pdf, application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                            v-model="entityData.doc_carta_recom_2"
                            @change="selectFile10"
                            ></v-file-input>
                        </v-col>
                        <v-col cols="12" md="6" >
                            <v-file-input
                            label="Currículo Vitae (resume) actualizado"
                            prepend-inner-icon="mdi-paperclip"
                            :prepend-icon="null"
                            density="compact"
                            show-size
                            :rules="[validators.fileValidator]"
                            accept="image/*, application/msword, application/pdf, application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                            v-model="entityData.doc_cv"
                            @change="selectFile11"
                            ></v-file-input>
                        </v-col>
                    </v-row>
                    <v-row class="mb-5">
                        <v-col cols="12" md="4"></v-col>
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
                        <v-col cols="12" md="4">
                            <v-btn  block color="primary" type="submit">
                            <v-icon
                                left
                                dark
                                icon="mdi-content-send"
                            >
                            </v-icon>
                            Enviar Información
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>

            
        </v-form>
    </v-card-text>
</template>

<script>

import useAppConfig from '@core/@app-config/useAppConfig';
import { fileValidator, required } from '@core/utils/validation.js';
import { ref } from 'vue';
//import * as moment from 'moment'

export default {
    props: {
        entityData: {
            type: Object,
            required: true,
        },
    },
  setup() {
    
    let { overlay } = useAppConfig()
    //const $swal = inject('$swal')
    //let entityData = ref({})
    const valid = ref(false)
    const form = ref(null)
    const file1 = ref(null)
    const file2 = ref(null)
    const file3 = ref(null)
    const file4 = ref(null)
    const file5 = ref(null)
    const file6 = ref(null)
    const file7 = ref(null)
    const file8 = ref(null)
    const file9 = ref(null)
    const file10 = ref(null)
    const file11 = ref(null)
    const $http = inject('http')

    const validate = () => {
      form.value.validate()
    }
    return {
        valid,
        form,
        validate,
        file1,
        file2,
        file3,
        file4,
        file5,
        file6,
        file7,
        file8,
        file9,
        file10,
        file11,
        validators: { required, fileValidator},
        overlay
    }
  },
  mounted(){
    console.log(this.entityData.program_type)
    //console.log(this.entityData.majr_code)
    //console.log(this.entityData.term_code)
  },
  methods: {
    onSubmit(){
        
        //console.log(this.valid); return;
        if (this.valid && this.valid !== false) {

            
            var formData = new FormData()
            formData.append("majr_code", this.entityData.pidm);
            formData.append("pidm", this.entityData.majr_code);
            formData.append("term_code", this.entityData.term_code); 
            formData.append("program_type", this.entityData.program_type);             
            formData.append("file1", this.file1 );
            formData.append("file2", this.file2);
            formData.append("file3", this.file3);
            formData.append("file4", this.file4);
            formData.append("file5", this.file5);

            this.$http.post('mis-datos/save-documents', formData, {
                headers: {
                'Content-Type': 'multipart/form-data'
                }
            })
            .then(response => {
                this.$emit('load-alert', 'Acuerdo Adjuntado Correctamente', 'success', 'Éxito')

                //this.entityData.file = response.data
                //this.entityData.url_file = "/uploads_agreement/"+response.data
                //this.$forceUpdate();
                //this.overlay = false
            })
            .catch(error => {     
                this.overlay = false 
                this.$emit('load-alert', error.response.data.message)
            })



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
    selectFile1(event) {
        this.file1 = event.target.files[0]
        //console.log(this.file1);
    },
    selectFile2(event) {
        this.file2 = event.target.files[0]
        console.log(this.file2);
    },
    selectFile3(event) {
        this.file3 = event.target.files[0]
        console.log(this.file3);
    },
    selectFile4(event) {
        this.file4 = event.target.files[0]
        console.log(this.file4);
    },
    selectFile5(event) {
        this.file5 = event.target.files[0]
        console.log(this.file5);
    },
    selectFile6(event) {
        this.file6 = event.target.files[0]
        console.log(this.file6);
    },
    selectFile7(event) {
        this.file7 = event.target.files[0];
        console.log(this.file7);
    },
    selectFile8(event) {
        this.file8 = event.target.files[0];
        console.log(this.file8);
    },
    selectFile9(event) {
        this.file9 = event.target.files[0];
        console.log(this.file9);
    },
    selectFile10(event) {
        this.file10 = event.target.files[0];
        console.log(this.file10);
    },
    selectFile11(event) {
        this.file11 = event.target.files[0];
        console.log(this.file11);
    }

  }
}
</script>