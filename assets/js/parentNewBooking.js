import '../scss/newBooking.scss';
import Vue from "vue";
import ParentNewBooking from "../vue/ParentNewBooking";
import Toasted from "vue-toasted";

// Utilisation des toasts (notifications)
Vue.use(Toasted, {
    iconPack: 'fontawesome'
});

new Vue({
    components: { ParentNewBooking },
    template: "<ParentNewBooking/>",
    // router
}).$mount("#app-parent-new-booking");