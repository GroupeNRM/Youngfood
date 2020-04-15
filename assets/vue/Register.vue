<template>
    <div>
        <div class="row mb-5">
            <div class="col-md-5 mx-auto">
                <form name="registration_form" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="registration_form_firstname" class="required">Prénom</label>
                                <input type="text" id="registration_form_firstname" name="registration_form[firstname]" required="required" class="form-control" v-model="fields.firstname">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="registration_form_lastname" class="required">Nom de famille</label>
                                <input type="text" id="registration_form_lastname" name="registration_form[lastname]" required="required" class="form-control" v-model="fields.lastname">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="registration_form_email" class="required">Email</label>
                                <input type="text" id="registration_form_email" name="registration_form[email]" required="required" class="form-control" v-model="fields.email">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="registration_form_gender" class="required">Sexe</label>
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
                                <label for="registration_form_verifpassword" class="required">Vérification mot de passe</label>
                                <input type="password" id="registration_form_verifpassword" name="registration_form[verifpassword]" required="required" class="form-control" v-model="fields.verifPassword">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <a href="#" class="nav-title left h3" @click="">< Précédent</a>
        <a href="#" class="nav-title right h3" @click="submit">Suivant ></a>
        <Card v-bind:fields="fields"/>
    </div>
</template>

<script>
    import Card from "./views/register/Card";
    import axios from "axios";
    export default {
        data: function() {
            return {
                fields: {}
            }
        },
        methods: {
            submit: function() {
                axios.post('/api/users', {
                    email: this.fields.email,
                    password: this.fields.password,
                    firstname: this.fields.firstname,
                    lastname: this.fields.lastname,
                    gender: this.fields.sex,
                })
                .then(function(response) {
                    console.log('ok');
                })
                .catch(function(response) {
                    console.log('erreur');
                });
            }
        },
        name: "Form",
        components: {Card}
    }
</script>

<style scoped>

</style>