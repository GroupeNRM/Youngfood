<template>
    <div class="container-fluid">
        <ProgressionBar class="mb-4"/>

        <button @click="next" class="btn btn-success">{{this.btnText}}</button>

        <div id="select-entree" class="row" v-if="!isLoading">
            <Food class="mb-4" v-for="aliment in aliments" :key="aliment.id" :data="aliment" :path="path"/>
        </div>

        <div v-else>
            <div class="row">
                <div class="col-md-3 food-card" v-for="n in 12">
                    <content-loader width='426' height='230'>
                        <rect x="4" y="1" rx="15" ry="15" width="354" height="190" />
                        <rect x="8" y="196" rx="15" ry="15" width="351" height="18" />
                    </content-loader>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from "axios";
    import ProgressionBar from "./views/newMeal/Progression-Bar";
    import Food from "./views/newMeal/Food";
    import { ContentLoader } from "vue-content-loader"

    export default {
        name: "NewMeal",
        components: {
            Food,
            ProgressionBar,
            ContentLoader
        },
        data: function() {
            return {
                aliments: [],
                path: '/uploads/food_picture/', // Aide vue pour trouver les images
                step: 0,
                btnText: 'Suivant',
                activeChoice: undefined,
                isLoading: true,
            }
        },
        mounted() {
            // Lorsque le composant est monté, lance un appel vers l'API pour récuperer les entrées
            this.loadEntree();
        },
        methods: {
            // Permet de passer à une nouvelle étape
            next: function () {
                if(this.activeChoice !== undefined) {
                    if(this.step === 0) {
                        this.loadPlatsPrincipaux();
                        document.getElementById('step1').classList.remove("is-active");
                        document.getElementById('step2').classList.add('is-active');
                    } else if(this.step === 1) {
                        this.loadDessert();
                        document.getElementById('step2').classList.remove("is-active");
                        document.getElementById('step3').classList.add('is-active');
                    } else if(this.step === 2) {
                        document.getElementById('step3').classList.remove("is-active");
                        document.getElementById('step4').classList.add('is-active');
                    }
                } else {
                    let toast = this.$toasted.show("Merci de faire un choix!", {
                        theme: "toasted-primary",
                        position: "top-right",
                        duration : 3000
                    });
                }
            },
            // Charge les entrées en AJAX
            loadEntree: function () {
                this.isLoading = true;
                axios.get('/api/food?category=E&page=1')
                    .then(response => this.aliments = response.data['hydra:member'])
                    .catch(function() {
                        console.log('Erreur dans le chargement!');
                    })
                    .finally(() => {
                        this.isLoading = false;
                    });
            },

            // Charge les plats principaux en AJAX
            loadPlatsPrincipaux: function () {
                this.isLoading = true;
                axios.get('/api/food?category=P&page=1')
                    .then(response => this.aliments = response.data['hydra:member'])
                    .catch(function() {
                        console.log('Erreur dans le chargement!');
                    })
                    .finally(() => {
                        this.isLoading = false;
                        this.step++;
                    });
            },

            // Charge les desserts en AJAX
            loadDessert: function () {
                this.isLoading = true;
                axios.get('/api/food?category=D&page=1')
                    .then(response => {
                        this.aliments = response.data['hydra:member'];
                        this.btnText = 'Finaliser';
                    })
                    .catch(function() {
                        console.log('Erreur dans le chargement!');
                    })
                    .finally(() => {
                        this.isLoading = false;
                        this.step++;
                        this.btnText = 'Finaliser'
                    });
            },

            // Permet de selectionner un aliment dans l'étape actuelle
            setActive(index) {
                this.activeChoice = index;
            }
        }
    }
</script>

<style scoped>

</style>