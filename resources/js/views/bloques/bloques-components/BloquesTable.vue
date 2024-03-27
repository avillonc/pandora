<template>
  <VCardText>
    <VRow>
      <VCol
        cols="12"
        md="6"
      />
      <VSpacer />
    </VRow>
  </VCardText>
  <VDataTableServer
    class="m-0 p-0 elevation-1"
    :headers="headers"
    :items="items"
    :loading="isLoading"
    :items-per-page="itemsPerPage"
    density="compact"
    no-data-text="No hay datos para mostrar"
    loading-text="Cargando..."
    :page="page"
    :items-length="itemTotal"
    @update:itemsPerPage="changeItemPerPage"
    @update:page="changePage"
  >
    <template #[`item.HORARIO`]="{item}">
      <slot name="nombres">
        <strong>{{ item.value.HORARIO }}</strong>
      </slot>
    </template>

    <template #[`item.TITULO`]="{item}">
      <slot name="nombres">
        <span class="font-weight-bold">{{ item.value.TITULO }}</span>
      </slot>
    </template>
    
    <template #[`item.LUN`]="{item}">
      <slot name="nombres">
        <span class="text-error font-weight-medium">{{ item.value.LUN }}</span>
      </slot>
    </template>

    <template #[`item.MAR`]="{item}">
      <slot name="nombres">
        <span class="font-weight-medium">{{ item.value.MAR }}</span>
      </slot>
    </template>

    <template #[`item.MIE`]="{item}">
      <slot name="nombres">
        <span class="text-error font-weight-medium">{{ item.value.MAR }}</span>
      </slot>
    </template>

    <template #[`item.JUE`]="{item}">
      <slot name="nombres">
        <span class="text-secondary font-weight-medium">{{ item.value.JUE }}</span>
      </slot>
    </template>

    <template #[`item.VIE`]="{item}">
      <slot name="nombres">
        <span class="text-error font-weight-medium">{{ item.value.VIE }}</span>
      </slot>
    </template>

    <template #[`item.SAB`]="{item}">
      <slot name="nombres">
        <span class="font-weight-medium">{{ item.value.SAB }}</span>
      </slot>
    </template>

    <template #bottom />
    <template #loading>
      <div class="text-center py-4">
        <p>Obteniendo Data ...</p>
      </div>
    </template>
  </VDataTableServer>
</template>

<script>
import { ref } from 'vue'

//import UCDialogQuestion from '@/components/UCDialogQuestion.vue'
import useAppConfig from '@core/@app-config/useAppConfig'
import { required, requiredObject } from '@core/utils/validation.js'

export default {
  components: {
    // UCDialogQuestion
  },
  props: {
    items: {
      type: Array,
      default: [],
    },
    isLoading: {
      type: Boolean,
      default: false,
    },
    headers: {
      type: Array,
      required: true,
    },
    sortBy: {
      type: String,
      default: "id",
    },
    showSelect: {
      type: Boolean,
      default: false,
    },
    nameAction: {
      type: String,
      default: 'Guardar',
    },
    itemKey: {
      type: String,
      default: 'id',
    },
    search: {
      type: String,
      default: '',
    },
    itemTotal: {
      type: Number,
      default: null,
    },
    itemsPage: {
      type: Number,
      default: 25,
    },
    page: {
      type: Number,
      default: 1,
    },
  },
  setup(props) {
    var { overlay } = useAppConfig()

    const entityData = ref({})


    let page = ref(props.page)
    let itemsPerPage = ref(props.itemsPage)

    return {
      page,
      itemsPerPage,
      overlay,
      validators: { required, requiredObject },
      entityData,
    }
  },
  methods: {
    loadAlert(text, type="error", title="Advertencia"){
      this.$swal.fire({
        title: title,
        text: text,
        icon: type,
        confirmButtonText: 'OK',
      })
    },
    formatDate(created_at) {
      return this.$moment(created_at).format('MM-DD-YYYY')
    },
    formatDateTime(fecha) {
      if(fecha==null) return ''
      
      return this.$moment(fecha).format('MM-DD-YYYY HH:mm')
    },
    changePage(value){
      this.entityData = {}
      this.$emit('change-page', value)
    },
    changeItemPerPage(item){
      this.entityData = {}
      this.$emit('item-per-page', item)
    },
 
    closeDialog(){
      this.isDialogOpen = false
      this.entityData = {}
      this.resetValidation()
    },

  },
}
</script>

<style>
.row-pointer:hover {
  cursor: pointer;
}

.v-data-table__tbody tr:nth-of-type(odd) {
  background-color: rgba(0, 0, 0, 5%) !important;
}
</style>
