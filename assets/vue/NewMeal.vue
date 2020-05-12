<template>
    <div class="container">
        <div id="select-entree" v-for="aliment in aliments">
            <p>{{aliment.title}}</p>
            <img v-bind:src="path + aliment.picture" v-bind:alt="aliment.title">
        </div>
    </div>
</template>

<script>
    import axios from "axios";
    export default {
        name: "NewFood",
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