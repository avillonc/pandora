import { createRouter, createWebHistory } from 'vue-router'

import store from '@/store'

const ifNotAuthenticated = (to, from, next) => {
  if (!store.getters['app/isAuthenticated']) {
    next()
    
    return
  }
  next('/')
}

const ifAuthenticated = (to, from, next) => {
  
  if (store.getters['app/isAuthenticated']) {
    next()
    
    return
  }

  //next('/login')
  return next({ path: '/login' })
}


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  scrollBehavior() {
    return { x: 0, y: 0 }
  },
  routes: [
    { path: '/', redirect: '/home' },
    {
      path: '/',
      component: () => import('../layouts/blank2.vue'),
      children: [
        {
          path: 'home',
          name: 'home',
          component: () => import('../views/home.vue'),
          beforeEnter: ifAuthenticated,
          meta: {
            requiresAuth: true,
          },
        },
        {
          path: 'horarios',
          name: 'horarios',
          component: () => import('../views/horarios/index.vue'),
          beforeEnter: ifAuthenticated,
          meta: {
            requiresAuth: true,
          },
        },
        {
          path: 'survey',
          name: 'survey',
          component: () => import('../views/survey/index.vue'),
          beforeEnter: ifAuthenticated,
          meta: {
            requiresAuth: true,
          },
        },
        {
          path: 'service_request',
          name: 'service_request',
          component: () => import('../views/service-request/index.vue'),
          beforeEnter: ifAuthenticated,
          meta: {
            requiresAuth: true,
          },
        },
        {
          path: 'bloques',
          name: 'bloques',
          component: () => import('../views/bloques/index.vue'),
          beforeEnter: ifAuthenticated,
          meta: {
            requiresAuth: true,
          },
        },
        {
          path: 'tarifario',
          name: 'tarifario',
          component: () => import('../views/tarifario/index.vue'),
          beforeEnter: ifAuthenticated,
          meta: {
            requiresAuth: true,
          },
        },
        {
          path: 'terminos',
          name: 'terminos',
          component: () => import('../views/terminos/index.vue'),
          beforeEnter: ifAuthenticated,
          meta: {
            requiresAuth: true,
          },
        },        
        {
          path: 'isiljob',
          name: 'isiljob',
          component: () => import('../views/isiljob/index.vue'),
          beforeEnter: ifAuthenticated,
          meta: {
            requiresAuth: true,
          },
        },        
        {
          path: 'examenes',
          name: 'examenes',
          component: () => import('../views/examen/index.vue'),
          beforeEnter: ifAuthenticated,
          meta: {
            requiresAuth: true,
          },
        },
        {
          path: 'biblioteca_virtual',
          name: 'biblioteca_virtual',
          component: () => import('../views/biblioteca_virtual/index.vue'),
          beforeEnter: ifAuthenticated,
          meta: {
            requiresAuth: true,
          },
        },
        {
          path: 'cursos',
          name: 'cursos',
          component: () => import('../views/cursos/index.vue'),
          beforeEnter: ifAuthenticated,
          meta: {
            requiresAuth: true,
          },
        },
        {
          path: 'egresados',
          name: 'egresados',
          component: () => import('../views/egresados/index.vue'),
          beforeEnter: ifAuthenticated,
          meta: {
            requiresAuth: true,
          },
        },
        {
          path: 'interview',
          name: 'interview',
          component: () => import('../views/interview/index.vue'),
          beforeEnter: ifAuthenticated,
          meta: {
            requiresAuth: true,
          },
        },
        {
          path: 'new-teacher',
          name: 'new-teacher',
          component: () => import('../views/interview-new-teacher/index.vue'),
          beforeEnter: ifAuthenticated,
          meta: {
            requiresAuth: true,
          },
        },
        {
          path: 'variables',
          name: 'variables',
          component: () => import('../views/maintainer/variables/Variables.vue'),
          beforeEnter: ifAuthenticated,
          meta: {
            requiresAuth: true,
          },
        },
      ],
    },
    {
      path: '/',
      component: () => import('../layouts/blank.vue'),
      children: [
        {
          path: 'login',
          name: 'login',
          component: () => import('../views/login.vue'),
          beforeEnter: ifNotAuthenticated,
        },
        {
          path: 'login/:id/:token',
          name: 'loginid',
          component: () => import('../views/login.vue'),
          beforeEnter: ifNotAuthenticated,
        },
        {
          path: 'error-401',
          name: 'error-401',
          component: () => import('../views/notRegistered.vue'),
        },
        {
          path: 'error-403',
          name: 'error-403',
          component: () => import('../views/NotAuthorized.vue'),
        },
        {
          path: '/:pathMatch(.*)*',
          name: 'error-404',
          component: () => import('../views/Error404.vue'),
        },
      ],
    },
  ],
})

function searchPath(argument, level, levelTwo, path) {
  var find = argument.find(el => el.path == level)
  if (find != undefined) {
    if(find.children) {
      if (!searchPath(find.children, levelTwo, null, path)) {
        return searchPath(find.children, path, null, null)
      } else {
        return true
      }
    } else {
      return true
    }
  } 

  return false
}

router.beforeEach((to, _, next) => {
  
  var menu = store.state.app.menu

  /*if(!store.mrev){
    store.mprev = to.name
  }*/
  
  //
  const levelOne=to.meta.levelOne ? to.meta.levelOne : to.path
  const levelTwo=to.meta.levelTwo ? to.meta.levelTwo : to.path
  if(to.meta.requiresAuth && to.meta.noValidate==undefined) {
  
    //if (!store.getters['app/isAuthenticated']) return next({ path: '/login' })
    if (!store.getters['app/isAuthenticated']) {
      localStorage.setItem("mprev", to.path)
      window.location.href = '/app/redirect/' 
      
      return
    }

    //console.log(localStorage.getItem("mprev"))
    var findpath = searchPath(menu, levelOne, levelTwo, to.path) 
    if(!findpath) return next({ name: 'error-403' })

  }
    
  return next()

})



export default router
