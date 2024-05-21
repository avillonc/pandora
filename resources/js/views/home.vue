<template>
  <VApp>
    <!-- 
      <VAppBar app>
      <VAppBarNavIcon
      class="hidden-md-and-up"
      @click="drawer = !drawer"
      /> 
      <VBtn
      v-for="(item, index) in items"
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
      v-for="(item, index) in items"
      :key="index"
      link
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
      </VContainer>
      </VMain>
    -->
  </VApp>
</template>

<script>
/*
export default {
  data: () => ({
    drawer: false,
    items: [
      { icon: 'mdi-calendar', title: 'AGENDAR CITA', link: '/cursos' },
      { icon: 'mdi-calendar-check', title: 'CITAS AGENDADAS', link: '/citas-agendadas' },
      { icon: 'mdi-file-upload', title: 'MIS DOCUMENTOS', link: '/mis-documentos' }, 
    ],
  }),
  methods: {
    selectItem(item) {
      this.drawer = false
      this.$router.push(item.link)
    },
  },
}*/
</script>
