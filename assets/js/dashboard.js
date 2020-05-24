import '../scss/dashboard.scss';
import Vue from "vue";
import Dashboard from "../vue/Dashboard";

new Vue({
    components: { Dashboard },
    template: "<Dashboard/>"
}).$mount("#app-dashboard");