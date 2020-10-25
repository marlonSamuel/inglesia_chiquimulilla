<template>
  <v-layout align-start v-loading="loading">
    <v-flex>
      
    <v-container grid-list-md>
      <v-flex>
        <v-layout row wrap justify-end>
        <div>
          <v-breadcrumbs :items="itemsB">
            <template v-slot:divider>
              <v-icon>forward</v-icon>
            </template>
          </v-breadcrumbs>
        </div>
      </v-layout>
    </v-flex>
        <v-layout row wrap v-if="feligres !== null">
            <v-flex xs12>
                <v-card  v-if="feligres.bautizo !== null">
                    <v-card-title>
                        <span class="headline">BAUTIZMO</span>
                    </v-card-title>
                    <v-card-text class="px-0">
                        <v-container grid-list-md>
                            <v-layout>
                            <div>
                                <v-btn small @click="beforePrint('B')"><v-icon>print</v-icon></v-btn><br />
                                <strong>Fecha de bautizo: </strong>{{feligres.bautizo.fecha | moment('DD/MM/YYYY')}}<br />
                                <strong>Bautizo de:</strong><br />
                                <strong>Nombre:</strong><span> {{feligres.primer_nombre}}
                                                                        {{feligres.segundo_nombre}}
                                                                        {{feligres.primer_apellido}}
                                                                        {{feligres.segundo_nombre}}
                                                                        </span><br />
                                <strong>Fecha de nacimiento:</strong>  {{feligres.fecha_nac | moment('DD/MM/YYYY')}}<br />
                                </div>
                            </v-layout>
                            <br />
                            <hr />
                            <br />
                            <v-layout>
                            <div>
                                <strong>Hijo(a) de:</strong><br />
                                <strong>Padre:</strong><span> {{feligres.bautizo.padre.primer_nombre}}
                                                                        {{feligres.bautizo.padre.segundo_nombre}}
                                                                        {{feligres.bautizo.padre.primer_apellido}}
                                                                        {{feligres.bautizo.padre.segundo_nombre}}
                                                                        </span><br />
                                <strong>Madre:</strong><span> {{feligres.bautizo.madre.primer_nombre}}
                                                                        {{feligres.bautizo.madre.segundo_nombre}}
                                                                        {{feligres.bautizo.madre.primer_apellido}}
                                                                        {{feligres.bautizo.madre.segundo_nombre}}
                                                                        </span><br />
                                </div>
                            </v-layout>
                            <br />
                            <hr />
                            <br />
                            <v-layout>
                            <div>
                                <strong>Padrinos:</strong><br />
                                <span> {{feligres.bautizo.padrino1.primer_nombre}}
                                                                        {{feligres.bautizo.padrino1.segundo_nombre}}
                                                                        {{feligres.bautizo.padrino1.primer_apellido}}
                                                                        {{feligres.bautizo.padrino1.segundo_nombre}}
                                                                        </span> Y
                                <span> {{feligres.bautizo.padrino2.primer_nombre}}
                                                                        {{feligres.bautizo.padrino2.segundo_nombre}}
                                                                        {{feligres.bautizo.padrino2.primer_apellido}}
                                                                        {{feligres.bautizo.padrino2.segundo_nombre}}
                                                                        </span><br />
                                </div>
                            </v-layout>
                        </v-container>
                    </v-card-text>
                </v-card>
            </v-flex>
            <v-flex xs12>
                
                <v-card v-if="feligres.confirmacion !== null"> 
                    <v-card-title>
                        <span class="headline">CONFIRMACION</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container grid-list-md>
                            <v-layout>
                            <div>
                                <v-btn small @click="beforePrint('C')"><v-icon>print</v-icon></v-btn><br />
                                <strong>Fecha de confirmación: </strong>{{feligres.confirmacion.fecha | moment('DD/MM/YYYY')}}<br />
                                <strong>Confirmación de:</strong><br />
                                <strong>Nombre:</strong><span> {{feligres.primer_nombre}}
                                                                        {{feligres.segundo_nombre}}
                                                                        {{feligres.primer_apellido}}
                                                                        {{feligres.segundo_nombre}}
                                                                        </span><br />
                                <strong>Fecha de nacimiento:</strong>  {{feligres.fecha_nac | moment('DD/MM/YYYY')}}<br />
                                </div>
                            </v-layout>
                            <br />
                            <hr />
                            <br />
                            <v-layout>
                            <div>
                                <strong>Hijo(a) de:</strong><br />
                                <strong>Padre:</strong><span> {{feligres.confirmacion.padre.primer_nombre}}
                                                                        {{feligres.confirmacion.padre.segundo_nombre}}
                                                                        {{feligres.confirmacion.padre.primer_apellido}}
                                                                        {{feligres.confirmacion.padre.segundo_nombre}}
                                                                        </span><br />
                                <strong>Madre:</strong><span> {{feligres.confirmacion.madre.primer_nombre}}
                                                                        {{feligres.confirmacion.madre.segundo_nombre}}
                                                                        {{feligres.confirmacion.madre.primer_apellido}}
                                                                        {{feligres.confirmacion.madre.segundo_nombre}}
                                                                        </span><br />
                                </div>
                            </v-layout>
                            <br />
                            <hr />
                            <br />
                            <v-layout>
                            <div>
                                <strong>Padrinos:</strong><br />
                                <span> {{feligres.confirmacion.padrino1.primer_nombre}}
                                                                        {{feligres.confirmacion.padrino1.segundo_nombre}}
                                                                        {{feligres.confirmacion.padrino1.primer_apellido}}
                                                                        {{feligres.confirmacion.padrino1.segundo_nombre}}
                                                                        </span> Y
                                <span> {{feligres.confirmacion.padrino2.primer_nombre}}
                                                                        {{feligres.confirmacion.padrino2.segundo_nombre}}
                                                                        {{feligres.confirmacion.padrino2.primer_apellido}}
                                                                        {{feligres.confirmacion.padrino2.segundo_nombre}}
                                                                        </span><br />
                                <strong>Monseñor:</strong>
                                <span> {{feligres.confirmacion.monsenior}}</span><br />

                                <strong>Bautizado en:</strong>
                                <span> {{feligres.confirmacion.parroquia.nombre}}</span>
                                </div>
                            </v-layout>
                        </v-container>
                    </v-card-text>
                </v-card>
            </v-flex>
            <v-flex xs12>
                <v-card v-if="feligres.matrimonio_novio.length > 0 || feligres.matrimonio_novia.length > 0">
                    <v-card-title>
                        <span class="headline">MATRIMONIO</span>
                    </v-card-title>
                    <v-card-text class="px-0" v-for="item in feligres.matrimonio_novio" :key="item.id">
                        <v-container>
                            <v-btn small @click="printMatrimonio(item.id)"><v-icon>print</v-icon></v-btn><br />
                            <strong>Fecha de matrimonio: </strong>{{item.fecha | moment('DD/MM/YYYY')}}<br />
                                <strong>Matrimonio de:</strong><span> {{feligres.primer_nombre}}
                                                                        {{feligres.segundo_nombre}}
                                                                        {{feligres.primer_apellido}}
                                                                        {{feligres.segundo_nombre}}

                                                                        con

                                                                        {{item.novia.primer_nombre}}
                                                                        {{item.novia.segundo_nombre}}
                                                                        {{item.novia.primer_apellido}}
                                                                        {{item.novia.segundo_nombre}}
                                                                        </span>
                                                                        
                                                                        <br />
                        </v-container>
                        
                    </v-card-text>
                    <v-card-text class="px-0" v-for="item in feligres.matrimonio_novia" :key="item.id">
                        <v-container>
                            <v-btn small @click="printMatrimonio(item.id)"><v-icon>print</v-icon></v-btn><br />
                        <strong>Fecha de matrimonio: </strong>{{item.fecha | moment('DD/MM/YYYY')}}<br />
                                <strong>Matrimonio de:</strong><span> {{feligres.primer_nombre}}
                                                                        {{feligres.segundo_nombre}}
                                                                        {{feligres.primer_apellido}}
                                                                        {{feligres.segundo_nombre}}

                                                                        con

                                                                        {{item.novio.primer_nombre}}
                                                                        {{item.novio.segundo_nombre}}
                                                                        {{item.novio.primer_apellido}}
                                                                        {{item.novio.segundo_nombre}}
                                                                        </span>
                                                                        
                                                                        <br />
                        </v-container>
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
    </v-flex>
  </v-layout>
</template>


<script>
import moment from 'moment'
export default {
  name: "TurnoIndex",
  components: {
    
  },
  props: {
      source: String
    },
  data() {
    return {
      search: '',
      loading: false,
      feligres: null,
      itemsB: [
        {
          text: 'FELIGRESES',
          disabled: false,
          href: '#/feligres',
        },
        {
          text: 'INFORMACION FELIGRES',
          disabled: true,
          href: '#',
        },
      ],
    };
  },

  created() {
    let self = this
    self.get(self.$route.params.id)
  },

  methods: {
    
    get(id){
        let self = this
        self.loading=true
        self.$store.state.services.feligresService
        .get(id)
        .then(r=>{
            self.loading = false
            self.feligres = r.data
            console.log(self.feligres)
        }).catch(e=>{

        })
    },

    beforePrint(tipo){
        let self = this
        if (tipo == "B"){
            self.printBautizo()
        }else{
            self.printConfirmacion()
        }
    },

    //imprimir bautizo
    printBautizo(){
      let self = this
      self.loading = true
      let data = self.bautizo
      self.$store.state.services.bautizoService
        .print(self.feligres.bautizo.id)
        .then(r => {
          self.loading = false
          if(r.response){
            this.$toastr.error(r.response.data.error, 'error')
            return
          }
          const url = window.URL.createObjectURL(new Blob([r.data], { type: 'application/pdf' }));
          const link = document.createElement('a');
          link.href = url;
          link.setAttribute('download', 'bautizo_'+self.feligres.bautizo.id); 
          //link.target = '_blank'
          link.click();
        })
        .catch(r => {});
    },

    //imprimir bautizo
    printConfirmacion(){
      let self = this
      self.loading = true
      let data = self.confirmacion
      self.$store.state.services.confirmacionService
        .print(self.feligres.confirmacion.id)
        .then(r => {
          self.loading = false
          if(r.response){
            this.$toastr.error(r.response.data.error, 'error')
            return
          }
          const url = window.URL.createObjectURL(new Blob([r.data], { type: 'application/pdf' }));
          const link = document.createElement('a');
          link.href = url;
          link.setAttribute('download', 'confirmacion_'+self.feligres.confirmacion.id); 
          //link.target = '_blank'
          link.click();
        })
        .catch(r => {});
    },

    //imprimir bautizo
    printMatrimonio(id){
      let self = this
      self.loading = true
      let data = self.matrimonio
      self.$store.state.services.matrimonioService
        .print(id)
        .then(r => {
          self.loading = false
          if(r.response){
            this.$toastr.error(r.response.data.error, 'error')
            return
          }
          const url = window.URL.createObjectURL(new Blob([r.data], { type: 'application/pdf' }));
          const link = document.createElement('a');
          link.href = url;
          link.setAttribute('download', 'matrimonio_'+id); 
          //link.target = '_blank'
          link.click();
        })
        .catch(r => {});
    },

  },

  computed: {
  },
};
</script>