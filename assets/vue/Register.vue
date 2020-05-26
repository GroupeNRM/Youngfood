<template>
    <div>
        <div v-if="!isLoading">
            <div class="row mb-5">
                <div class="col-md-5 mx-auto">
                    <form name="registration_form" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="registration_form_firstname" class="required">Prénom</label> <span class="label-error" v-if="this.error.fnError">{{this.error.fnError}}</span>
                                    <input type="text" id="registration_form_firstname" name="registration_form[firstname]" required="required" class="form-control" v-model="fields.firstname">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="registration_form_lastname" class="required">Nom de famille</label> <span class="label-error" v-if="this.error.lnError">{{this.error.lnError}}</span>
                                    <input type="text" id="registration_form_lastname" name="registration_form[lastname]" required="required" class="form-control" v-model="fields.lastname">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="registration_form_email" class="required">Email</label> <span class="label-error" v-if="this.error.emError">{{this.error.emError}}</span>
                                    <input type="text" id="registration_form_email" name="registration_form[email]" required="required" class="form-control" v-model="fields.email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="registration_form_gender" class="required">Sexe</label> <span class="label-error" v-if="this.error.sxError">{{this.error.sxError}}</span>
                                    <select id="registration_form_gender" name="registration_form[gender]" v-model="fields.sex ">
                                        <option disabled value="">&nbsp</option>
                                        <option value="I">Inconnu</option>
                                        <option value="F">Femme</option>
                                        <option value="H">Homme</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="registration_form_password" class="required">Mot de passe</label>
                                    <input type="password" id="registration_form_password" name="registration_form[password]" required="required" class="form-control" v-model="fields.password">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="registration_form_verifpassword" class="required">Vérification mot de passe</label> <span class="label-error" v-if="this.error.pwDifferentError">{{this.error.pwDifferentError}}</span>
                                    <input type="password" id="registration_form_verifpassword" name="registration_form[verifpassword]" required="required" class="form-control" v-model="fields.verifPassword">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <a href="#" class="nav-title left h3" @click="goHome"><i class="fas fa-chevron-left"></i> Précédent</a>
            <a href="#" class="nav-title right h3" @click="submit">Suivant <i class="fas fa-chevron-right"></i></a>
            <Card v-bind:fields="fields"/>
        </div>
        <div v-else>
            <div class="row">
                <div class="col-md-6 mx-auto justify-content-center">
                    <transition name="fade">
                        <img :src="tomato" class="loading-tomato d-block mx-auto" alt="Une tomate humaine pour charger les données">
                    </transition>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Card from "./views/register/Card";
    import axios from "axios";
    const routes = require('../../public/js/fos_js_routes.json');
    import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';
    Routing.setRoutingData(routes);

    export default {
        data: function() {
            return {
                fields: {},
                error: {},
                isLoading: false,
                'tomato': '/build/loading-tomato.svg'
            }
        },
        methods: {
            goHome: function() {
                window.location.href = Routing.generate('home.index');
            },
            checkForm: function() {
                this.error = {};

                if(this.fields.password !== this.fields.verifPassword) {
                    this.error.pwDifferentError = 'Mots de passe différents';
                }

                if(!this.fields.firstname) {
                    this.error.fnError = 'Merci de renseigner un prénom';
                }

                if(!this.fields.lastname) {
                    this.error.lnError = 'Merci de renseigner un nom';
                }

                if(!this.fields.email) {
                    this.error.emError = 'Merci de renseigner une adresse e-mail';
                }

                if(!this.fields.sex) {
                    this.error.sxError = 'Merci de sélectionner votre sexe';
                }
            },
            submit: function() {
                this.checkForm();
                if(Object.keys(this.error).length === 0 && this.error.constructor === Object) {
                    this.isLoading = true;
                    axios.post('/api/users', {
                        email: this.fields.email,
                        password: this.fields.password,
                        verifPassword: this.fields.verifPassword,
                        firstname: this.fields.firstname,
                        lastname: this.fields.lastname,
                        gender: this.fields.sex,
                    })
                    .then(function(response) {
                        if(response.status === 201) {
                            window.location.href = Routing.generate('app_login');
                        }
                    })
                    .catch(function(response) {
                        console.log(`Erreur pour aider le développeur dans sa quète du débugage : ${response}`);
                    })
                    .finally(() => {
                        this.isLoading = false;
                    })
                }
            }
        },
        name: "Register",
        components: {Card}
    }
</script>

<style scoped>

</style>