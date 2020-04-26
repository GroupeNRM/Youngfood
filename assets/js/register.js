import '../scss/register.scss';

import Vue from "vue";
import RegistrationForm from "../vue/Register";
// import router from "./router";

new Vue({
    components: { RegistrationForm },
    template: "<RegistrationForm/>",
    // router
}).$mount("#registration-form");