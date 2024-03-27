<template>
  <v-card-text class="mt-5">
        <v-form ref="form"
          v-model="valid"
          @submit="onSubmit" 
          @submit.prevent="preSubmit">
          <v-row>
            <v-col
              cols="12"
              md="7"
            >
              <v-text-field
                label="CODIGO DE VARIABLE"
                v-model="entityData.name"
                variant="outlined"
                density="compact"
                hide-details="auto"
                :rules="[validators.required]"
              ></v-text-field>
            </v-col>
            <v-col
              cols="12"
              md="7"
            >
              <v-text-field
                label="DESCRIPCIÓN"
                v-model="entityData.descripcion"
                variant="outlined"
                density="compact"
                hide-details="auto"
                :rules="[validators.required]"
              ></v-text-field>
            </v-col>
            <v-col
              cols="12"
              md="7"
            >
              <v-text-field
                label="VALOR"
                v-model="entityData.defaultvalue"
                variant="outlined"
                density="compact"
                hide-details="auto"
                :rules="[validators.required]"
              ></v-text-field>
            </v-col> 
            
            <v-col
              cols="12"
              md="7"
            > 
            </v-col>
            <v-col
              offset-md="4"
              cols="12"
              md="3"
            >
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
        </v-form>
  </v-card-text>
</template>

<script>
import useAppConfig from '@core/@app-config/useAppConfig'
import { getFieldDb, isEmpty } from '@core/utils/index'
import { emailValidator, required, requiredObject } from '@core/utils/validation.js'

export default {
  props: {
    entityData: {
      type: Object,
      required: true,
    }, 
  },
  setup() {
    const valid = ref(false)
    const form = ref(null)
    const validate = () => {
      form.value.validate()
    }

    var { overlay } = useAppConfig()

    const enabled = {
      2: 'Inactivo',
      1: 'Activo',
    }

    return {
      valid,
      form,
      validate,
      validators: { required, requiredObject, emailValidator },
      getFieldDb,
      isEmpty,
      overlay,
      enabled
    }
  },
  mounted(){
    console.log(this.entityData)
    if(!this.isEmpty(this.entityData.id)) {
      this.validate()
    }
  },
  methods: {
    preSubmit(){
      this.validate()
    },
    onSubmit(){
      if (!this.valid) {
          return
        }

        if(this.isEmpty(this.entityData.id)) {
          this.overlay = true
          this.$http.post('/maintenance/variables', this.entityData)
            .then(response => {
                this.entityData.id = response.data.id
                this.entityData.role_name = response.data.role_name
                this.entityData.name = response.data.name
                this.$emit('create', this.entityData)
                this.$emit('load-alert', 'Variable registrada correctamente', 'success', 'Éxito')
            })
            .catch(error => {     
                  this.overlay = false
                  this.$emit('load-alert', error.response.data.message)
            })
        } else {
           this.overlay = true
           this.$http.put('/maintenance/variables/'+this.entityData.id, this.entityData) 
            .then(response => {
                this.entityData.role_name = response.data.role_name
                this.$emit('on-backward')
                this.overlay = false 
                this.$emit('load-alert', 'Variable registrada correctamente', 'success', 'Éxito')
            })
            .catch(error => {     
                  this.overlay = false
                  this.$emit('load-alert', error.response.data.message)
            }) 
        }
    },
  }
}
</script>
