/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('jquery');
require('popper.js');
require('./bootstrap');
require('pace-progress');
require('perfect-scrollbar');
require('@coreui/coreui');
require('chart.js');


window.Vue = require('vue');

import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import locale from 'element-ui/lib/locale/lang/es';

import Buefy from 'buefy'
import 'buefy/dist/buefy.css'

Vue.use(ElementUI, { locale }, Buefy);

const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('edicion-component', require('./components/EdicionPlantilla/edicion.vue').default);
Vue.component('formulario-component',require('./components/EdicionPlantilla/formularioEdicion.vue').default)
Vue.component('asignacion-component',require('./components/EdicionPlantilla/AsignarSede.vue').default);
Vue.component('inbox-component',require('./components/EdicionPlantilla/inbox.vue').default)
Vue.component('printer-component',require('./components/EdicionPlantilla/printer.vue').default)

const app = new Vue({
    el: '#main'
    
});





