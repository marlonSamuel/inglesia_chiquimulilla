import Vue from 'vue'
import Router from 'vue-router'
import store from '../store/index'
import multiguard from 'vue-router-multiguard'

import Default from '@/components/Default'
import ExampleIndex from '@/components/example/Index'
import Login from '@/components/login/Index'
import CambiarContrasenia from '@/components/accesos/CambiarContrasenia'

import Usuario from '@/components/accesos/Usuario'

import Parroco from '@/components/catalogos/Parroco'
import Parroquia from '@/components/catalogos/Parroquia'
import Libro from '@/components/catalogos/Libro'
import Feligres from '@/components/catalogos/Feligres'
import FeligresInfo from '@/components/catalogos/FeligresInfo'

import Bautizo from '@/components/administracion/Bautizo'
import Confirmacion from '@/components/administracion/Confirmacion'
import Matrimonio from '@/components/administracion/Matrimonio'
import Reporte from '@/components/consultas/Reporte'

Vue.use(Router)

//validar authenticacion
const isLoggedIn = (to, from, next) => {
    return store.state.is_login ? next() : next('/login')
}

const isLoggedOut = (to, from, next) => {
    return store.state.is_login ? next('/') : next()
}

const routes = [
    { path: '*', redirect: '/' },
    { path: '/', name: 'Default', component: Default, beforeEnter: multiguard([isLoggedIn]) },
    { path: '/example_index', name: 'ExampleIndex', component: ExampleIndex, beforeEnter: multiguard([isLoggedIn]) },
    { path: '/login', name: 'Login', component: Login, beforeEnter: multiguard([isLoggedOut]) },
    { path: '/change_password', name: 'CambiarContrasenia', component: CambiarContrasenia, beforeEnter: multiguard([isLoggedIn]) },
    { path: '/usuario', name: 'Usuario', component: Usuario, beforeEnter: multiguard([isLoggedIn]) },
    { path: '/parroco', name: 'Parroco', component: Parroco, beforeEnter: multiguard([isLoggedIn])},
    { path: '/parroquia', name: 'Parroquia', component: Parroquia, beforeEnter: multiguard([isLoggedIn])},
    { path: '/libro', name: 'Libro', component: Libro, beforeEnter: multiguard([isLoggedIn])},
    { path: '/feligres', name: 'Feligres', component: Feligres, beforeEnter: multiguard([isLoggedIn])},
    { path: '/bautizo', name: 'Bautizo', component: Bautizo, beforeEnter: multiguard([isLoggedIn])},
    { path: '/confirmacion', name: 'Confirmacion', component: Confirmacion, beforeEnter: multiguard([isLoggedIn])},
    { path: '/matrimonio', name: 'Matrimonio', component: Matrimonio, beforeEnter: multiguard([isLoggedIn])},
    { path: '/feligres_info/:id', name: 'FeligresInfo', component: FeligresInfo, beforeEnter: multiguard([isLoggedIn])},
    { path: '/reporte', name: 'Reporte', component: Reporte, beforeEnter: multiguard([isLoggedIn])}
]


const router = new Router({ routes })

export default router