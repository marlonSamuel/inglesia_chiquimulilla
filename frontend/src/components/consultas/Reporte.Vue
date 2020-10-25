<template>
  <v-layout align-start v-loading="loading">
    <v-flex>
      
      <v-container grid-list-md>
          <v-flex>
              
          <v-layout row wrap>
              <v-card>
            <v-card-title>
              <span class="headline">REPORTES DE ACTIVIDADES</span>
            </v-card-title>
  
            <v-card-text>
              <v-container grid-list-md>
                <v-layout>
                    <v-flex xs12 sm3 md3>
                        <v-text-field
                        v-model="form.from"
                        type="date"
                        label="Fecha inicio">
                        </v-text-field>
                    </v-flex>
                     <v-flex xs12 sm3 md3>
                        <v-text-field
                        v-model="form.to"
                        type="date"
                        label="Fecha fin">
                        </v-text-field>
                    </v-flex>
                  
                  <v-flex xs12 sm3 md3>
                        <v-autocomplete
                            v-model="form.tipo_libro"
                            label="Seleccione tipo actividad"
                            :items="tipo_libros"
                            v-validate="'required'"
                            data-vv-name="libro"
                            :error-messages="errors.collect('libro')"
                            
                        >
                        </v-autocomplete>
                    </v-flex>
                    <v-flex xs12 sm3 md3>
                        <v-btn color="blue darken-1" flat @click="validate"><v-icon>print</v-icon>imprimir</v-btn>
                    </v-flex>

                    
                </v-layout>
              </v-container>
            </v-card-text>

          </v-card>
          </v-layout>
          </v-flex>
      </v-container>
    </v-flex>
  </v-layout>
</template>

<script>
export default {
  name: "parroco",
  props: {
      source: String
    },
  data() {
    return {
      loading: false,
      tipo_libros: [
         {text: "Bautizos",value:'B'},
         {text: "Confirmaciones", value: "C"},
         {text: "Matrimonios", value: "M"}
      ],
      form: {
        from: "",
        to: "",
        tipo_libro: '',
      },
    };
  },

  created() {
    let self = this
  },

  methods: {
      //funcion, validar si se guarda o actualiza
    validate(){
        let self = this
        let from = 0
        let to = 0
        if(self.form.from !== "" && self.form.to !== ""){
            from = self.form.from
            to = self.form.to
        }
        if(self.form.from > self.form.to){
            self.$toastr.error('la fecha fin debe se mayor que la fecha de inicio')
            return
        }
        this.$validator.validateAll().then((result) => {
            if (result) {
                if(self.form.tipo_libro == "B"){
                    self.printBautizo(from,to)
                }else if(self.form.tipo_libro == "C"){
                    self.printConfirmacion(from,to)
                }else{
                    self.printMatrimonio(from,to)
                }
            }
        })
    },

    //imprimir bautizo
    printBautizo(from,to){
      let self = this
      self.loading = true
      let data = self.bautizo
      self.$store.state.services.bautizoService
        .printAll(from,to)
        .then(r => {
          self.loading = false
          if(r.response){
            this.$toastr.error(r.response.data.error, 'error')
            return
          }
          const url = window.URL.createObjectURL(new Blob([r.data], { type: 'application/pdf' }));
          const link = document.createElement('a');
          link.href = url;
          link.setAttribute('download', 'bautizos'); 
          //link.target = '_blank'
          link.click();
        })
        .catch(r => {});
    },

     //imprimir bautizo
    printConfirmacion(from,to){
      let self = this
      self.loading = true
      let data = self.bautizo
      self.$store.state.services.confirmacionService
        .printAll(from,to)
        .then(r => {
          self.loading = false
          if(r.response){
            this.$toastr.error(r.response.data.error, 'error')
            return
          }
          const url = window.URL.createObjectURL(new Blob([r.data], { type: 'application/pdf' }));
          const link = document.createElement('a');
          link.href = url;
          link.setAttribute('download', 'confirmaciones'); 
          //link.target = '_blank'
          link.click();
        })
        .catch(r => {});
    },

     //imprimir bautizo
    printMatrimonio(from,to){
      let self = this
      self.loading = true
      let data = self.bautizo
      self.$store.state.services.matrimonioService
        .printAll(from,to)
        .then(r => {
          self.loading = false
          if(r.response){
            this.$toastr.error(r.response.data.error, 'error')
            return
          }
          const url = window.URL.createObjectURL(new Blob([r.data], { type: 'application/pdf' }));
          const link = document.createElement('a');
          link.href = url;
          link.setAttribute('download', 'matrimonios'); 
          //link.target = '_blank'
          link.click();
        })
        .catch(r => {});
    },


  },

  computed: {
    setTitle(){
      let self = this
      return self.form.id !== null ? 'actualizar' : 'Nuevo Registro'
    }
  },
};
</script>