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
    <template #[`item.options`]="{ item }">
      <VTooltip 
        location="top"
        text="Ver ficha"
      >
        <template #activator="{ props }">
          <VAvatar
            size="28"
            color="primary"
            v-bind="props"
          >
            <VIcon
              size="20"  
              icon="mdi-eye"
              @click="verFicha(item)"
            />
          </VAvatar>
        </template>
      </VTooltip>  
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
    verFicha(item){ 
      this.$emit('ver-ficha', item)
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
