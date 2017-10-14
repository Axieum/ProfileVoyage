import Buefy from 'buefy';
import VeeValidate from 'vee-validate';

require('./bootstrap');

window.Vue = require('vue');

Vue.use(Buefy);
Vue.use(VeeValidate);

require('./main');
