<template>
    <div class="dashboard">
        <h5>Aujourd'hui :</h5>
        <div class="grey-bg rounded mb-3">
            <div class="row meal-day mx-1 py-4" v-for="daily in dailyMeal" v-if="dailyMeal">
                <span class="kcal-indicator">{{randomKcal}} <span class="little-text">Kcal</span></span>
                <div class="col-md-4 food-card">
                    <div class="img-thumb pb-1">
                        <img class="img-fluid" :src="path + daily.meal.entree.picture" alt="">
                        <span class="like-button">+1</span>
                    </div>
                    <h5>{{daily.meal.entree.title}}</h5>
                </div>
                <div class="col-md-4 food-card">
                    <div class="img-thumb pb-1">
                        <img :src="path + daily.meal.maindish.picture" alt="">
                        <span class="like-button">+1</span>
                    </div>
                    <h5>{{daily.meal.maindish.title}}</h5>
                </div>
                <div class="col-md-4 food-card">
                    <div class="img-thumb pb-1">
                        <img :src="path + daily.meal.dessert.picture" alt="">
                        <span class="like-button">+1</span>
                    </div>
                    <h5>{{daily.meal.dessert.title}}</h5>
                </div>
            </div>
            <div class="row" v-else>
                <div class="col-md-12">
                    Pas d'information concernant le repas à venir
                </div>
            </div>
        </div>

        <h5>Demain :</h5>
        <div class="grey-bg rounded">
            <div class="row meal-day mx-1 py-4" v-for="aftermeal in afterTomorrowMeal" v-if="afterTomorrowMeal">
                <span class="kcal-indicator">{{randomKcal2}} <span class="little-text">Kcal</span></span>
                <div class="col-md-4 food-card">
                    <div class="img-thumb pb-1">
                        <img class="img-fluid" :src="path + aftermeal.meal.entree.picture" alt="">
                        <span class="like-button">+1</span>
                    </div>
                    <h5>{{aftermeal.meal.entree.title}}</h5>
                </div>
                <div class="col-md-4 food-card">
                    <div class="img-thumb pb-1">
                        <img :src="path + aftermeal.meal.maindish.picture" alt="">
                        <span class="like-button">+1</span>
                    </div>
                    <h5>{{aftermeal.meal.maindish.title}}</h5>
                </div>
                <div class="col-md-4 food-card">
                    <div class="img-thumb pb-1">
                        <img :src="path + aftermeal.meal.dessert.picture" alt="">
                        <span class="like-button">+1</span>
                    </div>
                    <h5>{{aftermeal.meal.dessert.title}}</h5>
                </div>
            </div>
            <div class="row" v-else>
                <div class="col-md-12">
                    Pas d'information concernant le repas à venir
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from "axios";

    export default {
        name: "Dashboard",
        data: function(){
            return {
                dailyMeal: {},
                afterTomorrowMeal: {},
                path: '/uploads/food_picture/', // Aide vue pour trouver les images
            }
        },
        mounted() {
            this.getDailyMeal();
            this.getTomorrowMeal();
        },
        computed: {
            today: function() {
                return new Date().toLocaleDateString('us-US').split('/').join('-');
            },
            tomorrow: function() {
                let today = new Date();
                today.setDate(today.getDate() + 1);
                return today.toLocaleDateString('us-US').split('/').join('-');
            },
            afterTomorrow: function() {
                let today = new Date();
                today.setDate(today.getDate() + 2);
                return today.toLocaleDateString('us-US').split('/').join('-');
            },
            randomKcal: function () {
                let min = 820;
                let max = 950;
                return Math.round(Math.random() * (max - min) + min);
            },
            randomKcal2: function () {
                let min = 820;
                let max = 950;
                return Math.round(Math.random() * (max - min) + min);
            },
        },
        methods: {
            // Récupère le repas d'aujourd'hui
            getDailyMeal: function () {
                axios.get(`/api/bookings/?date[strictly_before]=${this.tomorrow}&date[strictly_after]=${this.today}`)
                    .then((response) => {
                        this.dailyMeal = response.data['hydra:member'];
                    })
                    .catch(function() {
                        console.log('Erreur dans le chargement des repas liés aux réservations!');
                    });
            },
            // Récupère le repas de demain
            getTomorrowMeal: function () {
                axios.get(`/api/bookings/?date[strictly_before]=${this.afterTomorrow}&date[strictly_after]=${this.tomorrow}`)
                    .then((response) => {
                        this.afterTomorrowMeal = response.data['hydra:member'];
                    })
                    .catch(function() {
                        console.log('Erreur dans le chargement des repas d\'après demain!');
                    });
            }
        }
    }
</script>

<style scoped>

</style>