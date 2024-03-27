<template >
      
  <v-layout class="rounded rounded-md mt-0">
   <v-main class="d-flex justify-center mt-0" >
     <v-row>
       <v-spacer></v-spacer>
       <v-col cols="12" md="8">
           <v-card class="mx-auto mb-4">

           <v-card-title align="center" class="mb-6">
             <span class="text-primary text-h5">Biblioteca Virtual</span>
           </v-card-title>
             <v-card-text>
              <VRow v-if="!isShowEntityActive">
                <VCol
                  cols="12"
                  md="3"
                />
                <VCol
                  cols="12"
                  md="6"
                  class="m-0 m-0"
                >
                  <div class="text-sm text-center mb-4">
                    <h2 class="mb-4">
                      Hola <strong
                        v-if="entityAlumno.nombres"
                        class="text-xl text-primary"
                      >{{ entityAlumno.nombres }}</strong>
                    </h2>
                    <p>Encuentra aquí diversos recursos virtuales</p>
                    <p> <strong>Libros electrónicos</strong> </p>
                    <v-divider></v-divider>
                    <v-row class="fill-height mt-1 mb-1"
                              align="center"
                              justify="center">
                      <v-col cols="12" md="3" ></v-col>
                      <v-col cols="12" md="3" >
                        <a class="text-center text-h5 text-primary" v-bind:href="'https://ebooks7-24.com/'"  target="_blank" >
                        <v-img
                          :src="`/images/logo_ebooks.jpg`"
                          :width="120"
                          class="bg-grey-lighten-2 text-right"
                        >
                          <template v-slot:placeholder>
                            <v-row
                              class="fill-height ma-0"
                              align="center"
                              justify="center"
                            >
                              <v-progress-circular
                                indeterminate
                                color="grey-lighten-5"
                              ></v-progress-circular>
                            </v-row>
                          </template>
                        </v-img>
                      </a>
                      </v-col>
                      <v-col cols="12" md="3" >
                        <a class="text-center text-h5 text-primary" v-bind:href="'https://ebooks7-24.com/'"  target="_blank" >
                          eBooks
                        </a>
                      </v-col>
                      <v-col cols="12" md="3" ></v-col>
                    </v-row>
                    <v-divider></v-divider>
                    <v-row class="fill-height mt-1 mb-1"
                              align="center"
                              justify="center">
                      <v-col cols="12" md="2" ></v-col>
                      <v-col cols="12" md="4" class="">
                        <v-img
                          :src="`/images/logo_bibliotechnia.png`"
                          :width="150"
                          class="bg-grey-lighten-2 text-right"
                        >
                          <template v-slot:placeholder>
                            <v-row
                              class="fill-height ma-0"
                              align="center"
                              justify="center"
                            >
                              <v-progress-circular
                                indeterminate
                                color="grey-lighten-5"
                              ></v-progress-circular>
                            </v-row>
                          </template>
                        </v-img>
                      </v-col>
                      <v-col cols="12" md="5" >
                        <a class="text-center text-h5 text-primary" v-bind:href="'https://www.bibliotechnia.com.mx/auth/exception_access/dSalV2nZN!vtDeQotx!jMFNtdbFJbTyN4ZKTqBtgHWE'"  target="_blank" >
                          BiblioTechnia
                        </a>
                      </v-col>
                      <v-col cols="12" md="1" ></v-col>
                    </v-row>
                    <v-divider></v-divider>
                    <v-row class="fill-height mt-1 mb-1" align="center" justify="center">
                      <v-col cols="12" md="12" >
                        <p>
                        <a class="text-center text-h5 text-primary" v-bind:href="'https://www.vlebooks.com/vleweb/Account/Logon/San%20Ignac'"  target="_blank" >
                          Vlebooks
                        </a></p>
                          <p>Identificación de la Institución: <strong>San Ignac</strong></p>
                          <p>Usuario: <strong>9142805cg</strong></p>
                          <p>Contraseña: <strong>69"&n8eF?h]n"@Jk</strong></p>
                          <br>
                          <p class="text-h6"> 
                            <strong > Bases de datos INFOTRAC</strong>
                            <br>
                            Ingresa a estos recursos con la contraseña: <strong >isilweb</strong>
                          </p>
                      </v-col>
                    </v-row>
                  </div>
                </VCol> 
              </VRow>
              <v-divider></v-divider>
              <v-row class="fill-height mt-1 mb-1"
                        align="center"
                        justify="center">
                <v-col cols="12" md="1" >
                  <a class="text-center text-h5 text-primary" v-bind:href="'http://find.galegroup.com/menu/start?userGroupName=isil&prod=IFME'"  target="_blank" >
                  <v-img
                    :src="`/images/img_b2.jpg`"
                    :width="30"
                    class="bg-grey-lighten-2 text-right"
                  >
                    <template v-slot:placeholder>
                      <v-row
                        class="fill-height ma-0"
                        align="center"
                        justify="center"
                      >
                        <v-progress-circular
                          indeterminate
                          color="grey-lighten-5"
                        ></v-progress-circular>
                      </v-row>
                    </template>
                  </v-img>
                </a>
                </v-col>
                <v-col cols="12" md="2" >
                  <a class="text-primary" v-bind:href="'http://find.galegroup.com/menu/start?userGroupName=isil&prod=IFME'"  target="_blank" >
                    Informe
                  </a>
                </v-col>
                <v-col cols="12" md="9" >
                  Cubre necesidades de información para todas las disciplinas académicas. Desde economía, ciencia y tecnología, psicología, educación, hasta arqueología, historia, literatura y más. Contiene revistas académicas de toda Iberoamérica.
                </v-col>
              </v-row>
              <v-divider></v-divider>
              <v-row class="fill-height mt-1 mb-1"
                        align="center"
                        justify="center">
                <v-col cols="12" md="1" >
                  <a class="text-center text-primary" v-bind:href="'http://find.galegroup.com/menu/start?userGroupName=isil&prod=IFME'"  target="_blank" >
                  <v-img
                    :src="`/images/img_b7.jpg`"
                    :width="30"
                    class="bg-grey-lighten-2 text-right"
                  >
                    <template v-slot:placeholder>
                      <v-row
                        class="fill-height ma-0"
                        align="center"
                        justify="center"
                      >
                        <v-progress-circular
                          indeterminate
                          color="grey-lighten-5"
                        ></v-progress-circular>
                      </v-row>
                    </template>
                  </v-img>
                </a>
                </v-col>
                <v-col cols="12" md="2" >
                  <a class="text-primary" v-bind:href="'http://find.galegroup.com/menu/start?userGroupName=isil&prod=PPTH'"  target="_blank" >
                    Hospitality, Tourism and Leisure Collection
                  </a>
                </v-col>
                <v-col cols="12" md="9" >
                  Con contenidos actuales y relevantes de más de 500 revistas de la industria de la hospitalidad y el turismo, esta colección ofrece una amplia cobertura temática en los aspectos históricos y actuales del turismo, así como viajes y actividades de ocio.

                </v-col>
              </v-row>
              <v-divider></v-divider>
              <v-row class="fill-height mt-1 mb-1" align="center" justify="center">
                <v-col cols="12" md="12" >
                  <p class="text-h6 text-center"> 
                      <strong > Repositorio virtual ISIL</strong><br>
                      <v-img
                      :src="`/images/logo-isil-nuevo.png`"
                      :width="120"
                      class="bg-grey-lighten-2 text-center"
                    ></v-img>
                    </p>
                </v-col>
                <v-col cols="12" md="12" class="m-0 p-0" >
              
                </v-col>

              </v-row>
              <VRow v-if="!isShowEntityActive">
                <VCol
                  cols="12"
                  md="2"
                />
                <VCol
                  cols="12"
                  md="8"
                  class="m-0 m-0"
                >
                  <div class="text-sm text-center mb-4">
                    <p> <strong>Otros Recursos</strong> </p>
                    <v-divider></v-divider>
                    <v-row class="fill-height mt-1 mb-1"
                              align="center"
                              justify="center">
                      <v-col cols="12" md="4" >
                        <a class="text-center text-h5 text-primary" v-bind:href="'https://www.e-unwto.org/'"  target="_blank" >
                        <v-img
                          :src="`/images/logo_elibrary.jpg`"
                          
                          class="bg-grey-lighten-2 text-right"
                        >
                          <template v-slot:placeholder>
                            <v-row
                              class="fill-height ma-0"
                              align="center"
                              justify="center"
                            >
                              <v-progress-circular
                                indeterminate
                                color="grey-lighten-5"
                              ></v-progress-circular>
                            </v-row>
                          </template>
                        </v-img>
                      </a>
                      </v-col>
                      <v-col cols="12" md="8" >
                        <a class="text-primary" v-bind:href="'https://www.e-unwto.org/'"  target="_blank" >
                          Biblioteca Virtual OMT: Organización Mundial de Turismo
                        </a>
                      </v-col>
                    </v-row>
                    <v-divider></v-divider>
                    <v-row class="fill-height mt-1 mb-1"
                              align="center"
                              justify="center">
                      <v-col cols="12" md="4" class="">
                        <a class="text-center text-primary" v-bind:href="'http://bibliotecadigital.bnp.gob.pe/'"  target="_blank" >
                        <v-img
                          :src="`/images/logo_bnp.png`"
                          
                          class="bg-grey-lighten-2 text-right"
                        >
                          <template v-slot:placeholder>
                            <v-row
                              class="fill-height ma-0"
                              align="center"
                              justify="center"
                            >
                              <v-progress-circular
                                indeterminate
                                color="grey-lighten-5"
                              ></v-progress-circular>
                            </v-row>
                          </template>
                        </v-img>
                      </a>
                      </v-col>
                      <v-col cols="12" md="8" >
                        <a class="text-center text-primary" v-bind:href="'http://bibliotecadigital.bnp.gob.pe/'"  target="_blank" >
                          Biblioteca Nacional
                        </a>
                      </v-col>
                      <v-col cols="12" md="1" ></v-col>
                    </v-row>
                    <v-divider></v-divider>
                  </div>
                </VCol> 
              </VRow>
             </v-card-text>   
           </v-card>
       </v-col>
       <v-spacer></v-spacer>
     </v-row>
     
   </v-main>
 </v-layout>
</template>

<script setup> 
import useAppConfig from '@core/@app-config/useAppConfig';
const $http = inject('http')
let entityAlumno= ref({}) 
let { overlay } = useAppConfig()
const setOverlay = (value) => {
    overlay.value = value
}


function getMostrarDatos(){
  setOverlay(true)
  $http.post('alumnos/datos')
    .then(response => { 
      entityAlumno.value= response.data.data[0] 
      setOverlay(false) 
    }) 
 
}
 
onMounted(() => {
  getMostrarDatos()
})
</script>
