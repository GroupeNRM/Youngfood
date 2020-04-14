<template>
    <div>
        <div class="row">
            <div class="col-md-5 mx-auto">
                <form name="registration_form" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="registration_form_firstname" class="required">Prénom</label>
                                <input type="text" id="registration_form_firstname" name="registration_form[firstname]" required="required" class="form-control" v-model="prenom">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="registration_form_lastname" class="required">Nom de famille</label>
                                <input type="text" id="registration_form_lastname" name="registration_form[lastname]" required="required" class="form-control" v-model="nom">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="registration_form_email" class="required">Email</label>
                                <input type="text" id="registration_form_email" name="registration_form[email]" required="required" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="registration_form_gender" class="required">Sexe</label>
                                <select id="registration_form_gender" name="registration_form[gender]" v-model="sexe">
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
                                <input type="password" id="registration_form_password" name="registration_form[password]" required="required" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="registration_form_verifpassword" class="required">Vérification mot de passe</label>
                                <input type="password" id="registration_form_verifpassword" name="registration_form[verifpassword]" required="required" class="form-control">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-md-5 mx-auto">
                <Card v-bind:nom="nom" v-bind:prenom="prenom" v-bind:sexe="sexe"/>
            </div>
        </div>
    </div>
</template>

<script>
    import Card from "./Card";
    export default {
        data: function() {
            return {
                nom: '',
                prenom: '',
                sexe: ''
            }
        },
        name: "Form",
        components: {Card}
    }
</script>

<style scoped>

</style>