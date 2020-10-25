<template>
  <v-layout v-loading="loading" grid-list-md>
      <v-layout wrap v-if="data !== null">
        <v-flex xs6 md4 sm4 lg4>
          <v-card
            class="mx-auto"
            color="grey lighten-4"
            max-width="600"
          >
            <v-card-title>
              <v-icon large color="green darken-2" class="mr-5" size="64">person_pin</v-icon>
              <v-layout
                column
                align-start
              >
                <div class="caption grey--text text-uppercase">
                  TOTAL FELIGRESES
                </div>
                <div>
                  <span
                    class="display font-weight-black"
                    v-text="data.feligreses"
                  ></span>
                  <strong>FELIGRESES</strong>
                </div>
              </v-layout>

              <v-spacer></v-spacer>
            </v-card-title>
          </v-card>
        </v-flex>

        <v-flex xs6 md4 sm4 lg4>
          <v-card
            class="mx-auto"
            color="grey lighten-4"
            max-width="600"
          >
            <v-card-title>
              <v-icon large color="green darken-2" class="mr-5" size="64">person_pin</v-icon>
              <v-layout
                column
                align-start
              >
                <div class="caption grey--text text-uppercase">
                  TOTAL PARROQUIAS
                </div>
                <div>
                  <span
                    class="display font-weight-black"
                    v-text="data.parroquias"
                  ></span>
                  <strong>PARROQUIAS</strong>
                </div>
              </v-layout>

              <v-spacer></v-spacer>
            </v-card-title>
          </v-card>
        </v-flex>

        <v-flex xs6 md4 sm4lg4>
          <v-card
            class="mx-auto"
            color="grey lighten-4"
            max-width="600"
          >
            <v-card-title>
              <v-icon large color="green darken-2" class="mr-5" size="64">person_pin</v-icon>
              <v-layout
                column
                align-start
              >
                <div class="caption grey--text text-uppercase">
                  TOTAL LIBROS
                </div>
                <div>
                  <span
                    class="display font-weight-black"
                    v-text="data.libros"
                  ></span>
                  <strong>LIBROS</strong>
                </div>
              </v-layout>

              <v-spacer></v-spacer>
            </v-card-title>
          </v-card>
        </v-flex>
        <el-divider></el-divider>
        <v-flex xs12 md8 lg8>
          <div>
            <actividades></actividades>
          </div>
        </v-flex>
      </v-layout>

      
  </v-layout>
</template>

<script>

import actividades from './dashboard/Actividades'
export default {
  name: "default",
  components: {
    actividades
  },
  props: {
      source: String
    },
  data() {
    return {
      loading: false,
      data: null
    };
  },

  created() {
    let self = this
    self.getData()
  },

  methods: {
    getData(){
        let self = this
        self.loading = true
        self.$store.state.services.dashboardService
        .getAll()
        .then(r => {
            self.loading = false
            if(r.response !== undefined){
              self.$toastr.error(r.response.data.error, 'error')
              return
            }
            self.data = r.data
            self.$nextTick(()=>{
              events.$emit('resumen_actividades',self.data.actividades)
            })
            
        }).catch(e => {

        })
    }
  },

  computed: {
    logo(){
      let self = this
      return self.$store.state.global.getLogo()
    }
  },
};
</script>