<template> 
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
        text="Ver foto psicólogo"
      >
        <template #activator="{ props }">
          <VAvatar
            size="28"
            color="primary"
            v-bind="props"
          >
            <VIcon
              size="20"  
              icon="mdi-camera"
              @click="verFoto(item)"
            />
          </VAvatar>
        </template>
      </VTooltip> 
      <VTooltip
        v-if="item.value.desc_situacion === 'PROGRAMADA'"
        location="top"
        text="Cancelar cita"
      >
        <template #activator="{ props }">
          <VAvatar
            size="28"
            color="error"
            v-bind="props"
          >
            <VIcon
              size="20"  
              icon="mdi-cancel"
              @click="deleteItem(item)"
            />
          </VAvatar>
        </template>
      </VTooltip>  
    </template> 
    
    <template #[`item.desc_situacion`]="{item}">
      <VChip
        small
        :color="enabledColor(item.value.desc_situacion)"
        :class="`${enabledColor(item.value.desc_situacion)}--text`"
        class="v-chip-light-bg"
      >
        {{ item.value.desc_situacion }}
      </VChip>
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

    const enabledColor = value => {
      switch (value) {
      case 'INASISTENCIA':
        return 'error'
      case 'PROGRAMADA':
        return 'warning'
      case 'REALIZADA':
        return 'success'
      default:
        return 'secondary'
      }
    }

    let page = ref(props.page)
    let itemsPerPage = ref(props.itemsPage)

    return {
      page,
      itemsPerPage,
      overlay,
      validators: { required, requiredObject },
      entityData,
      enabledColor,
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
    deleteItem(item){ 
      this.$emit('cancelar-cita', item)
    },

    verFoto(item){ 
      this.$emit('ver-foto', item)
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
