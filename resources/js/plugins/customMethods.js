import {cloneDeep, merge} from 'lodash';

export default {
    install(Vue, options) {
        /**
         * @param field String
         * @param errors Array
         * @returns {Array}
         */
        Vue.prototype.$serverErrors = function (field, errors = []) {
            let serverErrors = cloneDeep(this.$page.errors[field]);
            if (!serverErrors) return errors;
            this.$page.errors[field] = null;
            merge(errors, serverErrors);
            return errors;
        };
    }
}
