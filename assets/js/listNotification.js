import '../scss/listNotification.scss'
import Vue from "vue";
import ListNotification from "../vue/ListNotification";

new Vue({
    components: { ListNotification },
    template: "<list-notification/>",
    // router
}).$mount("#app-list-notification");