import '../scss/dashboard.scss';
import Vue from "vue";
import Toasted from "vue-toasted";
import Notification from "../vue/Notification";
import Chart from 'chart.js';

import $ from 'jquery';

require('popper.js')
require('bootstrap')

global.$ = global.jQuery = $

Vue.use(Toasted, {
    iconPack: 'fontawesome'
});

new Vue({
    components: { Notification },
    template: "<Notification/>",
    // router
}).$mount("#notification");

new Chart(document.getElementById("myChart"), {
    type: 'line',
    data: {
        labels: [2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020],
        datasets: [{
            data: [86, 114, 106, 106, 107, 111, 133, 221, 783, 2478],
            label: "Grenoble",
            borderColor: "#3e95cd",
            fill: false
        }, {
            data: [282, 350, 411, 502, 635, 809, 947, 1402, 3700, 5267],
            label: "Lyon",
            borderColor: "#8e5ea2",
            fill: false
        }, {
            data: [168, 170, 178, 190, 203, 276, 408, 547, 675, 734],
            label: "Saint Martin D'Hères",
            borderColor: "#3cba9f",
            fill: false
        }, {
            data: [40, 20, 10, 16, 24, 38, 74, 167, 508, 784],
            label: "Fontaine",
            borderColor: "#e8c3b9",
            fill: false
        }, {
            data: [6, 3, 2, 2, 7, 26, 82, 172, 312, 433],
            label: "Meylan",
            borderColor: "#c45850",
            fill: false
        }
        ]
    },
    options: {
        title: {
            display: true,
            text: 'Visite du site par an (2019 / 2020)'
        }
    }
});