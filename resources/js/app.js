/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// import vuetify
import vuetify from './vuetify'
//support vuex
import Vuex from 'vuex'
Vue.use(Vuex)
import storeData from "./store/index"
const store = new Vuex.Store(
   storeData
)
// notification
import VueNotification from '@mathieustan/vue-notification';
Vue.use(VueNotification, {
    theme: {
      colors: {
        success: '#54d861',
        darkenSuccess: '#2d8e36',
        info: '#5d6a89',
        darkenInfo: '#535f7b',
        warning: '#f8a623',
        darkenWarning: '#f69a07',
        error: '#ff4577',
        darkenError: '#ff245f',
        offline: '#ff4577',
        darkenOffline: '#ff245f',
      },
      boxShadow: '2px 2px 20px black',
    },
    breakpoints: {
      0: {
        bottom: true,
      },
      480: {
        top: true,
        right: true,
      },
    },
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Components
Vue.component('app-layout', require('./components/layouts/App.vue').default);
Vue.component('dash-layout', require('./components/layouts/Dash.vue').default);
// views
Vue.component('home-page', require('./components/views/HomePage.vue').default);
Vue.component('catalog-page', require('./components/views/CatalogPage.vue').default);
Vue.component('single-product', require('./components/views/SinglePage.vue').default);
Vue.component('admin-page', require('./components/views/AdminPage.vue').default);
Vue.component('cart-page', require('./components/views/CartPage.vue').default);
Vue.component('checkout-page', require('./components/views/CheckoutPage.vue').default);
// admin
Vue.component('admin-products', require('./components/admin/AdminProducts.vue').default);
Vue.component('admin-offers', require('./components/admin/AdminOffers.vue').default);
Vue.component('admin-sales', require('./components/admin/AdminSales.vue').default);
Vue.component('admin-orders', require('./components/admin/AdminOrders.vue').default);
Vue.component('admin-settings', require('./components/admin/AdminSettings.vue').default);
// ** //products
Vue.component('admin-add', require('./components/admin/products/Add.vue').default);
Vue.component('admin-edit', require('./components/admin/products/Edit.vue').default);
Vue.component('admin-categories', require('./components/admin/products/Categories.vue').default);
Vue.component('admin-attributes', require('./components/admin/products/Attributes.vue').default);
// ** //offers
Vue.component('admin-add-offer', require('./components/admin/offers/Add.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    vuetify,
    store, //vuex
    el: '#app',
});