
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import swal from 'sweetalert';
require('./bootstrap');

window.Vue = require('vue');
window.axios = require('axios');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Vue.component('employees-component', require('./components/EmployeesComponent.vue'));
Vue.component('clients-component', require('./components/ClientsComponent.vue'));
Vue.component('providers-component', require('./components/ProvidersComponent.vue'));
Vue.component('products-component', require('./components/ProductsComponent.vue'));
Vue.component('user-products-component', require('./components/UserProductsComponent.vue'));
Vue.component('categories-component', require('./components/CategoriesComponent.vue'));
Vue.component('manufacturers-component', require('./components/ManufacturersComponent.vue'));
Vue.component('stocks-component', require('./components/StocksComponent.vue'));
Vue.component('purchases-create-component', require('./components/PurchaseCreateComponent.vue'));
Vue.component('purchases-component', require('./components/PurchaseComponent.vue'));
Vue.component('sales-component', require('./components/SalesComponent.vue'));
Vue.component('notifications-component', require('./components/NotificationsComponent.vue'));
Vue.component('sales-create-component', require('./components/SalesCreateComponent.vue'));
Vue.component('list-sales-component', require('./components/ListSalesComponent.vue'));
Vue.component('list-clients-component', require('./components/ListCLientsComponent.vue'));
Vue.component('modal-edit-component', require('./components/UserEditFormComponent.vue'));

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key)))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});
