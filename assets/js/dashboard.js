import '../scss/dashboard.scss';
import Vue from "vue";
import Toasted from "vue-toasted";
import Notification from "../vue/Notification";

Vue.use(Toasted, {
    iconPack: 'fontawesome'
});

new Vue({
    components: { Notification },
    template: "<Notification/>",
    // router
}).$mount("#notification");