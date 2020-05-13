<template>
    <div class="container-fluid">
        <ProgressionBar class="mb-4"/>

        <button @click="next" class="btn btn-success">{{this.btnText}}</button>

        <div id="select-entree" class="row">
            <Food class="mb-4" v-for="aliment in aliments" :key="aliment.id" :data="aliment" :path="path"/>
        </div>
    </div>
</template>

<script>
    import axios from "axios";
    import ProgressionBar from "./views/newMeal/Progression-Bar";
    import Food from "./views/newMeal/Food";

    export default {
        name: "NewMeal",
        components: {Food, ProgressionBar},
        data: function() {
            return {
                aliments: [],
                path: '/uploads/food_picture/', // Aide vue pour trouver les images
                step: 0,
                btnText: 'Suivant',
                activeChoice: undefined
            }
        },
        mounted() {
            // Lorsque le composant est monté, lance un appel vers l'API pour récuperer les entrées
            this.loadEntree();
        },
        methods: {
            next: function () {
                if(this.activeChoice !== undefined) {
                    if(this.step === 0) {
                        this.loadPlatPrincipaux();
                    } else if(this.step === 1) {
                        this.loadDessert();
                    }
                } else {
                    let toast = this.$toasted.show("Merci de faire un choix!", {
                        theme: "toasted-primary",
                        position: "top-right",
                        duration : 3000
                    });
                }
            },
            loadEntree: function () {
                axios.get('/api/food?category=E&page=1')
                    .then(response => this.aliments = response.data['hydra:member'])
                    .catch(function() {
                        console.log('Erreur dans le chargement!');
                    });
                console.log(this.step);
            },
            loadPlatPrincipaux: function () {
                axios.get('/api/food?category=P&page=1')
                    .then(response => this.aliments = response.data['hydra:member'])
                    .catch(function() {
                        console.log('Erreur dans le chargement!');
                    });
                this.step++;
                console.log(this.step);
            },
            loadDessert: function () {
                axios.get('/api/food?category=D&page=1')
                    .then(response => {
                        this.aliments = response.data['hydra:member'];
                        this.btnText = 'Finaliser';
                    })
                    .catch(function() {
                        console.log('Erreur dans le chargement!');
                    });
                this.step++;
                this.btnText = 'Finaliser'
                console.log(this.step);
            },
            setActive(index) {
                this.activeChoice = index;
            }
        }
    }
</script>

<style scoped>

</style>