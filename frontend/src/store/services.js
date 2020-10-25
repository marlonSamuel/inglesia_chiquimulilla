import Axios from 'axios'
import VueCookies from 'vue-cookies'
import store from './index'
import auth from '../auth'
import moment from 'moment'
import { isNullOrUndefined } from 'util';

import exampleService from '../services/ExampleService'
import LoginService from '../services/LoginService'
import UsuarioService from '../services/UsuarioService'
import ParrocoService from '../services/ParrocoService'
import MunicipioService from '../services/MunicipioService'
import ParroquiaService from '../services/ParroquiaService'
import LibroService from '../services/LibroService'
import FeligresService from '../services/FeligresService'
import BautizoService from '../services/BautizoService'
import ConfirmacionService from '../services/ConfirmacionService'
import MatrimonioService from '../services/MatrimonioService'
import DashboardService from '../services/DashboardService'
import RolService from '../services/RolService'


//let baseUrl = 'http://www.iglesia.com/' //base url desarrollo
let baseUrl = 'http://207.154.253.69/iglesia/' //url production
let token_data = $cookies.get('token_data')

// Axios Configuration
Axios.defaults.headers.common.Accept = 'application/json'
if (token_data !== null) {
    Axios.defaults.headers.common.Authorization = `Bearer ${token_data.access_token}`
}

const instance = Axios.create();
Axios.interceptors.response.use(response => {
    return response
}, error => {
    if (error.response.status === 401) {
        var token_data = $cookies.get('token_data')
        if (isNullOrUndefined(token_data)) { return error }
        var original_request = error.config
        return refreshToken().then(res => {
            auth.saveToken(res.data)
            original_request.headers['Authorization'] = 'Bearer ' + res.data.access_token
            return Axios.request(original_request)
        })
    }

    return error
});

function refreshToken() {
    var data = auth.getRefreshToken()
    return new Promise(function(resolve, reject) {
        instance.post(baseUrl + 'oauth/token', data)
            .then(r => {
                resolve(r)
            }).catch(e => {
                reject(r)
            })
    })
}

instance.interceptors.response.use(response => {
    return response
}, error => {
    if (error.response.status === 401) {
        auth.noAcceso()
    }

    return error
});


export default {
    exampleService: new exampleService(Axios),
    loginService: new LoginService(Axios, baseUrl),
    usuarioService: new UsuarioService(Axios, baseUrl),
    parrocoService: new ParrocoService(Axios,baseUrl),
    municipioService: new MunicipioService(Axios,baseUrl),
    parroquiaService: new ParroquiaService(Axios,baseUrl),
    libroService: new LibroService(Axios,baseUrl),
    feligresService: new FeligresService(Axios,baseUrl),
    bautizoService: new BautizoService(Axios,baseUrl),
    confirmacionService: new ConfirmacionService(Axios,baseUrl),
    matrimonioService: new MatrimonioService(Axios,baseUrl),
    dashboardService: new DashboardService(Axios,baseUrl),
    rolService: new RolService(Axios,baseUrl)
}