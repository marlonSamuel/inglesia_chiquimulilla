<template>
  <v-layout align-start v-loading="loading">
    <v-flex>
      <v-toolbar flat color="white">
        <v-toolbar-title>CONFIRMACIONES </v-toolbar-title>
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

        <v-dialog v-model="dialog_info" max-width="800px" persistent>
          <v-card v-if="confirmacion !== null">
            <v-btn color="blue darken-1" flat @click="print">imprimir</v-btn>
            <v-card-title>
              <span class="headline">Información confirmación {{confirmacion.confirmado.primer_nombre}}
                                                          {{confirmacion.confirmado.segundo_nombre}}
                                                          {{confirmacion.confirmado.primer_apellido}}
                                                          {{confirmacion.confirmado.segundo_nombre}}
              </span>
            </v-card-title>
            <v-card-text>
              <v-container grid-list-md>
                <v-layout>
                  <div>
                    <strong>Confirmacion de:</strong><br />
                    <strong>Nombre:</strong><span> {{confirmacion.confirmado.primer_nombre}}
                                                            {{confirmacion.confirmado.segundo_nombre}}
                                                            {{confirmacion.confirmado.primer_apellido}}
                                                            {{confirmacion.confirmado.segundo_nombre}}
                                                              </span><br />
                    <strong>Fecha de nacimiento:</strong>  {{confirmacion.confirmado.fecha_nac | moment('DD/MM/YYYY')}}<br />
                    </div>
                </v-layout>
                <br />
                <hr />
                <br />
                <v-layout>
                  <div>
                    <strong>Hijo(a) de:</strong><br />
                    <strong>Padre:</strong><span> {{confirmacion.padre.primer_nombre}}
                                                            {{confirmacion.padre.segundo_nombre}}
                                                            {{confirmacion.padre.primer_apellido}}
                                                            {{confirmacion.padre.segundo_nombre}}
                                                              </span><br />
                    <strong>Madre:</strong><span> {{confirmacion.madre.primer_nombre}}
                                                            {{confirmacion.madre.segundo_nombre}}
                                                            {{confirmacion.madre.primer_apellido}}
                                                            {{confirmacion.madre.segundo_nombre}}
                                                              </span><br />
                    </div>
                </v-layout>
                <br />
                <hr />
                <br />
                <v-layout>
                  <div>
                    <strong>Padrinos:</strong><br />
                    <span> {{confirmacion.padrino1.primer_nombre}}
                                                            {{confirmacion.padrino1.segundo_nombre}}
                                                            {{confirmacion.padrino1.primer_apellido}}
                                                            {{confirmacion.padrino1.segundo_nombre}}
                                                              </span> Y
                    <span> {{confirmacion.padrino2.primer_nombre}}
                                                            {{confirmacion.padrino2.segundo_nombre}}
                                                            {{confirmacion.padrino2.primer_apellido}}
                                                            {{confirmacion.padrino2.segundo_nombre}}
                                                              </span><br />
                    <strong>Monseñor:</strong>
                    <span> {{confirmacion.monsenior}}</span><br />

                    <strong>Bautizado en:</strong>
                    <span> {{confirmacion.parroquia.nombre}}</span>
                    </div>
                </v-layout>
              </v-container>
            </v-card-text>
            <v-card-actions>
              <v-btn color="red darken-1" flat @click="close">Volver</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>


        <v-dialog v-model="dialog" max-width="1000px" persistent>
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
                  <v-flex xs6 sm12 md12>
                    <v-text-field type="date"
                        label="Fecha"
                        v-model="form.fecha"
                        v-validate="'required'"
                        data-vv-name="fecha"
                        :error-messages="errors.collect('fecha')">
                      </v-text-field>
                  </v-flex>
                  <v-flex xs4 sm2 md2>
                    <v-text-field v-model="form.libro" 
                        label="No libro"
                        type="text"
                        readonly>
                    </v-text-field>

                  </v-flex>
                   <v-flex xs4 sm2 md2>
                    <v-text-field v-model="form.folio" 
                        label="Folio"
                        type="text"
                        readonly>
                    </v-text-field>

                  </v-flex>
                   <v-flex xs12 sm2 md2>
                    <v-text-field v-model="form.partida" 
                        label="Partida"
                        type="text"
                        readonly>
                    </v-text-field>
                  </v-flex>
                  <v-flex xs12 sm6 md6>
                        <v-autocomplete
                            v-model="form.feligres_id"
                            label="Cofirmando a: "
                            placeholder="confirmado"
                            :items="feligreses"
                            item-text="nombre"
                            item-value="id"
                            v-validate="'required'"
                            data-vv-name="nombre"
                            :error-messages="errors.collect('nombre')"
                            >
                        </v-autocomplete>
                    </v-flex>
                    <v-flex xs12 sm6 md6>
                        <v-autocomplete
                            v-model="form.padre_id"
                            label="Padre"
                            placeholder="padre"
                            :items="feligreses"
                            item-text="nombre"
                            item-value="id"
                            v-validate="'required'"
                            data-vv-name="padre"
                            :error-messages="errors.collect('pare')"
                            >
                        </v-autocomplete>
                    </v-flex>

                    <v-flex xs12 sm6 md6>
                        <v-autocomplete
                            v-model="form.madre_id"
                            label="Madre"
                            placeholder="madre"
                            :items="feligreses"
                            item-text="nombre"
                            item-value="id"
                            v-validate="'required'"
                            data-vv-name="madre"
                            :error-messages="errors.collect('madre')"
                            >
                        </v-autocomplete>
                    </v-flex>

                    <v-flex xs12 sm6 md6>
                        <v-autocomplete
                            v-model="form.padrino1_id"
                            label="Primer padrino"
                            placeholder="primer padrino"
                            :items="feligreses"
                            item-text="nombre"
                            item-value="id"
                            v-validate="'required'"
                            data-vv-name="padrino1"
                            data-vv-as="primer padrino"
                            :error-messages="errors.collect('padrino1')"
                            >
                        </v-autocomplete>
                    </v-flex>

                    <v-flex xs12 sm6 md6>
                        <v-autocomplete
                            v-model="form.padrino2_id"
                            label="Segundo padrino"
                            placeholder="segundo padrino"
                            :items="feligreses"
                            item-text="nombre"
                            item-value="id"
                            v-validate="'required'"
                            data-vv-name="madrino2"
                            data-vv-as="segundo padrino"
                            :error-messages="errors.collect('padrino2')"
                            >
                        </v-autocomplete>
                    </v-flex>

                    <v-flex xs12 sm6 md6>
                        <v-text-field
                            v-model="form.monsenior"
                            label="Monseñor"
                            placeholder="ingrese monseñor"
                            type="text"
                            v-validate="'required'"
                            data-vv-name="monsenior"
                            :error-messages="errors.collect('monsenior')"
                            >
                        </v-text-field>
                    </v-flex>

                    <v-flex xs12 sm6 md6>
                        <v-autocomplete
                            v-model="form.parroquia_id"
                            label="Bautizado en"
                            placeholder="bautizado en"
                            :items="parroquias"
                            item-text="nombre"
                            item-value="id"
                            v-validate="'required'"
                            data-vv-name="parroquia"
                            data-vv-as="bautizado en"
                            :error-messages="errors.collect('parroquia')"
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
          <td class="text-xs-left">{{props.item.libro.no_libro}}</td>
          <td class="text-xs-left">{{props.item.folio}}</td>
          <td class="text-xs-left">{{props.item.partida}}</td>
          <td class="text-xs-left">{{props.item.confirmado.primer_nombre}}
                                   {{props.item.confirmado.segundo_nombre}}
                                   {{props.item.confirmado.primer_apellido}}
                                   {{props.item.confirmado.segundo_apellido}}
          </td>
          <td class="text-xs-left">
            <v-tooltip top>
                <template v-slot:activator="{ on }">
                    <v-icon v-on="on" color="info" fab dark @click="info(props.item)"> info</v-icon>
                </template>
                <span>Visualizar</span>
            </v-tooltip>
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
  name: "confirmacion",
  props: {
      source: String
    },
  data() {
    return {
      dialog: false,
      dialog_info: false,
      search: '',
      loading: false,
      items: [],
      feligreses: [],
      parroquias: [],
      libro: null,
      confirmacion: null,
      headers: [
        { text: 'libro', value: 'libro' },
        { text: 'folio', value: 'folio' },
        { text: 'partida', value: 'partida' },
        { text: 'confirmado', value: "confirmado.primer_nombre" },
        { text: 'Acciones', value: '', sortable: false }
      ],
      form: {
        'fecha': '',
        'libro_id':null,
        'libro':'',
        'folio':null,
        'partida':null,
        'fecha':null,
        'libro_id':null,
        'padre_id':null,
        'madre_id':null,
        'padrino1_id':null,
        'padrino2_id':null,
        'parroco_parroquia_id':null,
        'feligres_id': null,
        'monsenior': "",
        'parroquia_id': null
      },
    };
  },

  created() {
    let self = this
    self.getAll()
    self.getFeligreses()
    self.getLibros()
    self.getParroquias()
  },

  methods: {
     getAll() {
      let self = this
      self.loading = true
      self.$store.state.services.confirmacionService
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
    getFeligreses(){
        let self= this
        self.loading = true
        self.$store.state.services.feligresService
            .getAll()
            .then(r => {
                self.loading = false
                if(r.response){
                    this.$toastr.error(r.response.data.error, 'error')
                    return
                }
                r.data.map(obj=> ({ ...obj.nombre = obj.primer_nombre+' '+obj.primer_apellido}))
                self.feligreses = r.data
            }).catch(e=>{})
    },

    //obtener municipios
    getParroquias(){
        let self= this
        self.loading = true
        self.$store.state.services.parroquiaService
            .getAll()
            .then(r => {
                self.loading = false
                if(r.response){
                    this.$toastr.error(r.response.data.error, 'error')
                    return
                }
                self.parroquias = r.data
            }).catch(e=>{})
    },

    //obtener municipios
    getLibros(){
        let self= this
        self.loading = true
        self.$store.state.services.libroService
            .getAll()
            .then(r => {
                self.loading = false
                if(r.response){
                    this.$toastr.error(r.response.data.error, 'error')
                    return
                }
                self.libro = r.data.find(x=>x.tipo_libro == 'C')

                if(self.libro == null || self.libro == undefined){
                    this.$toastr.warning('no libro de confirmaciones esta lleno, por favor ingrese uno', 'advertencia')
                    self.$router.push('/libro')
                }

                if(self.libro.terminado){
                    this.$toastr.warning('libro de bautizos esta lleno, por favor ingrese otro', 'advertencia')
                    self.$router.push('/libro')
                }
                 

                if(self.libro !== null && self.libro !== undefined){
                  self.form.libro = self.libro.no_libro
                  self.form.libro_id = self.libro.id
                  self.form.folio = self.libro.partida_actual == 0 ? self.libro.folio_actual+1 : self.libro.folio_actual
                  self.form.partida = self.libro.partida_actual+1
                }
            }).catch(e=>{})
    },

    //funcion para guardar registro
    create(){
      let self = this
      self.loading = true
      let data = self.form
      console.log(data)
      self.$store.state.services.confirmacionService
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
       
      self.$store.state.services.confirmacionService
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
      self.$confirm('Seguro que desea eliminar confirmación?').then(res => {
        self.loading = true
            self.$store.state.services.confirmacionService
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

    //info bautizado
    info(data){
      let self = this
      self.confirmacion = data
      console.log(self.confirmacion)
      self.dialog_info = true
    },

    //imprimir bautizo
    print(){
      let self = this
      self.loading = true
      let data = self.confirmacion
      self.$store.state.services.confirmacionService
        .print(data.id)
        .then(r => {
          self.loading = false
          if(r.response){
            this.$toastr.error(r.response.data.error, 'error')
            return
          }
          const url = window.URL.createObjectURL(new Blob([r.data], { type: 'application/pdf' }));
          const link = document.createElement('a');
          link.href = url;
          link.setAttribute('download', 'confirmacion_'+data.id); 
          //link.target = '_blank'
          link.click();
        })
        .catch(r => {});
    },

    //mapear datos a formulario
    mapData(data){
        let self = this
        self.form.id = data.id
        self.form.padre_id = data.padre_id
        self.form.madre_id = data.madre_id
        self.form.padrino1_id = data.padrino1_id
        self.form.padrino2_id = data.padrino2_id
        self.form.feligres_id = data.feligres_id
        self.form.libro = data.libro.no_libro
        self.form.fecha = data.fecha
        self.form.libro_id = data.libro_id
        self.form.folio = data.folio
        self.form.partida = data.partida
        self.form.monsenior = data.monsenior
        self.form.parroquia_id = data.parroquia_id
    },

    //funcion, validar si se guarda o actualiza
    createOrEdit(){
        let self = this
        this.$validator.validateAll().then((result) => {
            if (result) {
                if(self.form.id > 0 && self.form.id !== null){
                    self.update()
                }else{
                    self.create()
                }
            }
        });
      
    },
    
    cancelar(){
      let self = this
    },

    close () {
        let self = this
        self.dialog = false
        self.dialog_info = false
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