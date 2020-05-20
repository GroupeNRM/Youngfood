import '../scss/newBooking.scss';
import Vue from "vue";
import ParentNewBooking from "../vue/ParentNewBooking";

new Vue({
    components: { ParentNewBooking },
    template: "<ParentNewBooking/>",
    // router
}).$mount("#app-parent-new-booking");