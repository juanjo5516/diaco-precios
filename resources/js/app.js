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
import 'vue-select/dist/vue-select.css';



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
Vue.component('vaciado-component',require('./components/EdicionPlantilla/vaciado.vue').default)
Vue.component('clon-component',require('./components/EdicionPlantilla/clonar.vue').default)
Vue.component('propano-component',require('./components/Propano/addPropano.vue').default)
Vue.component('historico-component',require('./components/EdicionPlantilla/historico.vue').default)
Vue.component('table-category', require('./components/catalogos/category.vue').default)
Vue.component('content-product', require('./components/catalogos/product.vue').default)
Vue.component('content-subcategory', require('./components/catalogos/subcategory.vue').default)
Vue.component('content-measure', require('./components/catalogos/measure.vue').default)
Vue.component('content-market', require('./components/catalogos/market.vue').default)
Vue.component('content-local', require('./components/catalogos/local.vue').default)
Vue.component('content-smarket', require('./components/lugares/SuperMercado.vue').default)
Vue.component('pdf-componente', require('./components/pdf/generateData.vue').default)
Vue.component('sidebar-componente', require('./components/sidebar/sidebar.vue').default)
Vue.component('visitas-componente', require('./components/catalogos/typeVisit.vue').default)
Vue.component('editarplantilla-componente', require('./components/EdicionPlantilla/editarPlantilla.vue').default)

Vue.component('usuario-component', require('./components/EdicionPlantilla/UsuarioSistema.vue').default);
Vue.component('export-component', require('./components/exportacion/export.vue').default);
Vue.component('preview-component', require('./components/exportacion/preview.vue').default);
Vue.component('ausuario-component', require('./components/EdicionPlantilla/ausuario.vue').default);
Vue.component('submit-component', require('./components/EdicionPlantilla/submitPreview.vue').default)
Vue.component('authorize-component', require('./components/exportacion/authorize.vue').default);
Vue.component('updateprices-component', require('./components/exportacion/updateprices.vue').default);



Vue.component('api-component', require('./components/api/api.vue').default);
const app = new Vue({
    el: '#main'
});





