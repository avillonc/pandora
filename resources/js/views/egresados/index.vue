<template> 
  <VCard class="mx-auto mb-4">  
    <VRow justify="center">
      <VCol
        cols="12"
        md="12"
        order="1"
        order-md="2"
        class="align-self-end mb-2 mt-md-0"
      >
        <VCard
          class="ps-3 home"
          color="on-primary"
        >
          <VRow class="mt-1 pt-1">
            <VCol
              cols="12"
              md="12"
            >
              <span class="white--text text-left mb-0 pt-0 text-primary"><h3> Egresados</h3></span>
            </VCol>
          </VRow> 
          <VRow>
            <VDivider />
          </VRow>
          <VCardText class="my-4">
            <VForm
              ref="form"
              v-model="valid" 
              @submit="onSubmitForm"
              @submit.prevent="validate"
            >
              <VRow>
                <VCol
                  cols="12"
                  md="3"
                >
                  <VAutocomplete
                    v-model="entityData.nivel_code"
                    label="Nivel"
                    outlined
                    density="compact"
                    :items="niveles"
                    item-title="name"
                    item-value="id"
                    :menu-props="{ offsetY: true }"
                    hide-details="auto"
                  />
                </VCol>
                <VCol
                  cols="12"
                  md="3"
                >
                  <VAutocomplete
                    v-model="entityData.ccarr"
                    label="Carrera Egreso"
                    outlined
                    density="compact"
                    :items="carreras"
                    item-title="name"
                    item-value="id"
                    :menu-props="{ offsetY: true }"
                    hide-details="auto"
                    clearable
                  />
                </VCol>
                <VCol
                  cols="12"
                  md="3"
                >
                  <VAutocomplete
                    v-model="entityData.cod_term"
                    label="Periodo"
                    outlined
                    density="compact"
                    :items="periodos"
                    item-title="name"
                    item-value="id"
                    :menu-props="{ offsetY: true }"
                    hide-details="auto"
                    clearable
                  />
                </VCol>

                <VCol
                  cols="12"
                  md="3"
                >
                  <VTextField
                    v-model="entityData.anio_egreso"
                    label="Año Egreso"
                    outlined
                    dense
                    hide-details="auto"
                  />
                </VCol>
                <VCol
                  cols="12"
                  md="3"
                >
                  <VTextField
                    v-model="entityData.doc_identidad"
                    label="Doc. Identidad"
                    outlined
                    dense
                    hide-details="auto"
                  />
                </VCol>
                <VCol
                  cols="12"
                  md="3"
                >
                  <VTextField
                    v-model="entityData.last_name"
                    label="Apellidos"
                    outlined
                    dense
                    hide-details="auto"
                  />
                </VCol>
                <VCol
                  cols="12"
                  md="3"
                >
                  <VAutocomplete
                    v-model="entityData.id_situ"
                    label="Situación Laboral"
                    outlined
                    density="compact"
                    :items="situacionLab"
                    item-title="name"
                    item-value="id"
                    :menu-props="{ offsetY: true }"
                    hide-details="auto"
                  /> 
                </VCol>
                <VCol
                  cols="12"
                  md="3"
                >
                  <VTextField
                    v-model="entityData.anio_actualiza"
                    label="Año actualiza"
                    outlined
                    dense
                    hide-details="auto"
                  />
                </VCol>
              </VRow>
              <VRow>
                <VCol
                  cols="12"
                  md="3"
                >
                  <VAutocomplete
                    v-model="entityData.id_origen"
                    label="Origen Datos"
                    outlined
                    density="compact"
                    :items="origenes"
                    item-title="name"
                    item-value="id"
                    :menu-props="{ offsetY: true }"
                    hide-details="auto"
                  />
                </VCol> 
              </VRow>
              <VRow> 
                <VCol
                  cols="12"
                  md="6"
                />
                <VCol
                  cols="12"
                  md="3"
                > 
                  <VBtn
                    block
                    color="info"
                    @click="limpiar"
                  > 
                    Limpiar filtros
                  </VBtn>
                </VCol>  
                <VCol
                  cols="12"
                  md="3"
                >
                  <VBtn
                    block
                    color="success"
                    type="submit"
                    :loading="isLoading"
                  >
                    <VIcon
                      id="btnConsultar"
                      left
                      dark
                    />
                    Consultar
                  </VBtn>
                </VCol>
              </VRow>
              <VRow>
                <VCol
                  cols="12"
                  md="12"
                >
                  <UCDatatable 
                    :key="tableKey"
                    :items="items" 
                    :isloading="isLoading"
                    :headers="headers"
                    :totales="totales"
                    :itemspage="itemsPerPage"
                    :page="page"
                    @on-submit="onSubmit"
                    @show-ea-form="showEaForm"
                    @change-page="changePage"
                    @item-per-page="changeItemPerPage"
                  />
                </VCol>
              </VRow>
            </VForm>
          </VCardText>
        </VCard>
      </VCol>
    </VRow>
  </VCard>
</template>

<script setup> 
import useAppConfig from '@core/@app-config/useAppConfig'
import UCDatatable from './egresados-components/EgresadosTable.vue'

let entityData = ref({ nivel_code: '', anio_actualiza: '', id_situ: '', last_name: '', 
  doc_identidad: '', anio_egreso: '', cod_term: '', ccarr: '', id_origen: '' }) 

let niveles = ref([{ id: '', name: 'TODOS' }, 
  { id: 'C', name: 'CARRERA TECNICA' }, 
  { id: 'B', name: 'ESCUELA' }])
 
let situacionLab= ref([{ id: '', name: 'TODOS' }, { id: '1', name: 'TRABAJA' }, { id: '2', name: 'NO TRABAJA' }])
     
let periodos = ref([])
let carreras = ref([])
let origenes = ref([]) 
const totales = ref(0)
let items = ref([])
let tableKey = 0
let page = ref(1)
let itemsPerPage = ref(25)
let itemTotal = ref(0)
let isLoading = ref(false)
let isShowEntityActive = ref(false)
let form = ref(null) 
let valid = ref(false) 
let { overlay } = useAppConfig() 
let entityAlumno= ref({}) 
const $http = inject('http')

const setOverlay = value => {
  overlay.value = value
}


const headers = [
  { title: 'N° DOC', key: 'dni', filterable: true, width: '100' },
  { title: 'NOMBRE EGRESADO', key: 'fullname', filterable: true, width: '300' },
  { title: 'TELEFONO', key: 'celular', sortable: false },
  { title: 'CORREO', key: 'correo', sortable: false },
  { title: 'DIRECCION', key: 'direccion', sortable: false, width: '300' },
  { title: 'ORIGEN ACT.', key: 'nombre_origen', filterable: true },
  { title: 'AÑO EGRESO', key: 'anio_egr', filterable: true },
  { title: 'PERIODO INGRESO', key: 'periodo_ing', filterable: true },
  { title: 'PERIODO EGRESO', key: 'periodo_egr', filterable: true },
  { title: 'NIVEL', key: 'nivel', filterable: true },
  { title: 'CARRERA EGRESO', key: 'carrera', filterable: true, width: '300'  },
  { title: 'FECHA ACTUALIZA', key: 'fecha_actualiza', filterable: true, align: 'center' },
  { title: 'AÑO ACTUALIZA', key: 'anio_actualiza', filterable: true, align: 'center' },
  { title: 'SITUACION LABORAL', key: 'descripcion_situ', filterable: true, align: 'center' },
  { title: 'EMPRESA', key: 'razon_social', filterable: true, align: 'center', width: '300'  },
  { title: 'RUC', key: 'ruc', filterable: true, align: 'center' },
  { title: 'CARGO', key: 'cargo', filterable: true, align: 'center' },
  { title: 'TIEMPO DE TRABAJO', key: 'tiempo', filterable: true, align: 'center' },
  { title: 'MODALIDAD TRABAJO', key: 'modalidad', filterable: true, align: 'center' },
  { title: 'VINCULACION', key: 'tipo_vinculacion', filterable: true, align: 'center' },
]

const validate = () => {
  form.value.validate()
}

function onSubmit() { 
  
  setOverlay(true)
  isLoading.value = true
  entityData.value.itemsPerPage = itemsPerPage.value
  entityData.value.page = page.value   
  $http.post('minedu/getegresados', entityData.value)
    .then(response => { 
      items.value = response.data.data
      totales.value =  Number(response.data.rows) 
      tableKey++ 
      setOverlay(false) 
      isLoading.value = false       
    }).catch(error => {
      setOverlay(false)
      isLoading.value = false
    })
}
function getTermCode() { 
  setOverlay(true)
  $http.post('minedu/termcode', { nivel_code: 'CT' })
    .then(response => {
      periodos.value = response.data
      setOverlay(false)
    }).catch(error => {
      setOverlay(false)
    })
}
function getCarrera() {
  setOverlay(true)
  $http.post('minedu/carrerasbynivel', { nivel_code: 'C' })
    .then(response => {
      carreras.value = response.data
      setOverlay(false)
    }).catch(error => {
      setOverlay(false)
    })
}
function limpiar()
{
  setOverlay(true) 
  entityData.value = {}
  setOverlay(false)
}
function getOrigenes(){
  setOverlay(true)
  $http.post('minedu/get-maestras', { idTabla: '9' })
    .then(response => {
      const todosItem = { id: '', name: 'TODOS' }

      origenes.value = [todosItem, ...response.data.data]
      setOverlay(false)
    }).catch(error => {
      setOverlay(false)
    })
}
onMounted(() => {
  getTermCode()
  getCarrera()
  getOrigenes()
})

function changePage(pagenum){
  console.log(pagenum)
  page.value = pagenum
  onSubmit()
}

function changeItemPerPage(perpage) {
  itemsPerPage.value = perpage
  page.value = 1
  onSubmit()
}

function  onSubmitForm() {
  page.value = 1
  onSubmit()
} 
</script>
