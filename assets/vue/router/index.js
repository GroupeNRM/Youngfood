import Vue from "vue";
import VueRouter from "vue-router";
import Card from "../views/register/Card";

Vue.use(VueRouter);

export default new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/register",
            component: Card
        },
    ]
})