
<template>
  <div>
    <VCardText class="my-0">
      <VRow>
        <VCol
          cols="12"
          md="6"
        >
          <span>Total de Registros: {{ totales }}</span>
        </VCol>
        <VSpacer />
        <VCol
          cols="12"
          md="3"
        />
      </VRow>
    </VCardText>
    <VDataTable
      v-model:page="page"
      :headers="headers"
      :items="items"
      :loading="isLoading"
      :items-per-page="itemsPerPage"
      :search="search"
      no-data-text="No hay datos para mostrar"
      loading-text="Cargando..." 
      hide-default-footer
      :show-select="showSelect"
      :item-key="itemKey"
      :items-length="totales" 
    />
  </div>
</template>

<script>  
import useAppConfig from '@core/@app-config/useAppConfig'


export default {
  components: { 
  },
  props: {
    items: {
      type: Array,
      default: [],
    },
    isloading: {
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
    itemKey: {
      type: String,
      default: 'id',
    },
    search: {
      type: String,
      default: '',
    },
    totales: {
      type: Number,
      default: null,
    },
    itemspage: {
      type: Number,
      default: 25,
    },
  },
  setup(props) {
    

    var { overlay } = useAppConfig()

    const valid = ref(false)
    const form = ref(null)

    const validate = () => {
      form.value.validate()
    }

    const resetValidation = ()=> {
      form.value.resetValidation()
    }

    const pageCount = computed(() => {
      return Math.ceil(totales.value / itemporpag.value)
    })

    const entityData = ref({})
    let page = ref(props.page)
    let itemsperpage = ref(props.itemspage)
    
    return {
      page,
      itemsperpage,  
      overlay, 
      valid,
      form,
      validate,
      resetValidation,
      isDialogOpen: false, 
    }
  }, 
  methods: { 
    changepage(value){ 
      this.entityData = {}
      this.$emit('change-page', value)
    },
    changeItemPerPage(item){
      this.entityData = {}
      this.$emit('item-per-page', item)
    },
   
  },
}
</script>
