<template>
    <div class="container-fluid">
        <div class="row text-center justify-content-around mb-5" v-if="step === 0">
            <div class="col-md-2 clickable-date px-0" v-for="day in bookings" @click="choseDays(day)" :class="{ selected: chosenDays.includes(day)}">
                <div class="d-block">{{day.date | formatDate(day.date)}}</div>
                <div class="d-block">{{day.meal.entree.title}}</div>
                <div class="d-block">{{day.meal.maindish.title}}</div>
                <div class="d-block">{{day.meal.dessert.title}}</div>
            </div>
        </div>

        <div class="row text-center justify-content-around mb-5" v-if="step === 1">
            <h2>Choisissez l'enfant que vous souhaitez inscrire</h2>
            <div class="col-md-12">
                <div class="row">
                    <Child class="col-md-4 px-0" :childData="child" v-for="child in connectedUserChildren" :key="child.id" @click.native="choseChild(child)" :class="{ selected: chosenChild.includes(child)}"/>
                </div>
            </div>
        </div>
        <button @click="nextStep" class="btn btn-success">Suivant!</button>
    </div>
</template>

<script>
    import axios from "axios";
    import Child from "./views/ParentNewBooking/Child";

    export default {
        name: "ParentNewBooking",
        components: {
            Child,
        },
        data: function () {
            return {
                connectedUserId: undefined,
                connectedUserChildren: {},
                chosenChild: [],
                bookings: {},
                chosenDays: [],
                step: 0,
            }
        },
        computed: {
            tomorrow: function() {
                let today = new Date();
                today.setDate(today.getDate() + 1);
                return today.toLocaleDateString('us-US').split('/').join('-');
            },
        },
        filters: {
            // Filtre retournant la date au format Français
            formatDate: function(date) {
                let parts = date.match(/(\d+)/g);
                return new Date(parts[0], parts[1]-1, parts[2]).toLocaleDateString('fr-FR');
            }
        },
        mounted() {
            this.getUserId();
            this.getFiveNextBooking();
        },
        methods: {
            getUserId: function() {
                axios.get('/dashboard/user-connected')
                    .then(response => {
                        this.connectedUserId = response.data.id
                    })
                    .catch(function () {
                        let toast = this.$toasted.error("Impossible de récuperer l'ID de l'utilisateur", {
                            theme: "toasted-primary",
                            icon: "times",
                            position: "top-right",
                            duration : 3000
                        });
                    })
            },
            // Récupération de la date des prochains jours (hors week-end)
            getFiveNextBooking: function () {
                axios.get(`/api/bookings?date[after]=${this.tomorrow}&page=1`)
                    .then(response => {
                        this.bookings = response.data['hydra:member'];
                    })
                    .catch(function () {
                        let toast = this.$toasted.error("Impossible de récuperer l'ID de l'utilisateur", {
                            theme: "toasted-primary",
                            icon: "times",
                            position: "top-right",
                            duration : 3000
                        });
                    })
            },
            choseDays: function(day) {
                if(this.chosenDays.includes(day)) {
                    this.chosenDays.splice(this.chosenDays.indexOf(day), 1);
                } else {
                    this.chosenDays.push(day);
                }
            },
            choseChild: function(child) {
                if(this.chosenChild.length >= 1) {
                    this.chosenChild = [];
                    this.chosenChild.push(child);
                } else {
                    this.chosenChild.push(child);
                }
            },
            nextStep: function() {
                if(this.step === 0) {
                    if(this.chosenDays.length !== 0) {
                        this.step++;
                        this.getChildren();
                    } else {
                        let toast = this.$toasted.error("Veuillez choisir au minimum une date", {
                            theme: "toasted-primary",
                            icon: "times",
                            position: "top-right",
                            duration : 3000
                        });
                    }
                } else {
                    //envoie api
                }
            },
            getChildren: function () {
                axios.get(`/api/children?noUser=${this.connectedUserId}`)
                    .then(response => {
                        this.connectedUserChildren = response.data['hydra:member']
                    })
                    .catch(function () {
                        let toast = this.$toasted.error("Impossible de récuperer les enfants liés à l'utilisateur", {
                            theme: "toasted-primary",
                            icon: "times",
                            position: "top-right",
                            duration : 3000
                        });
                    })
            },
            sendNewUserOrder: function() {

            },
        }
    }
</script>

<style scoped>

</style>