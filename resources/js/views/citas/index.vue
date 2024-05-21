<template>
  <VCard>
    <VCardTitle
      align="center"
      class="mb-3"
    >
      <span class="font-weight-bold text-primary text-h5">AGENDAR CITA</span>
    </VCardTitle>
    <VCardText class="my-4">
      <VForm
        ref="form"
        v-model="valid"
        @submit="onSubmit" 
        @submit.prevent="validate"
      >  
        <VRow class="user-bio-panel mb-4">
          <VCol cols="12"> 
            <VRow>
              <VCol
                cols="12"
                md="12"
              >
                <VRow>
                  <VCol
                    cols="12"
                    md="4"
                  >
                    <VAutocomplete
                      v-model="entityData.code_modulo"
                      label="Módulo"
                      outlined
                      density="compact"
                      :items="modulos"
                      item-title="name"
                      item-value="id"
                      :menu-props="{ offsetY: true }"
                      hide-details="auto"
                      clearable  
                      @update:modelValue="getProgramacion(); llenarSubModulos();" 
                    />
                  </VCol>
                  <VCol
                    cols="12"
                    md="4"
                  >
                    <VSelect
                      v-model="entityData.code_evento"
                      label="Sub módulo"
                      outlined
                      density="compact"
                      :items="submodulos"
                      item-title="name"
                      item-value="id"
                      :menu-props="{ offsetY: true }"
                      hide-details="auto"
                      @update:modelValue="getProgramacion();llenarDetalle()"  
                    />
                  </VCol>
                  <VCol
                    cols="12"
                    md="4"
                  >
                    <VSelect
                      v-model="entityData.code_sede"
                      label="Sede"
                      outlined
                      density="compact"
                      :items="sedes"
                      item-title="name"
                      item-value="id"
                      :menu-props="{ offsetY: true }"
                      hide-details="auto"
                      @update:modelValue="getProgramacion"  
                    />
                  </VCol>
                  <VCol
                    cols="12"
                    md="4"
                  >
                    <VSelect
                      v-model="entityData.tipo"
                      label="Tipo"
                      outlined
                      density="compact"
                      :items="tipoCitas"
                      item-title="name"
                      item-value="id"
                      :menu-props="{ offsetY: true }"
                      hide-details="auto"
                      @update:modelValue="getProgramacion"  
                    />
                  </VCol>
                  <VCol
                    cols="12"
                    md="4"
                  >
                    <VSelect
                      v-model="entityData.pidm"
                      label="Psicólogo"
                      outlined
                      density="compact"
                      :items="psicologos"
                      item-title="name"
                      item-value="pidm"
                      :menu-props="{ offsetY: true }"
                      hide-details="auto"
                      @update:modelValue="getProgramacion"  
                    /> 
                  </VCol> 
                  <VCol 
                    cols="12"
                    md="4"
                  >
                    <VBtn
                      block
                      color="success"
                      type="button"
                    > 
                      <VIcon
                        size="20"
                        icon="mdi-magnify"
                        color="white"
                      />
                      Consultar
                    </VBtn>
                  </VCol> 
                </VRow>
              </VCol> 
            </VRow> <br>
            <VDivider class="mb-4" /> 
            <VRow>
              <VCol
                cols="12"
                md="4"
              >
                <VCard class="user-plan mb-2">
                  <VCardTitle class="justify-center flex-column">
                    <VCardText>
                      <VRow>
                        <span class="text-sm info--text font-weight-semibold text-primary mb-2">DETALLE DEL MODULO: </span><br>
                      </VRow> 
                      <VRow>
                        <span class="text-sm info--text font-weight-semibold">{{ entityData.detalle }}</span>
                      </VRow> 
                    </VCardText>
                  </VCardTitle>
                </VCard>

                <VCard class="user-plan">
                  <VCardTitle class="justify-center flex-column">
                    <span class="text-sm info--text font-weight-semibold text-primary">MIS ATENCIONES PREVIAS :</span>   
                    <VCardText> 
                      <VDivider class="mb-2" />
                      <div>
                        <h3 class="mb-2">
                          TOTAL: {{ totalSesiones }} SESIONES
                        </h3>
                        <ul>
                          <li
                            v-for="sesion in sesiones"
                            :key="sesion.situacion"
                          >
                            {{ sesion.cant }} =>{{ sesion.descripcion }}
                          </li>
                        </ul>
                      </div> <br>
                      <VDivider class="mb-0" />
                      <VTable density="compact">
                        <thead>
                          <tr>
                            <th class="text-left">
                              F. de atención
                            </th>
                            <th class="text-left">
                              Psicólogo
                            </th>
                            <th class="text-left">
                              Sede
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr
                            v-for="(atencion, index) in atenciones"
                            :key="index"
                          >
                            <td>{{ atencion.fecha }}</td>
                            <td>{{ atencion.psicologo }}</td>
                            <td>{{ atencion.sede }}</td>
                          </tr>
                        </tbody>
                      </VTable> 
                    </VCardText>
                  </VCardTitle>
                </VCard>
              </VCol>
              <VCol
                cols="12"
                md="8"
              >
                <div style="display: flex; align-items: flex-start; justify-content: left;">
                  <!-- Calendario -->
                  <VRow>
                    <VCol
                      cols="12"
                      md="6"
                    >
                      <div style=" min-width: 50%; max-width: 100%;flex: 1; margin-right: 20px;">
                        <FullCalendar
                          :options="calendarOptions"
                          :events="calendarEvents"
                        />
                      </div>
                    </VCol>
                    <VCol
                      cols="12"
                      md="6"
                    >
                      <div style=" min-width: 200px; max-width: 300px;flex: 1; padding: 20px; background-color: #f6f7f8;">
                        <div v-if="eventoDato.start">
                          <h3>{{ formatearFecha(eventoDato.start) }}</h3><br>
                          <div
                            v-if="items.length > 0"
                            class="mb-4"
                          >
                            <span class="text-xs info--text font-weight-semibold mb-4">CUPOS DISPONIBLES:<br></span>
                            <br>
                            <div class="cupos-container mb-4">
                              <div
                                v-for="(cupo, index) in items"
                                :key="index"
                                class="cupo"
                              >
                                <VBtn
                                  type="button"
                                  @click="confirmarReserva(cupo)"
                                >
                                  {{ cupo.hora_ini }}
                                </VBtn>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </VCol>
                  </VRow> 
                </div>
              </VCol>
            </VRow>
          </VCol>
        </VRow>
      </VForm>
      <br>
      <!-- Componente load-alert para mostrar mensajes -->
      <ConfirmaCita
        ref="formFicha"
        v-model:modelValue="showConfirm" 
        :message="alertMessage"
        @cancel="closeModal"
        @ok="grabarCita"
      >
        <VCardText slot="resultado">
          <VRow>
            <VCol
              cols="12"
              md="7"
            >
              <span class="font-weight-bold text-md">Cita: </span>
              <span
                v-if="entityCita.nombre"
                class="text-sm"
              >
                {{ entityCita.nombre }}</span>
            </VCol>
            <VCol
              cols="12"
              md="5"
            >
              <span class="font-weight-bold text-md">Tipo: </span>
              <span
                v-if="entityCita.tipo"
                class="text-sm"
              >
                {{ entityCita.tipo }}</span>
            </VCol>
          </VRow>
          <VRow>
            <VCol
              cols="12"
              md="7"
            >
              <span class="font-weight-bold text-md">Psicologo: </span>
              <span
                v-if="entityCita.psicologo"
                class="text-sm"
              >
                {{ entityCita.psicologo }}</span>
            </VCol>
            <VCol
              cols="12"
              md="5"
            >
              <span class="font-weight-bold text-md">Sede: </span>
              <span
                v-if="entityCita.sede_nombre"
                class="text-sm"
              >
                {{ entityCita.sede_nombre }}</span>
            </VCol>
          </VRow>
          <VRow>
            <VCol
              cols="12"
              md="7"
            >
              <span class="font-weight-bold text-md">Fecha Cita: </span>
              <span
                v-if="entityCita.fecha_cupo"
                class="text-sm"
              >
                {{ entityCita.fecha_cupo }}</span>
            </VCol>
            <VCol
              cols="12"
              md="5"
            >
              <span class="font-weight-bold text-md">Hora Cita: </span>
              <span
                v-if="entityCita.hora_ini"
                class="text-sm"
              >
                {{ entityCita.hora_ini }}</span>
            </VCol> 
          </VRow> 
        </VCardText>
      </ConfirmaCita>
      <template v-if="showFicha">
        <Ficha
          v-model:modelValue="showFicha"
          :message="alertMessage"  
          :periodos="periodos"
          :sw-grabo="swGrabo"
          :motivos="motivos"
          :tiempos="tiempos"
          @cancel="closeModalFicha"
          @delete="delete"
          @ok="validarGrabarFicha"
        />
      </template>
    </VCardText>
  </VCard>
</template>

<script setup>
import axios from '@axios'
import useAppConfig from '@core/@app-config/useAppConfig'
import esLocale from '@fullcalendar/core/locales/es' // Importa el locale español
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import timeGridPlugin from '@fullcalendar/timegrid' // Importa el plugin de la vista de tiempo
import FullCalendar from '@fullcalendar/vue3'
import ConfirmaCita from './citas-components/UCDialogConfirmaCita.vue'
import Ficha from './citas-components/ficha.vue'

const requiredRule = [v => !!v || 'Este campo es requerido']
const $http = inject('http')
const $moment = inject('moment')
const $swal = inject('$swal')

let { overlay } = useAppConfig() 
let entityData = ref({ code_modulo: '', code_evento: '', code_sede: '', tipo: '', pidm: ''  }) 

const valid = ref(false)
const form = ref(null)
const formFicha = ref(null)
const entityFicha = ref({})
const entityCita = ref({})
const eventoDato = ref({})
const showConfirm = ref(false)
const showFicha = ref(false)
const swGrabo = ref(false)
const totalSesiones = ref({})
let items = ref([])
let atenciones = ref([])
let sesiones = ref([])
let submodulos = ref([])
let psicologos = ref([])
let modulos = ref([])
let sedes = ref([])
let periodos = ref([]) 
let motivos = ref([]) 
let tiempos = ref([]) 
let tipoCitas = ref([]) 
const inline = ref(null)

const validate = () => {
  form.value.validate()
}


const setOverlay = value => {
  overlay.value = value
}
 
const handleEventClick = clickInfo => {
  eventoDato.value = clickInfo.event
  console.log("eventoDato.value.id " + eventoDato.value.id)
  listarCupos(eventoDato.value.id)
}

const listarCupos = eventId => {
  setOverlay(true)
  axios.post('programming/getCuposDisponibles', { id: eventId, estado: 1 })
    .then(response => {
      items.value = response.data.data
      setOverlay(false)
    })
    .catch(error => {
      console.error('Error al cargar cupos modulos:', error)
      setOverlay(false)
    })
}

const calendarEvents = ref([])

const calendarOptions = ref({
  plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
  initialView: 'dayGridMonth',

  //dateClick: handleDateSelect,
  eventClick: handleEventClick,
  selectable: true,
  headerToolbar: {
    left: 'prev,next today',
    center: 'title',
    right: 'dayGridMonth,timeGridWeek,timeGridDay',
  },
  locale: esLocale,
  events: calendarEvents,

  /*  buttonIcons: {
        prev: 'fa-chevron-left',
        next: 'fa-chevron-right',
      },*/
})

function loadAlert(text, type="error", title="Advertencia"){
  $swal.fire({
    title: title,
    text: text,
    icon: type,
    confirmButtonText: 'OK',
  })
}

function initialize() {
  showFicha.value = false
  overlay.value = true
  $http.post('programming/listPsicologos', entityData)
    .then(response => {
      psicologos.value = response.data.data
      overlay.value = false 
    }).catch(error => {
      overlay.value = false
    })
  $http.post('data/get-maestras', { idTabla: '13' })
    .then(response => {
      modulos.value = response.data.data
      overlay.value = false 
    }).catch(error => {
      overlay.value = false
    })
  $http.post('data/get-maestras', { idTabla: '3' })
    .then(response => {
      sedes.value = response.data.data
      overlay.value = false 
    }).catch(error => {
      overlay.value = false
    })
  $http.post('data/get-maestras', { idTabla: '1' })
    .then(response => {
      tipoCitas.value = response.data.data
      overlay.value = false 
    }).catch(error => {
      overlay.value = false
    })
  $http.post('data/get-maestras', { idTabla: '15' })
    .then(response => {
      motivos.value = response.data.data
      overlay.value = false 
    }).catch(error => {
      overlay.value = false
    })
  $http.post('data/get-maestras', { idTabla: '14' })
    .then(response => {
      periodos.value = response.data.data
      overlay.value = false 
    }).catch(error => {
      overlay.value = false
    })
  $http.post('data/get-maestras', { idTabla: '16' })
    .then(response => {
      tiempos.value = response.data.data
      overlay.value = false 
    }).catch(error => {
      overlay.value = false
    }) 
}

function llenarSubModulos() {
  submodulos.value  = []
  entityData.value.code_evento = ""
  console.log("llenarSubModulos" + entityData.value.code_modulo)
  overlay.value = true
  $http.post('data/get-maestras', { idTabla: '8', idAsoci: entityData.value.code_modulo })
    .then(response => {
      submodulos.value = response.data.data
      overlay.value = false
    }).catch(error => {
      overlay.value = false
    })
}
function llenarDetalle() { 
  entityData.value.detalle = "" 
  overlay.value = true
  console.log("llenarDetalle" + entityData.value.code_evento)
  $http.post('data/get-maestras', { idTabla: '8', idRegis: entityData.value.code_evento })
    .then(response => {
      entityData.value.detalle = response.data.data[0].detalle
      overlay.value = false
    }).catch(error => {
      overlay.value = false
    })
}
function getProgramacion() {
  items.value = []
  if (entityData.value.code_modulo &&entityData.value.code_evento
        &&entityData.value.code_sede &&entityData.value.pidm &&entityData.value.tipo) {
    overlay.value = true
    $http.post('programming/listProgramacionPsicologia', entityData.value)
      .then(response => {
        if (response.data && Array.isArray(response.data.data)) {
          entityCita.value = response.data.data[0] || {}
          calendarEvents.value = response.data.data.map(event => ({
            title: event.titulo,
            id: event.id,
            start: event.f_start,
            end: event.f_end,
          }))
        }
        else {
          entityCita.value = {}
        }
      })
      .catch(error => {
        console.error('Error al cargar modulos:', error)
      })
      .finally(() => {
        overlay.value = false
      })
  }

}
    
function   formatearFecha(fecha) {
  const meses = [
    'enero',
    'febrero',
    'marzo',
    'abril',
    'mayo',
    'junio',
    'julio',
    'agosto',
    'septiembre',
    'octubre',
    'noviembre',
    'diciembre',
  ]

  const dias = [
    'Domingo',
    'Lunes',
    'Martes',
    'Miércoles',
    'Jueves',
    'Viernes',
    'Sábado',
  ]

  const dateObj = new Date(fecha)
  const diaSemana = dias[dateObj.getDay()]
  const dia = dateObj.getDate().toString().padStart(2, '0')
  const mes = meses[dateObj.getMonth()]
  const año = dateObj.getFullYear()

  return `${diaSemana} ${dia} de ${mes} ${año}`
}

function grabarCita() {
  overlay.value = true

 
  $http.post('programming/registrarCita', entityCita.value)
    .then(response => {
      overlay.value = false
      loadAlert('Tu cita ha sido generada exitosamente', 'success', 'Éxito')
      closeModal()
      items.value = []
      entityCita.value = {}
      entityData.value = {}
      atenciones = []
      sesiones = []
    })
    .catch(error => {
      overlay.value = false 
      if (error.response && error.response.data && error.response.data.message) {
        loadAlert(error.response.data.message)
      } else {
        loadAlert('Error al generar cita')
      }
    })

}
function  closeModal() {
  showConfirm.value = false
}
function  closeModalFicha() {
  showFicha.value = false
}

const validarGrabarFicha = () => { 
  closeModalFicha()
  loadAlert('Ficha registrada exitosamente', 'success', 'Éxito')
    
  
}

function confirmarReserva(cupo) { 
  entityCita.value.fecha_cupo = cupo.fecha_cupo
  entityCita.value.id = cupo.id
  entityCita.value.hora_ini = cupo.hora_ini
  showConfirm.value = true  
}
function buscarAtenciones(){
  totalSesiones.value= 0
  $http.post('programming/listCantSesiones', entityCita.value)
    .then(response => {
      sesiones.value = response.data.data
      totalSesiones.value = sesiones.value.reduce((total, sesion) => total + parseInt(sesion.cant, 10), 0)
    })
    .catch(error => {
      console.error(error)
    })
}
onBeforeMount(() => { 
  $http.post('programming/getFicha',  entityCita.value)
    .then(response => {
      showFicha.value = response.data.rows == 0 ? true : false
      console.log("response.data.data" +  showFicha.value )
    })
    .catch(error => {
      showFicha.value = true
    })
  console.log(" showFicha.value" +  showFicha.value)
  buscarAtenciones()
  initialize()
  
})
defineExpose({
  // validateFicha,
})
</script>

<style>
.user-bio-panel {
  .user-plan {
    border: 2px solid var(--v-primary-base) !important;
  }

  .cupo button {
    padding: 10px;
    border: 1px solid #00bfff;
    margin: 5px;
  }

  .cupos-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 10px;
  }
}
</style>
