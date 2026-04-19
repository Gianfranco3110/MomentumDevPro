import 'core-js/stable'
import Vue from 'vue'
import VueSweetalert2 from 'vue-sweetalert2';
import App from './App'
import { iconsSet as icons } from './assets/icons/icons.js';
import router from './router'
import CoreuiVue from '@coreui/vue'
import store from './store'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'sweetalert2/src/sweetalert2.scss'
import Vuelidate from 'vuelidate';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import VueToastr2 from 'vue-toastr-2'
import 'vue-toastr-2/dist/vue-toastr-2.min.css'
 import 'toastr/build/toastr.min.css'

window.toastr = require('toastr')
export const EventBus = new Vue();

Vue.prototype.$bus = new Vue();

//Local
//Vue.prototype.$apiAdress = 'http://127.0.0.1:8000'

//PRD
Vue.prototype.$apiAdress = 'https://yari.yariestilospmu.com'

Vue.config.performance = true
Vue.use(CoreuiVue)
Vue.use(VueSweetalert2)
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(Vuelidate);
Vue.use(VueToastr2)
Vue.use(EventBus)

Vue.component('loading-overlay', Loading);

new Vue({
  el: '#app',
  router,
  store,  
  icons,
  template: '<App/>',
  components: {
    App
  },
})