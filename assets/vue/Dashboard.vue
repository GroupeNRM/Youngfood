<template>
    <div class="dashboard">
        <div class="grey-bg rounded">
            <div class="row meal-day mx-1 py-4" v-for="daily in dailyMeal">
                <span class="kcal-indicator">{{randomKcal}} <span class="little-text">Kcal</span></span>
                <div class="col-md-4 food-card">
                    <div class="img-thumb">
                        <img class="img-fluid" :src="path + daily.meal.entree.picture" alt="">
                    </div>


                    {{daily.meal.entree.title}}
                </div>
                <div class="col-md-4 food-card">
                    <div class="img-thumb">
                        <img :src="path + daily.meal.maindish.picture" alt="">
                    </div>
                    {{daily.meal.maindish.title}}
                </div>
                <div class="col-md-4 food-card">
                    <div class="img-thumb">
                        <img :src="path + daily.meal.dessert.picture" alt="">
                    </div>
                    {{daily.meal.dessert.title}}
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
                path: '/uploads/food_picture/', // Aide vue pour trouver les images
            }
        },
        mounted() {
            this.getDailyMeal();
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
            randomKcal: function () {
                let min = 820;
                let max = 950;
                return Math.round(Math.random() * (max - min) + min);
            }
        },
        methods: {
            getDailyMeal: function () {
                axios.get(`/api/bookings/?date[strictly_before]=${this.tomorrow}&date[strictly_after]=${this.today}`)
                    .then((response) => {
                        this.dailyMeal = response.data['hydra:member'];
                    })
                    .catch(function() {
                        console.log('Erreur dans le chargement des repas liés aux réservations!');
                    });
            }
        }
    }
</script>

<style scoped>

</style>