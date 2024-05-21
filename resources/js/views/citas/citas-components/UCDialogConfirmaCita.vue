<template>
  <VDialog
    v-model="dialog"
    persistent
    width="600"
  >
    <VCard>
      <VCardTitle class="font-weight-bold text-center">
        Confirmar reserva de cita:
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
              @click="emitOk"
            >
              <VIcon left>
                mdi-content-save
              </VIcon>
              Reservar Cita
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
                mdi-cancel
              </VIcon>
              CANCELAR
            </VBtn>
          </VCol>
        </VRow>
      </VCardText>


      <VSpacer /> 
    </VCard>
  </VDialog>
</template>

<script>
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
