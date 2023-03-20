
window.Vue = require('vue').default;

Vue.component('enrollments', require('./components/Enrollments.vue').default);
Vue.config.productionTip = false;

const app = new Vue({
    el: '#app',
}).$mount('#app');
