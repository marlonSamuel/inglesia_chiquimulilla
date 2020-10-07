<template>
  <v-layout align-start v-loading="loading">
    <v-flex>
      <v-toolbar flat color="white">
        <v-toolbar-title>PARROQUIAS </v-toolbar-title>
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
                    <v-text-field v-model="form.nombre" 
                        label="Nombre"
                        v-validate="'required'"
                        type="text"
                        data-vv-name="nombre"
                        :error-messages="errors.collect('nombre')">
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
                            data-vv-name="municipio"
                            v-validate="'required'"
                            :error-messages="errors.collect('municipio')"
                            >
                        </v-autocomplete>
                    </v-flex>

                    <v-flex xs12 sm12 md12>
                        <v-text-field v-model="form.direccion" 
                            label="Direccion"
                            type="text">
                        </v-text-field>
                    </v-flex>

                    <v-flex xs12 sm6 md6 v-if="!form.nuevo">
                        <v-autocomplete
                            slot="parroco_selection"
                            v-model="form.parroco_id"
                            label="Seleccione parroco"
                            :items="parrocos"
                            item-value="id"
                            item-text="fullname"
                        >
                        </v-autocomplete>
                    </v-flex>

                    <v-flex xs12 sm6 md6 v-if="form.id === null">
                    <v-switch
                      v-model="form.nuevo"
                      :label="`nuevo: ${form.nuevo ?'Si':'No'}`"
                    ></v-switch>
                  </v-flex>
                  
                </v-layout>

                <v-layout wrap v-if="form.nuevo">
                    <el-divider></el-divider>
                    DATOS DEL PARROCO
                    <el-divider></el-divider>
                  <v-flex xs6 sm6 md6>
                    <v-text-field v-model="form.parroco.numero" 
                        label="Numero"
                        v-validate="'required'"
                        type="text"
                        data-vv-name="numero"
                        :error-messages="errors.collect('numero')">
                    </v-text-field>
                  </v-flex>

                  <v-flex xs6 sm6 md6>
                    <v-text-field v-model="form.parroco.primer_nombre" 
                        label="Primer nombre"
                        v-validate="'required'"
                        type="text"
                        data-vv-name="primer_nombre"
                        data-vv-as="primer nombre"
                        :error-messages="errors.collect('primer_nombre')">
                    </v-text-field>
                  </v-flex>

                  <v-flex xs6 sm6 md6>
                    <v-text-field v-model="form.parroco.segundo_nombre" 
                        label="Segundo nombre"
                        type="text">
                    </v-text-field>
                  </v-flex>

                  <v-flex xs6 sm6 md6>
                    <v-text-field v-model="form.parroco.primer_apellido" 
                        label="Primer apellido"
                        v-validate="'required'"
                        type="text"
                        data-vv-name="primer_apellido"
                        data-vv-as="primer apellido"
                        :error-messages="errors.collect('primer_apellido')">
                    </v-text-field>
                  </v-flex>

                  <v-flex xs6 sm6 md6>
                    <v-text-field v-model="form.parroco.segundo_apellido" 
                        label="Segundo apellido"
                        type="text">
                    </v-text-field>
                  </v-flex>

                    <v-flex xs12 sm6 md6>
                        <v-autocomplete
                            v-model="form.parroco.municipio_id"
                            label="Departamento / Municipio"
                            placeholder="Departamento / Municipio"
                            :items="municipios"
                            item-text="nombre"
                            item-value="id"
                            data-vv-name="municipio_parroco"
                            v-validate="'required'"
                            :error-messages="errors.collect('municipio_parroco')"
                            >
                        </v-autocomplete>
                    </v-flex>

                    <v-flex xs12 sm12 md12>
                    <v-text-field v-model="form.parroco.direccion" 
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
          <td class="text-xs-left">{{ props.item.nombre }}</td>
          <td class="text-xs-left">{{ props.item.parroco.parroco.primer_nombre }} {{ props.item.parroco.parroco.segundo_nombre }}
                                   {{ props.item.parroco.parroco.primer_apellido }} {{ props.item.parroco.parroco.segundo_apellido }}</td>
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
  name: "parroquia",
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
      parrocos: [],
      headers: [
        { text: 'nombre', value: 'nombre' },
        { text: 'parroco actual', value: 'parroco' },
        { text: 'direccion', value: 'direccion' },
        { text: 'Acciones', value: '', sortable: false }
      ],
      form: {
        id: null,
        nombre: null,
        municipio_id: null,
        direccion: '',
        nuevo: false,
        parroco: {
            numero: '',
            primer_nombre: '',
            segundo_nombre: '',
            primer_apellido: '',
            segundo_apellido: '',
            municipio_id: null,
            direccion: ''
        }
        
      },
    };
  },

  created() {
    let self = this
    self.getAll()
    self.getMunicipios()
    self.getParrocos()
  },

  methods: {
     getAll() {
      let self = this
      self.loading = true
      self.$store.state.services.parroquiaService
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

    //obtener parrocos
    getParrocos(){
        let self = this
        self.loading = true
        self.$store.state.services.parrocoService
        .getAll()
        .then(r=>{
            self.loading = false
            r.data.map(obj=> ({ ...obj.fullname = obj.primer_nombre+' '+obj.primer_apellido}))
            self.parrocos = r.data
        }).catch(e=>{})
    },
    //funcion para guardar registro
    create(){
      let self = this
      self.loading = true
      let data = self.form
      self.$store.state.services.parroquiaService
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
       
      self.$store.state.services.parroquiaService
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
      self.$confirm('Seguro que desea eliminar parrco '+ data.nombre+'?').then(res => {
        self.loading = true
            self.$store.state.services.parroquiaService
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
            self.form[key] = false
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
        self.form.nombre = data.nombre
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