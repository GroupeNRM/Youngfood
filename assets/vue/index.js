import Vue from "vue";
import RegistrationForm from "./Register";
// import router from "./router";

new Vue({
    components: { RegistrationForm },
    template: "<RegistrationForm/>",
    // router
}).$mount("#registration-form");