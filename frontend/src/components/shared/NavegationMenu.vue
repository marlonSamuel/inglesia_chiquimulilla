<template v-loading="loading">
<div>
<v-navigation-drawer
      v-model="drawer"
      :clipped="$vuetify.breakpoint.lgAndUp"
      fixed
      app
      class="grey lighten-4"
    >
      <v-list dense class="grey lighten-4">
        <template>
          <v-list-tile :to="'/'">
            <v-list-tile-action>
              <v-icon>home</v-icon>
            </v-list-tile-action>
            <v-list-tile-title to="/">
               Inicio
            </v-list-tile-title>
          </v-list-tile>
        </template>
        <template v-for="item in items">
          <v-list-group 
          v-if="item.children"
          :prepend-icon="item.icon"> 
            <v-list-tile slot="activator">
              <v-list-tile-content>
                <v-list-tile-title>   
                  {{item.text}}
                </v-list-tile-title>
              </v-list-tile-content>
            </v-list-tile>
            <template v-for="child in item.children">
              <v-list-tile :to="child.path">
                <v-list-tile-action>
                  <v-icon>{{child.icon}}</v-icon>
                </v-list-tile-action>
                <v-list-tile-title>
                  {{child.text}}
                </v-list-tile-title>
              </v-list-tile>
            </template>
          </v-list-group>

          <v-list-tile v-else @click="">
            <v-list-tile-action>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-tile-action>

            <v-list-tile-content>
              <v-list-tile-title>{{ item.text }}</v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>

        </template>
      </v-list>
    </v-navigation-drawer>
    <v-toolbar
      :clipped-left="$vuetify.breakpoint.lgAndUp"
      color="amber"
      dark
      app
      fixed
      dense
    >
      <v-toolbar-title style="width: 300px" class="ml-0 pl-3">
        <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
        <span class="hidden-sm-and-down" @click="$router.push(`/`)">
          <v-avatar
          :tile="false"
          size="45"
          color="grey lighten-4"
        >
          <img :src="logo" alt="avatar">
        </v-avatar>
        SICOBCM
        </span>
      </v-toolbar-title>
      <v-spacer></v-spacer>
      <h2 class="hidden-sm-and-down">PARROQUIA SANTA CRUZ CHIQUIMULILLA</h2>
      <v-spacer></v-spacer>
      
      {{userName}}

      <v-menu offset-y origin="center center" :nudge-bottom="10" transition="scale-transition">
        <v-btn icon large flat slot="activator">
          <v-avatar size="30px">
            <v-btn icon>
       <v-icon>account_circle</v-icon>
      </v-btn>
          </v-avatar>
      </v-btn>
        <v-list class="pa-0">
          <v-list-tile
            v-for="(item, index) in options"
            :to="!item.href ? { name: item.name } : null"
            :href="item.href"
            @click="item.click"
            ripple="ripple"
            :disabled="item.disabled"
            :target="item.target"
            rel="noopener"
            :key="index"
          >
            <v-list-tile-action v-if="item.icon">
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>{{ item.title }}</v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
        </v-list>
      </v-menu>
    </v-toolbar>
</div>
</template>
<script>
export default {
  name: 'navigation_menu',
  props: {
      source: String
    },
  data(){
    return {
        dialog: false,
        drawer: null,
        loading: false,
        logo: this.$store.state.global.getLogo(),
        options: [
        {
          icon: "account_circle",
          href: "",
          title: "Cambiar contraseña",
          click: this.change
        },
        {
          icon: "logout",
          href: "",
          title: "salir",
          click: this.logout
        }
      ],

      items: [{
            icon: 'settings',
            text: 'Catalogos',
            name: 'Catalogos',
            model: true,
            path: '',
            children: [
                { name: 'Parroco', icon: 'add', text: 'Parrocos', path: '/parroco' },
                { name: 'Parroquia', icon: 'add', text: 'Parroquias', path: '/parroquia' },
                { name: 'Libros', icon: 'add', text: 'Libros', path: '/libro' },
                { name: 'Feligres', icon: 'add', text: 'Feligreses', path: '/feligres' }
            ]
        },
        {
            icon: 'settings',
            text: 'Administracion',
            name: 'Administracion',
            model: true,
            path: '',
            children: [
                { name: 'Bautizo', icon: 'add', text: 'Bautizos', path: '/bautizo' },
                { name: 'Confirmacion', icon: 'add', text: 'Confirmaciones', path: '/confirmacion' },
                { name: 'Matrimonio', icon: 'add', text: 'Matrimonios', path: '/matrimonio' }
            ]
        },

        {
            icon: 'supervised_user_circle',
            text: 'Acceso',
            name: 'Acceso',
            model: true,
            path: '',
            children: [
                { name: 'Usuario', icon: 'add', text: 'usuarios', path: '/usuario' }
            ]
        },

        {
            icon: 'file_copy',
            text: 'Consultas',
            name: 'reporte',
            model: true,
            path: '',
            children: [
                { name: 'Reporte', icon: 'add', text: 'Reporte', path: '/reporte' }
            ]
        },

    ],
    }
  },

  created(){
    let self = this
  },

  methods: {
    logout(){
      let self = this
      self.loading = true
      self.$store.state.services.loginService
        .logout()
        .then(r => {
          self.$store.dispatch("logout")
          self.$router.push('/login')
          self.loading = false
        }).catch(e => {

      })
    },

    change(){
      let self = this
      self.$router.push('/change_password')
    },
  },

  computed: {
    userName(){
      let self = this
      return self.$store.state.usuario.name
    },
    ciclo(){
      return this.$store.state.ciclo
    }
  }
}
</script>