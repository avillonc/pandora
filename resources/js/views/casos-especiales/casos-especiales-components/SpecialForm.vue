<template>
  <VCard>
    <VCardText class="my-2">
      <VForm
        ref="form"
        v-model="valid"
        @submit="onSubmit"
        @submit.prevent="validate"
      >
        <VRow class="user-bio-panel">
          <VCol
            cols="12"
            md="4"
          >
            <VCard class="user-plan">
              <VCardTitle class="justify-center flex-column">
                <VCardText>
                  <span class="text-sm info--text font-weight-bold text-primary">Datos Personales</span>
                  <VDivider class="mb-4" />
                  <VRow>
                    <VCol
                      cols="12"
                      md="12"
                    >
                      <span class="font-weight-bold text-md">Nombres: </span>
                      <span
                        v-if="entityData.nombre"
                        class="text-sm"
                      >
                        {{ entityData.nombre }}</span>
                    </VCol>
                  </VRow>
                  <VRow>
                    <VCol
                      cols="12"
                      md="8"
                    >
                      <span class="font-weight-bold text-md">Edad: </span>
                      <span
                        v-if="entityData.edad"
                        class="text-sm"
                      >
                        {{ entityData.edad }} años</span>
                    </VCol>
                    <VCol
                      cols="12"
                      md="4"
                    >
                      <span class="font-weight-bold text-md">Género: </span>
                      <span
                        v-if="entityData.genero"
                        class="text-sm"
                      >
                        {{ entityData.genero }}</span>
                    </VCol>
                  </VRow>
                  <VRow>
                    <VCol
                      cols="12"
                      md="12"
                    >
                      <span class="font-weight-bold text-md">Teléfono: </span>
                      <span
                        v-if="entityData.celular"
                        class="text-sm"
                      >
                        {{ entityData.celular }}</span>
                    </VCol>
                  </VRow>
                  <VRow>
                    <VCol
                      cols="12"
                      md="12"
                    >
                      <span class="font-weight-bold text-md">Correo: </span>
                      <span
                        v-if="entityData.correo"
                        class="text-sm"
                      >
                        {{ entityData.correo }}</span>
                    </VCol>
                  </VRow>
                </VCardText>

                <VCardText>
                  <span class="text-sm info--text font-weight-bold text-primary">Datos Académicos</span>
                  <VDivider class="mb-4" />
                  <VRow>
                    <VCol
                      cols="12"
                      md="8"
                    >
                      <span class="font-weight-bold text-md">Periodo actual: </span>
                      <span
                        v-if="entityData.periodo"
                        class="text-sm"
                      >
                        {{ entityData.periodo }}</span>
                    </VCol>
                    <VCol
                      cols="12"
                      md="4"
                    >
                      <span class="font-weight-bold text-md">Carrera: </span>
                      <span
                        v-if="entityData.carrera"
                        class="text-sm"
                      >
                        {{ entityData.carrera }}</span>
                    </VCol>
                  </VRow>
                  <VRow>
                    <VCol
                      cols="12"
                      md="6"
                    >
                      <span class="font-weight-bold text-md">Sede: </span>
                      <span
                        v-if="entityData.sede"
                        class="text-sm"
                      >
                        {{ entityData.sede }}</span>
                    </VCol>
                  </VRow>
                </VCardText>
                <VCardText>
                  <span class="text-sm info--text font-weight-bold text-primary">Atenciones</span>
                  <VDivider class="mb-4" />
                  <div>
                    <h4>TOTAL: {{ totalSesiones }} SESIONES</h4>
                    <ul>
                      <li
                        v-for="sesion in sesiones"
                        :key="sesion.situacion"
                      >
                        {{ sesion.cant }} =>{{ sesion.descripcion }}
                      </li>
                    </ul>
                  </div>
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
                <VCardText>
                  <span class="text-sm info--text font-weight-bold text-primary">Cursos vigentes</span>
                  <VDivider class="mb-4" /> 
                  <VTable density="compact">
                    <thead>
                      <tr>
                        <th class="text-left">
                          Curso
                        </th>
                        <th class="text-left">
                          NRC
                        </th>
                        <th class="text-left">
                          Docente
                        </th>
                        <th class="text-left">
                          Correo
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td> INTRODUCCION A LA PROGRAMACION </td>
                        <td>1748</td>
                        <td>MARCO ANTONIO DIAZ ZAVALA</td>
                        <td />
                      </tr>
                      <tr>
                        <td> AUDIOVISUALES </td>
                        <td>1043</td>
                        <td>MARIA PIA SOTOMAYOR PALACIOS</td>
                        <td />
                      </tr>
                      <tr>
                        <td>DISEÑO DE INTERFACES GRÁFICAS</td>
                        <td>1536</td>
                        <td>HENRY ROGER CACHAY SALAZAR</td>
                        <td />
                      </tr>
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
            <span class="text-sm info--text font-weight-bold text-error">Discapacidad:</span>
            <VDivider class="mb-4" />
            <VRow>
              <VCol
                v-for="(opcion, index) in discapacidades"
                :key="index"
                cols="12"
                md="3"
                class="pa-3 ma-0"
              >
                <VCard
                  color="black"
                  class=" lighten-3 text-md info--text font-weight-bold text-primary text-center pa-1"
                >
                  {{ opcion.name }}
                </VCard>
              </VCol>
            </VRow><br>
            <VDivider class="mb-4" />
            <VRow>
              <VCol
                cols="12"
                md="6"
              >
                <VTextarea
                  v-model="entityData.motivo"
                  label="Motivo"
                  outlined
                  density="compact"
                  hide-details="auto"
                  rows="4"
                  readonly 
                />
              </VCol>
              <VCol
                cols="12"
                md="6"
              >
                <VTextarea
                  v-model="entityData.recomendacion_consejeria"
                  label="Recomendación de consejería"
                  outlined
                  density="compact"
                  readonly
                  hide-details="auto"
                  rows="4"
                />
              </VCol>
            </VRow>
            <VRow>
              <VCol
                cols="12"
                md="6"
              >
                <VTextarea
                  v-model="entityData.recomendacion_psicologia"
                  label="Recomendación de psicología"
                  outlined
                  readonly
                  density="compact"
                  hide-details="auto"
                  rows="4"
                />
              </VCol>
              <VCol
                cols="12"
                md="6"
              >
                <VTextarea
                  v-model="entityData.requerimientos"
                  label="Requerimientos adicionales"
                  outlined
                  density="compact"
                  hide-details="auto"
                  readonly
                  rows="4"
                />
              </VCol>
            </VRow>
            <br>
            <span class="mb-4 text-sm info--text font-weight-bold text-primary"> CADA ACCIÓN CUENTA<br>
              ¡Por Favor ayudenos con sus observaciones ...!<br></span>
            <VDivider class="mb-4" />

            <VRow class="mt-0 pt-0 text-center mb-8"> 
              <VCol
                cols="12"
                md="12"
                class="d-flex justify-space-between align-center m-0" 
              >
                <IncidenciaTabla  
                  :key="tableKey"
                  class="mt-0 pt-0"
                  :items="items" 
                  :is-loading="isLoading"
                  :headers="headers"
                  :item-total="itemTotal"
                  :items-page="itemsPerPage"
                  :page="page"
                  @change-page="changePage"
                  @item-per-page="changeItemPerPage"
                  @edit-incidencia="editIncidencia"
                /> 
              </VCol> 
            </VRow>
            <VRow class="mb-4">
              <VCol
                cols="12"
                md="6"
              >
                <VTextarea
                  v-model="entityIncidencia.detalle_incidencia"
                  label="Incidencias en clase"
                  outlined
                  density="compact"
                  hide-details="auto"
                  :rules="[validators.requiredObject]" 
                  rows="4"
                />
              </VCol>
              <VCol
                cols="12"
                md="6"
              >
                <VTextarea
                  v-model="entityIncidencia.solucion"
                  label="¿Qué funciono en clase?"
                  outlined
                  density="compact"
                  hide-details="auto"
                  rows="4"
                  :rules="[validators.requiredObject]" 
                />
              </VCol>
            </VRow> 
          </VCol>
        </VRow>
        <VRow />
        <VRow justify="end">
          <VCol
            offset-md="12"
            cols="12"
            md="3"
          >
            <VBtn
              block
              color="primary"
              type="submit"
            >
              <VIcon
                left
                dark
              >
                mdi-content-save 
              </VIcon>
              Guardar
            </VBtn>
          </VCol> 
        </VRow>
      </VForm>
    </VCardText>
  </VCard>
</template>

<script>
import useAppConfig from '@core/@app-config/useAppConfig'
import { emailValidator, requiredObject } from '@core/utils/validation.js'
import { ref } from 'vue'
import IncidenciaTabla from './IncidenciasTable.vue'

export default {
  components: {
    IncidenciaTabla,
  },
  props: {
    entityData: {
      type: Object,
      required: true,
    },

  },
  setup() {
    const validators = { requiredObject, emailValidator }
    var { overlay } = useAppConfig()
    const valid = ref(false)
    const form = ref(null)
    const entityData = ref({})
    const entityIncidencia = ref({})

    const validate = () => {
      form.value.validate()
    }

 
    return {
      entityIncidencia,
      valid,
      form,
      overlay,
      validate, 
      validators: {
        requiredObject,
        emailValidator,
      },
      tipoCitas: ref([]),
      modalidades: ref([]),
      sedes: ref([]),
      discapacidades: ref([]),
      diasSelect: ref([]),
      psicologos: ref([]),
      dias: ref([]),
      eventos: ref([]),
      selectedOptions: ref([]), 
      isReadOnly: false,
      isLoading: false,
      sesiones: ref([]),
      totalSesiones: 0,
      atenciones: ref([]),
      headers: [
        { title: 'FECHA REGISTRO', key: 'fecha', align: 'center', width: '120' },
        { title: 'INCIDENCIA', key: 'detalle_incidencia', align: 'center', width: '280' },
        { title: 'QUÉ FUNCIONÓ', key: 'solucion', align: 'center', width: '280' }, 
        { title: 'OPCIONES', key: 'options', width: '90' },
      ],
      items: ref([]),
    }
  },

  mounted() {
    console.log(this.entityData)
    this.listarDiscapacidades()
    this.listaPsicologos()
    this.listarIncidencias()
    this.valid = false
    this.validarGrabar
  },


  methods: {
    validarGrabar() {
      this.valid = true
    },
    
    onSubmit() {
      console.log(this.valid)
      if (this.valid) {
        
        this.entityIncidencia.pidm = this.entityData.pidm
        this.overlay = true
        this.$http.post('programming/registrarIncidencia', this.entityIncidencia)
          .then(response => {
            this.overlay = false

            //  this.$emit('create', response.data)
            this.loadAlert('éxito al registrar incidencia', 'success', 'Éxito')
            this.listarIncidencias()
            this.entityIncidencia = {} 
          })
          .catch(error => {
            this.overlay = false
            this.loadAlert(error.response.data.message, 'error', 'Error')

          }) 

      } else {
        this.validate()
      }
    },

    loadAlert(text, type = "error", title = "Advertencia") {
      this.$swal.fire({
        title: title,
        text: text,
        icon: type,
        confirmButtonText: 'OK',
      })
    },
    initialize() {

    },

    listaPsicologos() {
      this.overlay = true
      this.$http.post('programming/listPsicologos', this.entityData)
        .then(response => {
          this.psicologos = response.data.data
          this.overlay = false
          this.$forceUpdate()
        }).catch(error => {
          this.overlay = false
        })
    },

    listarDiscapacidades() {
      this.overlay = true
      this.$http.post('programming/getDiscapacidadPac', this.entityData)
        .then(response => {
          this.discapacidades = response.data.data
          this.overlay = false
          this.$forceUpdate()
        }).catch(error => {
          this.overlay = false
        })
    },
    listarIncidencias() {
      this.overlay = true
      this.$http.post('programming/getIncidencias', this.entityData)
        .then(response => {
          this.items = response.data.data
          this.overlay = false
          this.$forceUpdate()
        }).catch(error => {
          this.overlay = false
        })
    },
    onlyNumbers(event) {
      const charCode = event.keyCode
      if (charCode < 48 || charCode > 57) {
        event.preventDefault()
      }
    },
    resetEntityData() {
      const defaultEntityData = {}

      this.$emit('update:entityData', defaultEntityData)
    },

    editIncidencia(item){
      console.log("item"+ item.value.id_incidencia)
      this.entityIncidencia = item.value
    
    },
  },
}
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
