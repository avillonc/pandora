//import { mdiCheckboxBlankCircleOutline } from '@mdi/js'

const themeConfig = {
  app: {
    name: 'HARSON',
    logo: '',//require('@/assets/images/svg/logo.png').default,
    isDark: false,
    isRtl: false,
    contentLayoutNav: 'vertical', // vertical, horizontal
    routeTransition: 'scroll-y-reverse-transition', // https://vuetifyjs.com/en/styles/transitions/#api
    // ! `semi-dark` isn't available for horizontal nav menu
    skinVariant: 'bordered', // default, bordered, semi-dark 
    contentWidth: 'boxed',
  },
  menu: {
    isMenuHidden: false,
    isVerticalNavMini: false,
    verticalMenuAccordion: true,
    //groupChildIcon: mdiCheckboxBlankCircleOutline,
    horizontalNavMenuGroupOpenOnHover: true,
  },
  appBar: {
    /*
    ! In Content Layout Horizontal Nav type `hidden` value won't work
    ! In Content Layout Horizontal Nav type value of `type` will affect both Appbar and Horizontal Navigation Menu
    */
    type: 'static', // fixed, static, hidden
    isBlurred: true,
  },
  footer: {
    type: 'static', // fixed, static, hidden
  },
  themes: {
    light: {
      primary: '#033647', //'#009bdb',//'#51a9c8', // 9155FD
      secondary: '#74869f', //'#bdbdbd',
      accent: '#effafd',
      //success: '#18BC5A',
      success: '#015a78',
      info: '#00cbfb', //'#6ab4ce', //'#6BA6F9', dark blue
      warning: '#FFB400', //'#F7EB13',
      error: '#FF4538',
    },
    dark: {
      primary: '#28243d', //'#51a9c8',
      accent: '#d8d8d8',
      secondary: '#8A8D93',
      success: '#18BC5A',
      info: '#009abe', //'#16B1FF',
      warning: '#eaa602', 
      error: '#FF4C51',
    },
  },
}

export default themeConfig
