import '../scss/newBooking.scss'
import Vue from "vue";
import NewBooking from "../vue/NewBooking";

new Vue({
    components: { NewBooking },
    template: "<new-booking/>",
    // router
}).$mount("#app-new-booking");