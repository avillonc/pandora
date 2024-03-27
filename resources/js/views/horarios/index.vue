<template >
  <v-card class="mx-auto mb-4">
    
    <v-row class="mt-1 pt-1">
      <v-col cols="12" md="12" >
          <span class="white--text text-center mb-0 pt-0"><h2> Horario {{periodoLbl}}</h2></span>
      </v-col>
    </v-row>
    <v-row class="mb-0 mb-0" v-if="itemTotal == 0">
      <v-col cols="12" md="2"></v-col>
      <v-col cols="12" md="8" class="m-0 m-0 mb-6">
        <span class="text-error">
          Horario Verano <strong> {{periodoLbl}}</strong> no disponible. Esta opci&oacute;n solo esta habilitada para alumnos matriculados en el periodo vigente.
        </span>
      </v-col>
      <v-col cols="12" md="2"></v-col>
    </v-row>
    <v-row v-if="itemTotal!==0" class="mb-o pb-0">
      <v-col cols="12" md="1" ></v-col>
      <v-col cols="12" md="10" >
        <NRCSDatatable v-if="!isShowEntityActive"
        :key="tableKey"
        :items="items" 
        :isLoading="isLoading"
        :headers="headers"
        :itemTotal="itemTotal"
        :itemsPage="itemsPerPage"
        :page="page"
        :periodo="periodo"
        @change-page="changePage"
        @item-per-page="changeItemPerPage"
      ></NRCSDatatable>
      </v-col>
      <v-col cols="12" md="1" ></v-col>
    </v-row>
    <v-row v-if="itemTotal!==0" class="mt-0 pt-0">
      <v-col cols="12" md="1" ></v-col>
      <v-col cols="12" md="10" class="text-center" >Total de Créditos: <strong> {{ totCreditos }}</strong></v-col>
      <v-col cols="12" md="1" ></v-col>
    </v-row>
    
    <v-row class="mb-0 mb-0">
      <v-col cols="12" md="2"></v-col>
      <v-col cols="12" md="8" class="m-0 m-0">
       * Cursos del <strong class="text-primary">Tipo VIRTUAL</strong> no aparecen en el horario, ya que no tienen horas de dictado, debes revisar el material y seguir las instrucciones del docente en <strong class="text-primary">ISIL+</strong> . <br>
       * Las horas presenciales programadas en el <strong class="text-primary">Local RM (Remoto) </strong> son dictadas a través de <strong class="text-primary">ISIL+</strong>.
      </v-col>
      <v-col cols="12" md="2"></v-col>
    </v-row>
    <v-row class="mt-0 pt-0">
      <v-col cols="12" md="1"></v-col>
      <v-col cols="12" md="10" class="m-0 pl-4 pr-4">
        <HorariosDatatable v-if="!isShowEntityActive"
        class="mt-0 pt-0"
        density="compact"
        :key="tableKey"
        :items="itemsH" 
        :isLoading="isLoading"
        :headers="headersH"
        :itemTotal="itemTotal"
        :itemsPage="itemsPerPage"
        :page="page"
        :periodo="periodo"
        @change-page="changePage"
        @item-per-page="changeItemPerPage"
      ></HorariosDatatable>
      </v-col>
      <v-col cols="12" md="1"></v-col>
    </v-row>
  </v-card>
</template>
  
<script setup> 
  import useAppConfig from '@core/@app-config/useAppConfig';
import HorariosDatatable from './horarios-components/horariosTable.vue';
import NRCSDatatable from './horarios-components/nrcsTable.vue';
const $http = inject('http')
  let entityData = ref({})
  let { overlay } = useAppConfig()
  const setOverlay = (value) => {
      overlay.value = value
  }
  let periodo = ref(null)
  let periodoLbl = ref(null)
  let items = ref([])
  let itemsH = ref([])
  let tableKey = 0
  let page = ref(1)
  let itemsPerPage = ref(25)
  let itemTotal = ref(null)
  let totCreditos = ref(0)
  let isLoading = ref(false)
  let isShowEntityActive = ref(false)

  const headers = [
        { title: 'NRC', key: 'CODIGO', filterable: true , width: '65', sortable: false},
        { title: 'CURSO', key: 'TITULO', filterable: true, width: '350', sortable: false},
        { title: 'CREDITOS', key: 'CREDITOS', filterable: true, align:'center', sortable: false},
        { title: 'TIPO', key: 'STVSCHD_DESC', align:'center', filterable: true, sortable: false},
        { title: 'LOCAL', key: 'LOCAL', align:'center', sortable: false},
        { title: 'PROFESOR', key: 'PROFESOR', align:'start', width: '250',sortable: false  },
      ]

  const headersH = [
    { title: 'HORA', key: 'horario', filterable: true, sortable: false},
    { title: 'LUNES', key: 'lun', filterable: true, sortable: false},
    { title: 'MARTES', key: 'mar', filterable: true, sortable: false},
    { title: 'MIERCOLES', key: 'mie', filterable: true, sortable: false},
    { title: 'JUEVES', key: 'jue', sortable: false},
    { title: 'VIERNES', key: 'vie',sortable: false  },
    { title: 'SÁBADO', key: 'sab', sortable: false  },
  ]
  function initialize() {
    setOverlay(true)
    getPeriodoActual()
  }
  function changePage(numberPage){
      page.value = numberPage
      onSubmit()
    }

  function changeItemPerPage(itemperpage) {
      itemsPerPage.value = itemperpage
      page.value = 1
      onSubmit()
    }

  function getPeriodoActual(){
    //$http.post('data/currentTermCode')
    $http.post('data/getConfiguration')
    .then(response => { 
      
      periodo.value = response.data.termcode
      periodoLbl.value = response.data.termcode
      getNrcs()
      
    })
  }
    
  function getNrcs(){
    var data = {periodo: periodo.value}
      $http.post('alumnos/horarios-nrcs', data)
      .then(response => { 
        items.value = response.data.data
        itemTotal.value = response.data.data.length
        response.data.data.forEach(async (rating) => {
          totCreditos.value += parseInt(rating.CREDITOS)
        });
        //setOverlay(false)
        getHorarios()
      })  
  }

  function getHorarios(){
    
        $http.post('alumnos/horarios')
        .then(response => { 
            //this.entityData.institucion4_cred = response.data.result.INSTITUCION4_CREDITOS
            itemsH.value = response.data.data
            setOverlay(false)
            //console.log(this.entityData)
        })  
  }
  
  onBeforeMount(() => {
    //alert("a")
    initialize()
  })
</script>
  
<style>

.row-pointer:hover {
  cursor: pointer;
}

</style>
    