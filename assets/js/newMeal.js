import '../scss/newMeal.scss'
import Vue from "vue";
import NewMeal from "../vue/NewMeal";
import Toasted from "vue-toasted";

Vue.use(Toasted);

new Vue({
    components: { NewMeal },
    template: "<newMeal/>",
    // router
}).$mount("#app-new-meal");