<template>
  <VForm
    ref="form"
    v-model="valid"
    @submit.prevent="validate"
    @submit="onSubmit" 
  >
    <VDialog
      v-model="dialog"
      persistent
      width="700"
    >
      <VCard>
        <VCardTitle class="font-weight-bold text-center text-primary">
          FICHA DE CONFIDENCIALIDAD
        </VCardTitle>

        <VCardText slot="resultado">
          <VRow justify="justify">
            <VCol
              cols="12"
              md="12"
            > 
              <span>

                La atención psicológica es de carácter confidencial entre el estudiante y el psicólogo.

                <br><br>Cabe resaltar que toda la información que se recolecte en este cuestionario será manejada por el departamento de psicología con el fin de ponernos en contacto con usted respecto a la programación de su atención, lo cual permitirá la comunicación del área de psicóloga con el estudiante con el fin de seguimiento y programación; la mejora de los procesos dentro del área e investigación del área, la cual se maneja de manera general y no especifica.

                <br><br>Sobre los servicios psicológicos brindados a los estudiantes y las características de la población.<br>

                <br>La información tratada será reservada y solo podrá ser revelada a terceros en alguno de los siguientes casos:
              </span>
            </VCol> 
          </VRow> 
          <VRow>
            <VCol
              cols="12"
              md="12"
            > 
              <span>
                <label class="font-weight-bold">1.</label>	Cuando el estudiante dé su consentimiento para hacerlo.<br>
                <label class="font-weight-bold">2.</label>	En caso de que su vida y terceros este en riesgo.<br>
                <label class="font-weight-bold">3.</label>	Por mandato judicial. <br>
                <label class="font-weight-bold">4.</label>	En caso de que alguna área requiere algún reporte y/o informe, esta será de carácter general resguardando su privacidad y siempre informando de dicho acto.<br>
              </span>
            </VCol>  
          </VRow> 
          <VRow>
            <VCol
              cols="12"
              md="12"
            > 
              <span>
                Doy conformidad de lo expuesto previamente sobre la información que se recolectará en la asesoría psicológica (de asistir a la cita):<br>
              </span>
            </VCol>  
          </VRow> 
        </VCardText>
        <VDivider />
        <slot /> <!-- Updated to use <slot> without attributes -->
        <VDivider /> 
        <VSpacer />
        <VCardText>
          <VRow justify="center">
            <VCol
              cols="12"
              md="6"
            >
              <VBtn
                v-if="showConfirm"
                block
                color="success"
                type="submit"
                @click="emitOk"
              >
                <VIcon left>
                  mdi-check
                </VIcon>
                SI CONFIRMO
              </VBtn>
            </VCol>
            <VCol
              cols="12"
              md="6"
            >
              <VBtn
                block
                color="secondary"
                outlined
                @click="emitCancel"
              >
                <VIcon left>
                  mdi-close
                </VIcon>
                CERRAR
              </VBtn>
            </VCol>
          </VRow>
        </VCardText>


        <VSpacer /> 
      </VCard>
    </VDialog>
  </VForm>
</template>

<script>
const form = ref(null)
const showConfirmButton= ref(true)
let validate = () => {
  form.value.validate()
}
   
export default {
  name: "UCToolbar",
  props: {
    modelValue: {
      type: Boolean,
      default: false,
    }, 
    showConfirm: {
      type: Boolean,
      default: true,
    },
  },
  setup(props, { emit }) {
    const dialog = ref(props.modelValue)

    // Watch for changes from the parent and update the local dialog state
    watch(() => props.modelValue, newValue => {
      dialog.value = newValue
    })

    // Emit update event to sync the state with the parent
    watch(dialog, newValue => {
      emit('update:modelValue', newValue)
    })

    function emitOk() {
      emit('ok')
    }

    function emitCancel() {
      emit('cancel')
    }

    return { 
      dialog,
      emitOk,
      emitCancel,
      showConfirmButton,
    }
  },
}
</script>
