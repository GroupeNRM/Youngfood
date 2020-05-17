<template>
    <form>
        <div class="form-group">
            <label for="select_meal" class="required">Choisir un repas</label>
            <select id="select_meal">
                <option value="">Choisir un repas</option>
                <option v-for="meal in meals" :key="meal.id" :value="meal.id">{{meal.title}}</option>
            </select>
        </div>
        <div class="form-group">
            <label class="required">Date du repas</label>
            <datepicker :language="fr" :full-month-name="true" :required="true" readonly="false" :mondayFirst="true" input-class="form-control"></datepicker>
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
              fr: fr
          }
        },
        mounted() {
            this.loadMeals();
        },
        methods: {
            loadMeals: function () {
                axios.get('/api/meals?page=1')
                    .then(response => this.meals = response.data['hydra:member'])
                    .catch(function() {
                        console.log('Erreur dans le chargement!');
                    })
                    .finally(() => {
                        // this.isLoading = false;
                    });
            },
            sendNewBooking: function () {
                
            }
        }
    }
</script>

<style scoped>

</style>