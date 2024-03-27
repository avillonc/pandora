<template>
  <div>
    <v-card>
      <v-card-title class="my-2">
        <h3><strong>{{ isShowEntityActive ?  ( isEmpty(entityData.id) ? 'Nueva Variable' : 'Editar Variable') : 'Variables' }}</strong></h3>
      </v-card-title>
      <v-spacer></v-spacer>
      <UCToolbar
        :showForm="isShowEntityActive"
        @on-create="createEntityOrClose"
        @on-read="initialize"
      ></UCToolbar>
      <u-c-data-table-options 
        :key="tableKey"
        v-if="!isShowEntityActive" 
        :items="items" 
        :isTable="false"
        :isLoading="isLoading"
        :headers="headers"
        :search="search"
        sortBy="name"
        @edit="editEntity"
        @delete="showMessageDelete"
        :seeSearch="true">
        <template>
          <v-text-field
            slot="fieldSearch"
            v-model="search"
            append-icon="mdi-magnify"
            label="Buscar en la tabla"
            hide-details
            density="compact"
            variant="outlined"
            small
          ></v-text-field>
        </template>
      </u-c-data-table-options>
      <UCDialogQuestion
        :visible="activeMsgDelete"
        :message="msgDelete"
        title="Eliminar"
        @cancel="closeMsgDelete"
        @ok="deleteEntity"
      ></UCDialogQuestion>
      <variable-entity
        v-if="isShowEntityActive"
        :entityData="entityData" 
        @create="onCreateEntity"
        @on-backward="createEntityOrClose"
        @load-alert="loadAlert"
        @reload="initialize">
      </variable-entity> 
    </v-card>
  </div>
</template>

<script>

import UCDataTableOptions from '@/components/UCDataTableOptions.vue'
import UCDialogQuestion from '@/components/UCDialogQuestion.vue'
import UCToolbar from '@/components/UCToolbar.vue'
import useAppConfig from '@core/@app-config/useAppConfig'
import { isEmpty } from '@core/utils/index'
import { ref } from 'vue'
import VariableEntity from './variables-components/VariableForm.vue'

export default {
  components: {
    VariableEntity,
    UCDataTableOptions,
    UCToolbar,
    UCDialogQuestion
  },
  setup() {
    const entityData = ref({})
    var { overlay } = useAppConfig()

    let isShowEntityActive = ref(false)
    let items = ref([])
    let entity_user = ref({})
    let activeMsgDelete = ref(false)
    let tableKey = ref(0)

    return {
      entityData,
      isShowEntityActive,
      isLoading: false,
      items,
      entity_user,
      headers: [
        { title: 'CODIGO DE VARIABLE', key: 'name', sortable: false, class:'font-weight-bold', width: '180px'},
        { title: 'DESCRIPCIÓN', key: 'descripcion', sortable: false},
        { title: 'VALOR', key: 'defaultvalue', sortable: false, width: '250px'},
        { title: 'ID', key: 'id', sortable: false, align: ' d-none'},
        { title: '', key: 'options', sortable: false },
      ],
      activeMsgDelete,
      msgDelete: '',
      tableKey,
      itemsPage: 25,
      page: 1,
      isEmpty,
      overlay,
      search: ''
    }
  },
  beforeMount(){
    this.overlay = true
    this.initialize()
    /*this.$http.get('/maintenance/roles')
        .then(response => {
          this.roles = response.data
          this.overlay = false
          this.initialize()
        }).catch(error => {
            this.overlay = false
        })*/
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
    initialize() {
      //this.isLoading = true
      this.items = []
      this.$http.get('/maintenance/variables')
          .then(response => {
            this.items = response.data
           // this.isLoading = false
            this.tableKey +=1
            this.$forceUpdate()
            this.overlay = false
      })
    },
    blankEntityData(){
      this.entityData = {estado: 1}
    },
    createEntityOrClose(){
      this.blankEntityData()
      this.isShowEntityActive = !this.isShowEntityActive
    },
    onCreateEntity(item){
      this.isShowEntityActive = false
      if(this.items.length==0) {
         this.items.push(item) 
      } else {
        this.items.splice(0, 0, item)
      }
      this.blankEntityData()
      this.overlay = false 
    },
    editEntity(item){
      
      this.entityData = item.raw
      this.isShowEntityActive = true
    },
    showMessageDelete(item){
      this.entityData = item.raw
      this.msgDelete = "¿Eliminar Usuario: " + this.entityData.name + "?"
      this.activeMsgDelete= true
    },
    closeMsgDelete(){
      this.blankEntityData()
      this.activeMsgDelete = false
    },
    deleteEntity(){
        this.overlay = true
        this.$http.delete('/maintenance/variables/'+this.entityData.id)
            .then(() => {
              this.overlay = false
              
              const index = this.items.indexOf(this.entityData);
              if (index > -1) {
                  this.items.splice(index, 1);
              }

              this.tableKey +=1
              this.closeMsgDelete()
              this.loadAlert('Usuario eliminado correctamente', 'success', 'Éxito')
              
            })
            .catch(error => {  
                  this.overlay = false
                  this.loadAlert(error.response.data.message)
            })
    }
  }
}
</script>
