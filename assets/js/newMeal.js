import '../scss/newMeal.scss'
import Vue from "vue";
import NewMeal from "../vue/NewMeal";

new Vue({
    components: { NewMeal },
    template: "<newMeal/>",
    // router
}).$mount("#app-new-meal");