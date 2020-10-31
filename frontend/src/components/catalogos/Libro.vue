<template>
  <v-layout align-start v-loading="loading">
    <v-flex>
      <v-toolbar flat color="white">
        <v-toolbar-title>LIBROS </v-toolbar-title>
        <v-divider
          class="mx-2"
          inset
          vertical
        ></v-divider><v-spacer></v-spacer>
          <v-text-field
            v-model="search"
            append-icon="search"
            label="Buscar"
            single-line
            hide-details
          ></v-text-field>
        <v-spacer></v-spacer>
        <v-dialog v-model="dialog" max-width="800px">
          <template v-slot:activator="{ on }">
            <v-btn color="primary" small dark class="mb-2" v-on="on"><v-icon>add</v-icon> Nuevo</v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="headline">{{setTitle}}</span>
            </v-card-title>
  
            <v-card-text>
              <v-container grid-list-md>
                <v-layout wrap>
                  <v-flex xs6 sm4 md4>
                    <v-text-field v-model="form.no_folios" 
                        label="Numero de folios"
                        v-validate="'required'"
                        type="text"
                        data-vv-name="folios"
                        :error-messages="errors.collect('folios')">
                    </v-text-field>
                  </v-flex>

                  <v-flex xs6 sm4 md4>
                    <v-text-field v-model="form.partidas" 
                        label="Partidas por folio"
                        v-validate="'required'"
                        type="text"
                        data-vv-name="partidas"
                        :error-messages="errors.collect('partidas')">
                    </v-text-field>
                  </v-flex>
                  <v-flex xs12 sm4 md4>
                        <v-autocomplete
                            v-model="form.tipo_libro"
                            label="Seleccione tipo libro"
                            :items="tipo_libros"
                        >
                        </v-autocomplete>
                    </v-flex>
                </v-layout>
              </v-container>
            </v-card-text>
  
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="red darken-1" flat @click="close">Volver</v-btn>
              <v-btn color="blue darken-1" flat @click="createOrEdit">Guardar</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
      <v-data-table
        :headers="headers"
        :items="items"
        :search="search"
        class="elevation-1"
      >
        <template v-slot:items="props">
          <td class="text-xs-left">{{props.item.no_libro}}</td>
          <td class="text-xs-left">{{ props.item.tipo_libro == 'M' ?'Matrimonios': props.item.tipo_libro == 'B' ? 'Bautizos':"Confirmaciones" }}</td>
          <td class="text-xs-left">{{ props.item.no_folios }}</td>
          <td class="text-xs-left">{{ props.item.partidas }}</td>
          <td class="text-xs-left">{{ props.item.folio_actual }}</td>
          <td class="text-xs-left">{{ props.item.partida_actual }}</td>
          <td class="text-xs-left">{{ props.item.terminado ?'Terminado': 'Habilitado' }}</td>
          <td class="text-xs-left">
              <v-tooltip top>
                <template v-slot:activator="{ on }">
                    <v-icon v-on="on"  color="warning" fab dark @click="edit(props.item)"> edit</v-icon>
                </template>
                <span>Editar</span>
            </v-tooltip>
            <v-tooltip top>
                <template v-slot:activator="{ on }">
                    <v-icon v-on="on" color="error" fab dark @click="destroy(props.item)"> delete</v-icon>
                </template>
                <span>Eliminar</span>
            </v-tooltip>
          </td>
        </template>
        <template v-slot:no-data>
          <v-btn color="primary" @click="getAll">Reset</v-btn>
        </template>
      </v-data-table>
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
      dialog: false,
      search: '',
      loading: false,
      items: [],
      municipios: [],
      tipo_libros: [
         {text: "Bautizos",value:'B'},
         {text: "Confirmaciones", value: "C"},
         {text: "Matrimonios", value: "M"}
      ],
      headers: [
          { text: '#', value: '#' },
          { text: 'Libro', value: 'tipo_libro' },
        { text: 'Numero folios', value: 'no_folios' },
        { text: 'Partidas', value: 'no_partidas' },
        { text: 'Folio actual', value: 'folio_actual' },
        { text: 'Partida actual', value: 'partida_actual' },
        { text: 'terminado', value: 'terminado' },
        { text: 'Acciones', value: '', sortable: false }
      ],
      form: {
        id: null,
        no_folios: null,
        no_partidas: 3,
        folio_actual: 0,
        tipo_libro: '',
        partida_actual: 0
      },
    };
  },

  created() {
    let self = this
    self.getAll()
  },

  methods: {
     getAll() {
      let self = this
      self.loading = true
      self.$store.state.services.libroService
        .getAll()
        .then(r => {
          self.loading = false
          if(self.$store.state.global.captureError(r)){
            return
          }
          self.items = r.data
        })
        .catch(r => {});
    },

    //funcion para guardar registro
    create(){
      let self = this
      self.loading = true
      let data = self.form
      self.$store.state.services.libroService
        .create(data)
        .then(r => {
          self.loading = false
          if(self.$store.state.global.captureError(r)){
            return
          }
          this.$toastr.success('registro agregado con éxito', 'éxito')
          self.getAll()
          self.clearData()
        })
        .catch(r => {});
    },
    //funcion para actualizar registro
    update(){
      let self = this
      self.loading = true
      let data = self.form
       
      self.$store.state.services.libroService
        .update(data)
        .then(r => {
          self.loading = false
          if(self.$store.state.global.captureError(r)){
            return
          }
          self.getAll()
          this.$toastr.success('registro actualizado con éxito', 'éxito')
          self.clearData()
        })
        .catch(r => {});
    },

    //funcion para eliminar registro
    destroy(data){
      let self = this
      self.$confirm('Seguro que desea eliminar libro?').then(res => {
        self.loading = true
            self.$store.state.services.libroService
            .destroy(data)
            .then(r => {
                self.loading = false
                if(self.$store.state.global.captureError(r)){
                    return
                }
                self.getAll()
                this.$toastr.success('registro eliminado con exito', 'exito')
                self.clearData()
            })
            .catch(r => {});
      }).catch(cancel =>{
      })
    },
    //limpiar data de formulario
    clearData(){
        let self = this
        Object.keys(self.form).forEach(function(key,index) {
          if(typeof self.form[key] === "string") 
            self.form[key] = ''
          else if (typeof self.form[key] === "boolean") 
            self.form[key] = true
          else if (typeof self.form[key] === "number") 
            self.form[key] = null
        });
        self.$validator.reset()
        self.form.folio_actual = 0
        self.form.partida_actual = 0
    },
    //editar registro
    edit(data){
        let self = this
        this.dialog = true
        self.mapData(data)   
    },
    //mapear datos a formulario
    mapData(data){
        let self = this
        self.form.id = data.id
        self.form.no_folios = data.no_folios
        self.form.partidas = data.partidas
        self.form.tipo_libro = data.tipo_libro
    },

    //funcion, validar si se guarda o actualiza
    createOrEdit(){
      this.$validator.validateAll().then((result) => {
          if (result) {
              if(self.form.id > 0 && self.form.id !== null){
                self.update()
              }else{
                self.create()
              }
           }
      });
      let self = this
    },
    
    cancelar(){
      let self = this
    },

    close () {
        let self = this
        self.dialog = false
        self.clearData()
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