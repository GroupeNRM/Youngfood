<template>
    <form>
        <div class="form-group">
            <label for="select_meal" class="required">Choisir un repas</label>
            <select id="select_meal" v-model="idMeal">
                <option value="">Choisir un repas</option>
                <option v-for="meal in meals" :key="meal.id" :value="meal.id">{{meal.title}}</option>
            </select>
        </div>
        <div class="form-group">
            <label class="required">Date du repas</label>
            <datepicker :language="fr" :full-month-name="true" :required="true" readonly="false" :mondayFirst="true" input-class="form-control" v-model="dateMeal"></datepicker>
        </div>
        <div class="form-group">
            <button @click="sendNewBooking" class="btn btn-success">Valider</button>
        </div>
    </form>
</template>

<script>
    import axios from "axios";
    import Datepicker from "vuejs-datepicker"
    import fr from "vuejs-datepicker/dist/locale/translations/fr"

    export default {
        name: "NewBooking",
        components: {
            Datepicker
        },
        data: function() {
          return {
              meals: {},
              fr: fr,
              idMeal: undefined,
              dateMeal: undefined
          }
        },
        mounted() {
            this.loadMeals();
        },
        methods: {
            // Chargement des repas et affichage dans le <select>
            loadMeals: function () {
                axios.get('/api/meals?page=1')
                    .then(response => this.meals = response.data['hydra:member'])
                    .catch(function() {
                        console.log('Erreur dans le chargement!');
                    });
            },
            // Envoie vers l'API
            sendNewBooking: function (e) {
                e.preventDefault();
                axios.post('/api/bookings', {
                    meal: `/api/meals/${this.idMeal}`,
                    date: this.dateMeal
                }).then(() => {
                    let toast = this.$toasted.success("Repas enregistré!", {
                        theme: "toasted-primary",
                        icon: "check",
                        position: "top-right",
                        duration : 3000
                    });

                    window.location.href = Routing.generate('admin.newBooking')
                }).catch(function () {
                    console.log(`Erreur pour aider le développeur dans sa quète du débugage : ${response}`);
                });
            }
        }
    }
</script>

<style scoped>

</style>