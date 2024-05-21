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
      width="600"
    >
      <VCard>
        <VCardTitle class="font-weight-bold text-center text-error">
          Confirmar la cancelación de cita:
        </VCardTitle>
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
                block
                color="info"
                type="submit"
                @click="emitOk"
              >
                <VIcon left>
                  mdi-content-save
                </VIcon>
                Cancelar Cita
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
    }
  },
}
</script>
