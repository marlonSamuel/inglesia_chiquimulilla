<template>
  <v-layout align-start v-loading="loading">
    <v-flex>
      <v-toolbar flat color="white">
        <v-toolbar-title>PARROCOS </v-toolbar-title>
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
                  <v-flex xs6 sm6 md6>
                    <v-text-field v-model="form.numero" 
                        label="Numero"
                        v-validate="'required'"
                        type="text"
                        data-vv-name="numero"
                        :error-messages="errors.collect('numero')">
                    </v-text-field>
                  </v-flex>

                  <v-flex xs6 sm6 md6>
                    <v-text-field v-model="form.primer_nombre" 
                        label="Primer nombre"
                        v-validate="'required'"
                        type="text"
                        data-vv-name="primer_nombre"
                        data-vv-as="primer nombre"
                        :error-messages="errors.collect('primer_nombre')">
                    </v-text-field>
                  </v-flex>

                  <v-flex xs6 sm6 md6>
                    <v-text-field v-model="form.segundo_nombre" 
                        label="Segundo nombre"
                        type="text">
                    </v-text-field>
                  </v-flex>

                  <v-flex xs6 sm6 md6>
                    <v-text-field v-model="form.primer_apellido" 
                        label="Primer apellido"
                        v-validate="'required'"
                        type="text"
                        data-vv-name="primer_apellido"
                        data-vv-as="primer apellido"
                        :error-messages="errors.collect('primer_apellido')">
                    </v-text-field>
                  </v-flex>

                  <v-flex xs6 sm6 md6>
                    <v-text-field v-model="form.segundo_apellido" 
                        label="Segundo apellido"
                        type="text">
                    </v-text-field>
                  </v-flex>

                    <v-flex xs12 sm6 md6>
                        <v-autocomplete
                            v-model="form.municipio_id"
                            label="Departamento / Municipio"
                            placeholder="Departamento / Municipio"
                            :items="municipios"
                            item-text="nombre"
                            item-value="id"
                            >
                        </v-autocomplete>
                    </v-flex>

                    <v-flex xs12 sm12 md12>
                    <v-text-field v-model="form.direccion" 
                        label="Direccion"
                        type="text">
                    </v-text-field>

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
          <td class="text-xs-left">{{ props.item.numero }}</td>
          <td class="text-xs-left">{{ props.item.primer_nombre }} {{ props.item.segundo_nombre }}
                                   {{ props.item.primer_apellido }} {{ props.item.segundo_apellido }}</td>
          <td class="text-xs-left">{{ props.item.direccion }} {{ props.item.municipio.nombre }} {{ props.item.municipio.departamento.nombre }}</td>
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
      headers: [
        { text: 'numero', value: 'numero' },
        { text: 'nombre', value: 'nombre' },
        { text: 'direccion', value: 'direccion' },
        { text: 'Acciones', value: '', sortable: false }
      ],
      form: {
        id: null,
        numero: '',
        primer_nombre: '',
        segundo_nombre: '',
        primer_apellido: '',
        segundo_apellido: '',
        direccion: '',
        municipio_id: null
      },
    };
  },

  created() {
    let self = this
    self.getAll()
    self.getMunicipios()
  },

  methods: {
     getAll() {
      let self = this
      self.loading = true
      self.$store.state.services.parrocoService
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

    //obtener municipios
    getMunicipios(){
        let self= this
        self.loading = true
        self.$store.state.services.municipioService
            .getAll()
            .then(r => {
                self.loading = false
                if(r.response){
                    this.$toastr.error(r.response.data.error, 'error')
                    return
                }
                r.data.map(obj=> ({ ...obj.nombre = obj.departamento.nombre+' / '+obj.nombre }))
                self.municipios = r.data
            }).catch(e=>{})
    },
    //funcion para guardar registro
    create(){
      let self = this
      self.loading = true
      let data = self.form
      self.$store.state.services.parrocoService
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
       
      self.$store.state.services.parrocoService
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
      self.$confirm('Seguro que desea eliminar parrco '+ data.numero+'?').then(res => {
        self.loading = true
            self.$store.state.services.parrocoService
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
        self.form.primer_nombre = data.primer_nombre
        self.form.segundo_nombre = data.segundo_nombre
        self.form.primer_apellido = data.primer_apellido
        self.form.segundo_apellido = data.segundo_apellido
        self.form.numero = data.numero
        self.form.direccion = data.direccion
        self.form.municipio_id = data.municipio_id
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
      return self.form.id !== null ? self.form.nombre : 'Nuevo Registro'
    }
  },
};
</script>