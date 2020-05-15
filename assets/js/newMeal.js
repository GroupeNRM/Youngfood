import '../scss/newMeal.scss'
import Vue from "vue";
import NewMeal from "../vue/NewMeal";
import Toasted from "vue-toasted";

// Utilisation des toasts (notifications)
Vue.use(Toasted, {
    iconPack: 'fontawesome'
});

new Vue({
    components: { NewMeal },
    template: "<newMeal/>",
    // router
}).$mount("#app-new-meal");