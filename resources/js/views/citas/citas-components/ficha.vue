<template>
  <VForm
    ref="form"
    v-model="valid"
    @submit.prevent="validate"
    @submit="onSubmit" 
  >
    <VDialog
      v-model="dialog"
      persistent
      width="800"
    >
      <VCard>
        <VCardTitle class="font-weight-bold text-center">
          FICHA PSICOLOGICA
        </VCardTitle>
        <VCardText> 
          <VRow class="mb-4">
            <span class="text-md info--text font-weight-semibold text-primary">Para empezar a usar el servicio de consejeria psicológica, por favor completa por única vez la siguiente ficha:</span>
          </VRow> 
          <VRow>
            <VCol
              cols="12"
              md="12"
            > 
              <label class="font-weight-bold text-md">Selecciona los periodos que llevas estudiando con nosotros</label> 
              <VSelect
                v-model="entityFicha.code_periodo"
                label=""
                outlined
                density="compact"
                :items="periodos"
                item-title="name"
                item-value="id"
                :menu-props="{ offsetY: true }"
                hide-details="auto"  
                :rules="[validators.requiredObject]"
              />
            </VCol>
          </VRow>
          <VRow>
            <VCol
              cols="12"
              md="12"
            > 
              <label class="font-weight-bold text-md">¿Has usado el servicio de consejería psicológica de ISIL? </label> 
              <VRadioGroup
                v-model="entityFicha.sw_isil"
                inline
                :rules="[validators.requiredObject]"
              >
                <VRadio
                  label="SI"
                  value="1"
                />
                <VRadio
                  label="NO"
                  value="0"
                />
              </VRadioGroup>
            </VCol>
          </VRow>
          <VRow>
            <VCol
              cols="12"
              md="12"
            > 
              <label class="font-weight-bold text-md">¿Has asistido con anterioridad al psicólogo de manera externa? </label> <label>(fuera de ISIL)</label>
              <VRadioGroup
                v-model="entityFicha.sw_externo"
                inline
                :rules="[validators.requiredObject]"
              >
                <VRadio
                  label="SI"
                  value="1"
                />
                <VRadio
                  label="NO"
                  value="0"
                />
              </VRadioGroup>
            </VCol>
          </VRow>
          <VRow>
            <VCol
              cols="12"
              md="12"
            > 
              <label class="font-weight-bold text-md">¿Has asistido con anterioridad con algún psiquiatra de manera externa? </label> 
              <VRadioGroup
                v-model="entityFicha.psiquiatra"
                inline
                :rules="[validators.requiredObject]"
              >
                <VRadio
                  label="SI"
                  value="1"
                />
                <VRadio
                  label="NO"
                  value="0"
                />
              </VRadioGroup>
            </VCol>
          </VRow>
          <VRow>
            <VCol
              cols="12"
              md="12"
            > 
              <label class="font-weight-bold text-md">¿Cuentas con algún diagnóstico previo?</label> 
              <VTextarea
                v-model="entityFicha.diagnostico"
                label=""
                outlined
                dense
                hide-details="auto"
                rows="2"
                :rules="[validators.requiredObject]" 
              />
            </VCol>
          </VRow>
          <VRow>
            <VCol
              cols="12"
              md="12"
            > 
              <label class="font-weight-bold text-md">Seleccionar el motivo de la atención</label> 
              <VSelect
                v-model="entityFicha.code_motivo"
                label=""
                outlined
                density="compact"
                :items="motivos"
                item-title="name"
                item-value="id"
                :menu-props="{ offsetY: true }"
                hide-details="auto" 
                :rules="[validators.requiredObject]"
              />
            </VCol>
          </VRow>
          <VRow>
            <VCol
              cols="12"
              md="12"
            > 
              <label class="font-weight-bold text-md">¿Desde hace cuánto tiempo vienes enfrentando/pensando en esta situación/problema? </label> 
              <VSelect
                v-model="entityFicha.code_tiempo"
                label=""
                outlined
                density="compact"
                :items="tiempos"
                item-title="name"
                item-value="id"
                :menu-props="{ offsetY: true }"
                hide-details="auto" 
                :rules="[validators.requiredObject]"
              />
            </VCol>
          </VRow>
          <VRow>
            <VCol
              cols="12"
              md="12"
            > 
              <label class="font-weight-bold text-md">¿Cuál es el problema o la situación que te gustaría enfrentar o enfocar con la ayuda de tu psicólogo? </label> 
              <label>Por favor, danos solamente una breve descripción general de lo que te gustaría trabajar. Podrás elaborar con más detalle con tu psicólogo más adelante.</label>
              <VTextarea
                v-model="entityFicha.observacion"
                label=""
                outlined
                dense
                hide-details="auto"
                rows="2"
                :rules="[validators.requiredObject]"
              />
            </VCol>
          </VRow>
          <VRow>
            <VCol
              cols="12"
              md="12"
            > 
              <label class="font-weight-bold text-md"> ¿Qué quisieras obtener de estas sesiones de psicología? </label>  
              <VTextarea
                v-model="entityFicha.resumen"
                label=""
                outlined
                dense
                hide-details="auto"
                rows="2"
                :rules="[validators.requiredObject]"
              />
            </VCol>
          </VRow>
        </VCardText> 
        <VDivider />
        <VSpacer />
        <VCardText>
          <VRow
            v-if="swValido"
            justify="center"
          >
            <span class="text-error font-weight-small">*Debe completar todos los campos de la ficha</span>
          </VRow>
          <VRow justify="center">
            <VCol
              cols="12"
              md="6"
            >
              <VBtn
                block
                color="info"
                type="submit"
                @click="emitOk"
              >
                <VIcon left>
                  mdi-content-save
                </VIcon>
                Grabar respuestas
              </VBtn>
            </VCol>
            <VCol
              cols="12"
              md="6"
            >
            <!-- 
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
            -->
            </VCol>
          </VRow>
        </VCardText>
        <VSpacer />
      </VCard>
    </VDialog>
  </VForm>
</template>

<script setup>
import useAppConfig from '@core/@app-config/useAppConfig'
import { requiredObject } from '@core/utils/validation.js'
import { onBeforeMount, ref } from 'vue'

const props = defineProps({
  modelValue: Boolean,
  swGrabo: Boolean,
  periodos: Array,
  motivos: Array,
  tiempos: Array,
  
})

const emit = defineEmits(['ok', 'cancel'])
const validators = { requiredObject }
const dialog = ref(props.modelValue)
const form = ref(null)
let { overlay } = useAppConfig() 
const entityFicha = ref({ code_periodo: '' }) 
const valid = ref(false)
const swValido = ref(false)
const $http = inject('http')
const $swal = inject('$swal')
let validate = () => {
  form.value.validate()
}
   
watch(() => props.modelValue, newValue => {
  dialog.value = newValue
})

watch(dialog, newValue => {
  emit('update:modelValue', newValue)
})
 
 
const emitOk = () => {
  console.log("emitOk" + valid.value)

  form.value.validate()
  if ( valid.value) {
    overlay.value = true
    $http.post('programming/registrarFicha', entityFicha.value)
      .then(response => {
        overlay.value = false
        emit('ok')
      })
      .catch(error => {
        overlay.value = false  
      })
  
  } else {
    swValido.value = true
    console.log("Validation failed")  
  }
}

const emitCancel = () => {
  console.log("cancel")
  emit('cancel')
}

onBeforeMount(() => { 
})

 
function onSubmit(){
  console.log("onSubmit")
  if (!valid.value) {
    return
  }
      
}
</script>
