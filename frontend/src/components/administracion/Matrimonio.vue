<template>
  <v-layout align-start v-loading="loading">
    <v-flex>
      <v-toolbar flat color="white">
        <v-toolbar-title>MATRIMONIOS </v-toolbar-title>
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
          <v-card v-if="matrimonio !== null">
            <v-btn color="blue darken-1" flat @click="print">imprimir</v-btn>
            <v-card-title>
              <span class="headline">Información del matrimonio
              </span>
            </v-card-title>
            <v-card-text>
              <v-container grid-list-md>
                <v-layout>
                  <div>
                    <strong>Matrimonio de:</strong><br />
                    </div>
                </v-layout>
                <br />
                <hr />
                <br />
                <v-layout>
                  <div>
                      
                    <strong>Señor:</strong><span> {{matrimonio.novio.primer_nombre}}
                                                          {{matrimonio.novio.segundo_nombre}}
                                                          {{matrimonio.novio.primer_apellido}}
                                                          {{matrimonio.novio.segundo_nombre}} </span><br />
                    <strong>Hijo de:</strong><br />
                    <strong>Padre:</strong><span> {{matrimonio.padre_novio.primer_nombre}}
                                                            {{matrimonio.padre_novio.segundo_nombre}}
                                                            {{matrimonio.padre_novio.primer_apellido}}
                                                            {{matrimonio.padre_novio.segundo_nombre}}
                                                              </span><br />
                    <strong>Madre:</strong><span> {{matrimonio.madre_novio.primer_nombre}}
                                                            {{matrimonio.madre_novio.segundo_nombre}}
                                                            {{matrimonio.madre_novio.primer_apellido}}
                                                            {{matrimonio.madre_novio.segundo_nombre}}
                                                              </span><br /><br />
                    
                        <strong>Señora:</strong><span> {{matrimonio.novia.primer_nombre}}
                                                          {{matrimonio.novia.segundo_nombre}}
                                                          {{matrimonio.novia.primer_apellido}}
                                                          {{matrimonio.novia.segundo_nombre}} </span><br />
                    <strong>Hija de:</strong><br />
                    <strong>Padre:</strong><span> {{matrimonio.padre_novia.primer_nombre}}
                                                            {{matrimonio.padre_novia.segundo_nombre}}
                                                            {{matrimonio.padre_novia.primer_apellido}}
                                                            {{matrimonio.padre_novia.segundo_nombre}}
                                                              </span><br />
                    <strong>Madre:</strong><span> {{matrimonio.madre_novia.primer_nombre}}
                                                            {{matrimonio.madre_novia.segundo_nombre}}
                                                            {{matrimonio.madre_novia.primer_apellido}}
                                                            {{matrimonio.madre_novia.segundo_nombre}}
                                                              </span><br />
                    </div>
                </v-layout>
                <br />
                <hr />
                <br />
              </v-container>
            </v-card-text>
            <v-card-actions>
              <v-btn color="red darken-1" flat @click="close">Volver</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>


        <v-dialog v-model="dialog" max-width="1000px" persistent>
          <template v-slot:activator="{ on }">
            <v-btn color="primary" small dark class="mb-2" v-on="on" @click="newMat" ><v-icon>add</v-icon> Nuevo</v-btn>
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

                  <v-flex sm12 md12 lg12>

                  <v-text-field
                    v-model="form.testigos"
                    label="Testigos"
                    placeholder="ingrese testigos"
                    v-validate="'required'"
                    data-vv-name="testigos"
                    :error-messages="errors.collect('testigos')"
                  >
                      
                  </v-text-field>
                  </v-flex>

                  <el-divider></el-divider>
                    DATOS DEL NOVIO
                  <el-divider></el-divider>
                  <v-flex xs12 sm6 md6>
                        <v-autocomplete
                            v-model="form.novio_id"
                            label="Novio"
                            placeholder="novio"
                            :items="feligreses"
                            item-text="nombre"
                            item-value="id"
                            v-validate="'required'"
                            data-vv-name="novio"
                            :error-messages="errors.collect('novio')"
                            >
                        </v-autocomplete>
                    </v-flex>

                    <v-flex xs12 sm6 md6>
                        <v-autocomplete
                            v-model="form.parroquia_novio_id"
                            label="feligres de"
                            placeholder="matrimonio en"
                            :items="parroquias"
                            item-text="nombre"
                            item-value="id"
                            v-validate="'required'"
                            data-vv-name="parroquia"
                            data-vv-as="feligres de"
                            :error-messages="errors.collect('parroquia_novio')"
                            >
                        </v-autocomplete>
                    </v-flex>

                    <v-flex xs12 sm6 md6>
                        <v-autocomplete
                            v-model="form.padre_novio_id"
                            label="Padre novio"
                            placeholder="padre novio"
                            :items="feligreses"
                            item-text="nombre"
                            item-value="id"
                            v-validate="'required'"
                            data-vv-name="padre_novio"
                            data-vv-as="padre del novio"
                            :error-messages="errors.collect('padre_novio')"
                            >
                        </v-autocomplete>
                    </v-flex>

                    <v-flex xs12 sm6 md6>
                        <v-autocomplete
                            v-model="form.madre_novio_id"
                            label="Madre novio"
                            placeholder="madre novio"
                            :items="feligreses"
                            item-text="nombre"
                            item-value="id"
                            v-validate="'required'"
                            data-vv-name="madre_novio"
                            data-vv-as="madre del novio"
                            :error-messages="errors.collect('madre_novio')"
                            >
                        </v-autocomplete>
                    </v-flex>

                    <el-divider></el-divider>
                    DATOS DE LA NOVIA
                  <el-divider></el-divider>
                  <v-flex xs12 sm6 md6>
                        <v-autocomplete
                            v-model="form.novia_id"
                            label="Novia"
                            placeholder="novia"
                            :items="feligreses"
                            item-text="nombre"
                            item-value="id"
                            v-validate="'required'"
                            data-vv-name="novia"
                            :error-messages="errors.collect('novia')"
                            >
                        </v-autocomplete>
                    </v-flex>

                    <v-flex xs12 sm6 md6>
                        <v-autocomplete
                            v-model="form.parroquia_novia_id"
                            label="feligres de"
                            placeholder="feligres de"
                            :items="parroquias"
                            item-text="nombre"
                            item-value="id"
                            v-validate="'required'"
                            data-vv-name="parroquia_novia"
                            data-vv-as="parroquia novia"
                            :error-messages="errors.collect('parroquia_novia')"
                            >
                        </v-autocomplete>
                    </v-flex>

                    <v-flex xs12 sm6 md6>
                        <v-autocomplete
                            v-model="form.padre_novia_id"
                            label="Padre novia"
                            placeholder="padre novia"
                            :items="feligreses"
                            item-text="nombre"
                            item-value="id"
                            v-validate="'required'"
                            data-vv-name="padre_novia"
                            data-vv-as="padre de la novia"
                            :error-messages="errors.collect('padre_novia')"
                            >
                        </v-autocomplete>
                    </v-flex>

                    <v-flex xs12 sm6 md6>
                        <v-autocomplete
                            v-model="form.madre_novia_id"
                            label="Madre novia"
                            placeholder="madre novia"
                            :items="feligreses"
                            item-text="nombre"
                            item-value="id"
                            v-validate="'required'"
                            data-vv-name="madre_novia"
                            data-vv-as="madre de la novia"
                            :error-messages="errors.collect('madre_novia')"
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
          <td class="text-xs-left">{{props.item.novio.primer_nombre}}
                                   {{props.item.novio.segundo_nombre}}
                                   {{props.item.novio.primer_apellido}}
                                   {{props.item.novio.segundo_apellido}}

          <td class="text-xs-left">{{props.item.novia.primer_nombre}}
                                   {{props.item.novia.segundo_nombre}}
                                   {{props.item.novia.primer_apellido}}
                                   {{props.item.novia.segundo_apellido}}
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
  name: "matrimonio",
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
      matrimonio: null,
      headers: [
        { text: 'libro', value: 'libro' },
        { text: 'folio', value: 'folio' },
        { text: 'partida', value: 'partida' },
        { text: 'señor', value: 'novio' },
        { text: 'señora', value: 'novia' },
        { text: 'Acciones', value: '', sortable: false }
      ],
      form: {
        'fecha': '',
        'libro_id':null,
        'libro':'',
        'folio':null,
        'partida':null,
        'novio_id': null,
        'novia_id': null,
        'fecha':null,
        'libro_id':null,
        'padre_novio_id':null,
        'madre_novio_id':null,
        'padre_novia_id':null,
        'madre_novia_id':null,
        'parroco_parroquia_id':null,
        'parroquia_novia_id': null,
        'parroquia_novio_id': null,
        'testigos':''
      },
    };
  },

  created() {
    let self = this
    self.getAll()
    self.getFeligreses()
    self.getParroquias()
  },

  methods: {
     getAll() {
      let self = this
      self.loading = true
      self.$store.state.services.matrimonioService
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
                self.libro = r.data.find(x=>x.tipo_libro == 'M')

                if(self.libro == null || self.libro == undefined){
                    this.$toastr.warning('no existe libro de matrimonios, por favor ingrese uno', 'advertencia')
                    self.$router.push('/libro')
                }

                if(self.libro.terminado){
                    this.$toastr.warning('libro de bautizos esta lleno, por favor ingrese otro', 'advertencia')
                    self.$router.push('/libro')
                }
                 

                if(self.libro !== null && self.libro !== undefined){
                  self.form.libro = self.libro.no_libro
                  self.form.libro_id = self.libro.id
                  self.form.folio = self.libro.partida_actual == 0 & self.libro.folio_actual == 0 ? self.libro.folio_actual+1 : self.libro.folio_actual
                  self.form.partida = self.libro.partida_actual+1
                }
            }).catch(e=>{})
    },

    newMat(){
      let self = this
      self.dialog = true
      self.getLibros()
    },

    //funcion para guardar registro
    create(){
      let self = this
      self.loading = true
      let data = self.form
      console.log(data)
      self.$store.state.services.matrimonioService
        .create(data)
        .then(r => {
          self.loading = false
          if(self.$store.state.global.captureError(r)){
            return
          }
          this.$toastr.success('registro agregado con éxito', 'éxito')
          self.getAll()
          self.clearData()
          self.dialog = false
        })
        .catch(r => {});
    },
    //funcion para actualizar registro
    update(){
      let self = this
      self.loading = true
      let data = self.form
       
      self.$store.state.services.matrimonioService
        .update(data)
        .then(r => {
          self.loading = false
          if(self.$store.state.global.captureError(r)){
            return
          }
          self.getAll()
          this.$toastr.success('registro actualizado con éxito', 'éxito')
          self.clearData()
          self.dialog = false
        })
        .catch(r => {});
    },

    //funcion para eliminar registro
    destroy(data){
      let self = this
      self.$confirm('Seguro que desea eliminar matrimonio?').then(res => {
        self.loading = true
            self.$store.state.services.matrimonioService
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

    //info matrimonio
    info(data){
      let self = this
      self.matrimonio = data
      console.log(self.matrimonio)
      self.dialog_info = true
    },

    //imprimir bautizo
    print(){
      let self = this
      self.loading = true
      let data = self.matrimonio
      self.$store.state.services.matrimonioService
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
          link.setAttribute('download', 'matrimonio_'+data.id); 
          //link.target = '_blank'
          link.click();
        })
        .catch(r => {});
    },

    //mapear datos a formulario
    mapData(data){
        let self = this
        self.form.id = data.id
        self.form.novio_id = data.novio_id
        self.form.novia_id = data.novia_id
        self.form.padre_novio_id = data.padre_novio_id
        self.form.madre_novio_id = data.madre_novia_id
        self.form.madre_novia_id = data.madre_novia_id
        self.form.padre_novia_id = data.madre_novia_id
        self.form.libro = data.libro.no_libro
        self.form.fecha = data.fecha
        self.form.libro_id = data.libro_id
        self.form.folio = data.folio
        self.form.partida = data.partida
        self.form.parroquia_novio_id = data.parroquia_novio_id
        self.form.parroquia_novia_id = data.parroquia_novia_id
        self.form.testigos = data.testigos
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