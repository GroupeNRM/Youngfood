<template>
    <div class="container-fluid">

        <ProgressionBar class="mt-4 mb-4"/>

        <div v-if="!final">
            <button @click="next" class="btn btn-success">Suivant</button>

            <div id="select-entree" class="row" v-if="!isLoading">
                <Food class="mb-4" v-for="aliment in aliments" :key="aliment.id" :data="aliment" :path="path"/>
            </div>

            <div v-else>
                <div class="row">
                    <div class="col-md-3 food-card" v-for="n in 12" :key="n">
                        <content-loader width='426' height='230'>
                            <rect x="4" y="1" rx="15" ry="15" width="354" height="190" />
                            <rect x="8" y="196" rx="15" ry="15" width="351" height="18" />
                        </content-loader>
                    </div>
                </div>
            </div>
        </div>

        <div v-else>
            <form>
                <button @click="sendNewMeal" class="btn btn-success">Validation!</button>
                <div class="row">
                    <h1>Votre repas :</h1>
                    <Food v-for="aliment in tempDataActiveChoice" :data="aliment" :path="path" :key="selectedFood.aliment"/>
                </div>
                <label for="title_meal">Titre du repas</label>
                <input type="text" id="title_meal" class="form-control" v-model="titleMeal">
            </form>
        </div>
    </div>
</template>

<script>
    import axios from "axios";
    import ProgressionBar from "./views/newMeal/Progression-Bar";
    import Food from "./views/newMeal/Food";
    import { ContentLoader } from "vue-content-loader"
    const routes = require('../../public/js/fos_js_routes.json');
    import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';
    Routing.setRoutingData(routes);

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
                activeChoice: undefined,
                isLoading: true,
                selectedFood: {},
                tempDataActiveChoice: {},
                final: false,
                titleMeal: undefined
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
                        this.selectedFood.entree = this.activeChoice;
                        document.getElementById('step1').classList.remove("is-active");
                        document.getElementById('step2').classList.add('is-active');
                    } else if(this.step === 1) {
                        this.loadDessert();
                        this.selectedFood.platprincipal = this.activeChoice;
                        document.getElementById('step2').classList.remove("is-active");
                        document.getElementById('step3').classList.add('is-active');
                    } else if(this.step === 2) {
                        this.selectedFood.dessert = this.activeChoice;
                        this.final = true;
                        document.getElementById('step3').classList.remove("is-active");
                        document.getElementById('step4').classList.add('is-active');
                    }

                    this.activeChoice = undefined;
                } else {
                    let toast = this.$toasted.error("Merci de faire un choix!", {
                        theme: "toasted-primary",
                        icon: "exclamation-triangle",
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
                    })
                    .catch(function() {
                        console.log('Erreur dans le chargement!');
                    })
                    .finally(() => {
                        this.isLoading = false;
                        this.step++;
                    });
            },

            // Permet de selectionner un aliment dans l'étape actuelle
            setActive(index) {
                this.activeChoice = index;
            },

            // Sauvegarde temporairement les plats choisis pour les afficher sur l'étape de validation
            setTemporaryData(title, picture) {
                if(this.step === 0) {
                    this.tempDataActiveChoice.entree = {"title": title, "picture": picture};
                }
                else if(this.step === 1) {
                    this.tempDataActiveChoice.platprincipal = {"title": title, "picture": picture};
                }
                else if(this.step === 2) {
                    this.tempDataActiveChoice.dessert = {"title": title, "picture": picture};
                }
            },

            // Envoi le nouveau repas vers l'API
            sendNewMeal(e) {
                e.preventDefault(); // Nous sommes dans une balise form, empêche l'actualisation par défaut
                if(this.titleMeal !== undefined) {
                    axios.post('/api/meals', {
                        'entree': `/api/food/${this.selectedFood.entree}`,
                        'maindish': `/api/food/${this.selectedFood.platprincipal}`,
                        'dessert': `/api/food/${this.selectedFood.dessert}`,
                        'title': this.titleMeal
                    }).then(() => {
                        document.getElementById('step4').classList.remove("is-active");
                        let toast = this.$toasted.success("Repas enregistré!", {
                            theme: "toasted-primary",
                            icon: "check",
                            position: "top-right",
                            duration : 3000
                        });
                        window.location.href = Routing.generate('admin.newMeal');
                    }).catch(function(response) {
                        console.log(`Erreur pour aider le développeur dans sa quète du débugage : ${response}`);
                    }).finally(() => {
                        this.isLoading = false;
                    });
                } else {
                    let toast = this.$toasted.error("Veuillez saisir un titre!", {
                        theme: "toasted-primary",
                        icon: "times",
                        position: "top-right",
                        duration : 3000
                    });
                }
            }
        }
    }
</script>

<style scoped>

</style>