<template>
  <div class="mt-6">
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
          <VRow>
            <VCol
              cols="8"
              sm="8"
            >
              <VCardText class="text-2xl pt-8 text-right text-no-wrap">
                <span class="text-secondary text-no-wrap text-h6">Bienvenid@ !! </span>
                <!-- <span class="text-no-wrap font-weight-bold mx-1">ISIL/LAB</span> -->
                <span class="text-h6">🥳</span>
              </VCardText>
              <VCardText class="text-2xl font-weight-bold py-10 text-right">
                <span class="flex-nowrap text-primary text-h5 "> {{ userData.first_name }} </span>
              </VCardText>
            </VCol>
            <VCol
              cols="4"
              sm="4"
            >
              <div>
                <VImg
                  :src="triangleBg"
                  class="triangle-bg flip-in-rtl"
                />
                <VImg
                  width="150"
                  :src="avatar"
                  class="gamification-john-pose-2"
                />
              </div>
            </VCol>
          </VRow>
        </VCard>
      </VCol>
    </VRow>
  </div>
</template>

<script setup>
import useAppConfig from '@core/@app-config/useAppConfig'
import avatar from '@images/avatars/pose-f-39.png'
import triangleDark from '@images/misc/triangle-dark.png'
import triangleLight from '@images/misc/triangle-light.png'
import { useTheme } from 'vuetify'

const userData = JSON.parse(localStorage.getItem('userData'))
const userMenu = JSON.parse(localStorage.getItem('userMenu'))
var { overlay } = useAppConfig()

const { global } = useTheme()
const triangleBg = computed(() => global.name.value === 'light' ? triangleLight : triangleDark)
</script>

<style lang="scss" scoped>
.gamification-tree-4,
.gamification-john-pose-2,
.gamification-tree {
  position: absolute;
}

.gamification-tree {
  inset-block-start: 10%;
}

.gamification-john-pose-2 {
  inset-block-end: 0;
}

.gamification-tree-4 {
  inset-block-end: 0;
}

.v-event {
  text-align: center;
}

@media (max-width: 600px) {
  .gamification-tree,
  .gamification-tree-4 {
    display: none;
  }
}

@media (max-width: 500px) {
  .gamification-john-pose-2 {
    max-inline-size: 120px;
  }
}

@media (max-width: 400px) {
  .page-title {
    font-size: 1rem !important;
  }

  .page-subtitle {
    font-size: 1rem !important;
  }

  .space-name {
    max-inline-size: 100%;
  }

  .space-subname {
    max-inline-size: 60%;
  }
}

@media (max-width: 800px) {
  .home {
    min-block-size: 200px;
  }
}

.v-card .triangle-bg {
  position: absolute;
  inline-size: 8.375rem;
  inset-block-end: 0;
  inset-inline-end: 0;
}
</style>
