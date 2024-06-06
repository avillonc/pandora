<template>
  <VApp>
    <VAppBar
      app
      color="primary"
      density="compact"
      scroll-behavior="hide"
    >
      <VImg
        :src="logoh"
        height="80"
        width="80"
        contain
        class="ma-0 pa-0"  
      /> 
      <VToolbarTitle class="pl-2 ml-2">
        <!-- Modulos -->
      </VToolbarTitle>
      <VSpacer /> <VSpacer /> <VSpacer /> <VSpacer /> <VSpacer /> 
      <UserProfile class="mr-2" />
    </VAppBar>

    <VAppBar app>
      <VAppBarNavIcon
        class="hidden-md-and-up"
        @click="drawer = !drawer"
      /> 
      <VBtn
        v-for="(item, index) in menulist"
        :key="index"  
        @click="selectItem(item)" 
      >
        <VIcon>{{ item.icon }}</VIcon>
        {{ item.title }} 
      </VBtn> 
      <VSpacer />
      <VToolbarTitle>
        Bienvenid@ !! 🥳 
      </VToolbarTitle>
    </VAppBar>
    <VNavigationDrawer
      v-model="drawer"
      app
      temporary
      class="hidden-md-and-up"
    >
      <VList dense>
        <VListItem
          v-for="(item, index) in menulist"
          :key="index"
          path
          @click="selectItem(item)"
        >
          <VListItemIcon>
            <VIcon>{{ item.icon }}</VIcon>
          </VListItemIcon>
          <VListItemContent>
            <VListItemTitle>
              {{ item.title }}
            </VListItemTitle>
          </VListItemContent>
        </VListItem>
      </VList>
    </VNavigationDrawer>
    <VMain>
      <VContainer>
        <RouterView />
      </VContainer>
    </VMain>
    <VOverlay
      :model-value="store.state.appConfig.loadcontentshowoverlay"
      class="align-center justify-center"
      persistent
    >
      <VProgressCircular
        color="on-secondary"
        indeterminate
        size="50"
      />
    </VOverlay>
  </VApp>
</template>

<script setup>
import UserProfile from '@/layouts/components/UserProfile.vue'
import store from '@/store'
import useAppConfig from '@core/@app-config/useAppConfig'
import logoh from '@images/logos/isil_logo.png'
import { inject } from "vue"

var { overlay, menulist, navigation } = useAppConfig()
let navMenuItems = ref([])
const drawer = ref(false)
const http = inject('http')

/*
const items = [
  { icon: 'mdi-calendar', title: 'AGENDAR CITA', link: '/citasProgramar' },
  { icon: 'mdi-calendar-check', title: 'MIS CITAS', link: '/misCitas' },
  { icon: 'mdi-file-upload', title: 'MIS DOCUMENTOS', link: '/mis-documentos' }, 
  { icon: 'mdi-account', title: 'MIS DATOS', link: '/mis-datos' }, 
  { icon: 'mdi-account', title: 'CASOS ESPECIALES', link: '/casos-especiales' }, 
]*/

onBeforeMount(() => { 

  http.get('/system/menu')
    .then(response => {
      // console.log(response.data )

      // navMenuItems.value = response.data
      //menulist.value =  response.data
      //navigation.value =  []  

      //console.log(menulist.value )
      //console.log(navMenuItems.value )
    })
})

const router = useRouter()

const selectItem = item => {
  drawer.value = false
  router.push(item.path)
}
</script>

<style>
.layout-wrapper.layout-blank {
  flex-direction: column;
}
</style>
