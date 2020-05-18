<template>
    <form>
        <div class="form-group">
            <label for="select_meal" class="required">Choisir un repas</label>
            <select id="select_meal" v-model="idMeal">
                <option value="" selected>Choisir un repas</option>
                <option v-for="meal in meals" :key="meal.id" :value="meal.id">{{meal.title}}</option>
            </select>
        </div>
        <div class="form-group">
            <label class="required">Date du repas</label>
            <datepicker :highlighted="highlighted" minimum-view="day" :bootstrap-styling="true" :language="fr" :full-month-name="true" :required="true" readonly="false" :mondayFirst="true" v-model="dateMeal"></datepicker>
        </div>
        <div class="form-group">
            <button @click="verifForm" class="btn btn-success">Valider</button>
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
              fr: fr,
              meals: {},
              bookings: {},
              idMeal: undefined,
              dateMeal: undefined,
              highlighted: {
                  dates: [],
              }
          }
        },
        mounted() {
            this.loadBooking();
            this.loadMeals();
        },
        methods: {
            // Chargement des repas et affichage dans le <select>
            loadMeals: function () {
                axios.get('/api/meals?page=1')
                    .then((response) => this.meals = response.data['hydra:member'])
                    .catch(function() {
                        console.log('Erreur dans le chargement des repas!');
                    });
            },
            // Charge les réservations déjà existantes
            loadBooking: function() {
                axios.get('/api/bookings?page=1')
                    .then((response) => {
                        this.bookings = response.data['hydra:member'];
                        this.eachDates();
                    })
                    .catch(function() {
                        console.log('Erreur dans le chargement des réservations!');
                    });
            },
            verifForm: function(e) {
                e.preventDefault();
                if(this.idMeal && this.dateMeal) {
                    this.sendNewBooking();
                } else {
                    let toast = this.$toasted.error("Merci de remplir tous les champs!", {
                        theme: "toasted-primary",
                        icon: "times",
                        position: "top-right",
                        duration : 3000
                    });
                }
            },
            // Envoie vers l'API
            sendNewBooking: function () {
                axios.post('/api/bookings', {
                    meal: `/api/meals/${this.idMeal}`,
                    date: this.dateMeal
                }).then(() => {
                    let toast = this.$toasted.success("Nouvelle réservation crée!", {
                        theme: "toasted-primary",
                        icon: "check",
                        position: "top-right",
                        duration : 3000
                    });

                    this.highlighted.dates.push(this.dateMeal);
                    this.dateMeal = undefined;
                    this.idMeal = undefined;
                }).catch(function () {
                    console.log(`Erreur dans l'envoie des données : ${response}`);
                });
            },
            // Récupère les dates de chaque objet Booking
            eachDates: function () {
                for (let booking in this.bookings) {
                    if (!this.bookings.hasOwnProperty(booking)) continue;

                    let obj = this.bookings[booking];

                    this.highlighted.dates.push(this.parseDate(obj.date));
                }
            },
            // Convertie en date les strings contenant les dates
            parseDate: function(dates) {
                let parts = dates.match(/(\d+)/g);
                return new Date(parts[0], parts[1]-1, parts[2]);
            }
        }
    }
</script>

<style scoped>

</style>