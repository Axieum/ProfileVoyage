import Buefy from 'buefy';
import VeeValidate from 'vee-validate';

require('./bootstrap');

window.Vue = require('vue');

Vue.use(Buefy);
Vue.use(VeeValidate);

// Custom Messages.
const dict = {
    en: {
        custom: {
            birth_year: {
                required: 'Birth year field is required.',
                min_value: 'Birth year must be > 0.',
                max_value: 'Birth year exceeds current year!',
                integer: 'Birth year must be a number.'
            }
        }
    }
};
VeeValidate.Validator.updateDictionary(dict);

require('./main');
