<template>
  <VToolbar
    flat
    style="background: rgb(var(--v-theme-on-white));"
  >
    <VBtn
      v-if="showForm"
      variant="tonal"
      :color="showForm ? 'secondary' : 'primary'"
      class="mb-2 mr-2"
      :loading="loading"
      @click="clickShowForm"
    > 
      <VIcon
        left
        :icon="showForm ? 'mdi-arrow-left' : 'mdi-plus'"
      />
      {{ showForm ? 'Regresar' : 'Agregar' }}
    </VBtn>
    <VBtn
      v-if="!showForm"
      color="secondary"
      class="mb-2"
      variant="outlined"
      :loading="loading"
      @click="clickRefresh"
    >
      <VIcon
        left
        icon="mdi-reload"
      />
      Actualizar
    </VBtn>
    <VDivider />
  </VToolbar>
</template>

<script>
export default {
  name: "UCToolbar",
  props: {
    showForm: {
      type: Boolean,
      default: false,
    },
    loading: {
      type: Boolean,
      default: false,
    },
  },
  methods: {
    clickShowForm() {
      this.$emit('on-create')
    },
    clickRefresh() {
      this.$emit('on-read')
    },
  },
}
</script>
