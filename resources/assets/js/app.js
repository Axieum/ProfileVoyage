
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Buefy from 'buefy';
import VeeValidate from 'vee-validate';

require('./bootstrap');

window.Vue = require('vue');

Vue.use(Buefy);
Vue.use(VeeValidate);
