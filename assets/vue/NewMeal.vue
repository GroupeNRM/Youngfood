<template>
    <div class="container-fluid">
        <ProgressionBar class="mb-4"/>
        <Food v-for="aliment in aliments" data="aliment"/>
        <div id="select-entree" class="row">
            <div class="col-md-3 food-card" v-for="aliment in aliments">
                <img class="img-fluid" v-bind:src="path + aliment.picture" v-bind:alt="aliment.title">
                <p>{{aliment.title}}</p>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from "axios";
    import ProgressionBar from "./views/newMeal/Progression-Bar";
    import Food from "./views/newMeal/Food";
    export default {
        name: "NewFood",
        components: {Food, ProgressionBar},
        data: function() {
            return {
                aliments: [],
                path: '/uploads/profile_picture/'
            }
        },
        mounted() {
            axios.get('/api/foods?page=1')
            .then(response => this.aliments = response.data['hydra:member'])
            .catch(function() {
                console.log('Erreur dans le chargement!');
            });
        },
    }
</script>

<style scoped>

</style>