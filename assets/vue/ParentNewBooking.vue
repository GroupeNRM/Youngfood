<template>
    <div class="container-fluid">
        <div class="row text-center justify-content-around" v-if="step === 0">
            <div class="col-md-2 clickable-date px-0" v-for="day in availableDays" @click="choseDays(day)" :class="{ selected: chosenDays.includes(day)}">
                {{day}}
            </div>
        </div>
    </div>
</template>

<script>
    import axios from "axios";

    export default {
        name: "ParentNewBooking",
        data: function () {
            return {
                bookings: {},
                step: 0,
                today: new Date(),
                availableDays: [],
                chosenDays: []
            }
        },
        mounted() {
            this.loadBooking();
            this.getFiveNextWorkingDays();
        },
        methods: {
            loadBooking: function() {
                axios.get('/api/bookings?page=1')
                    .then((response) => {
                        this.bookings = response.data['hydra:member'];
                    })
                    .catch(function() {
                        console.log('Erreur dans le chargement des réservations!');
                    });
            },
            // Récupération de la date des prochains jours (hors week-end)
            getFiveNextWorkingDays: function () {
                let tomorrow = new Date(this.today);
                tomorrow.setDate(tomorrow.getDate() + 1);

                while(this.availableDays.length < 5) {
                    if(tomorrow.getDay() !== 6 && tomorrow.getDay() !== 0) {
                        let temp = new Date(tomorrow);
                        this.availableDays.push(temp.toLocaleDateString('fr-FR', {
                            weekday: "long",
                            day: "2-digit",
                            month: "2-digit",
                            year: "numeric"
                        }));
                    }
                    tomorrow.setDate(tomorrow.getDate() + 1);
                }
            },
            choseDays: function(day) {
                if(this.chosenDays.includes(day)) {
                    this.chosenDays.splice(this.chosenDays.indexOf(day), 1);
                } else {
                    this.chosenDays.push(day);
                }
            },
        }
    }
</script>

<style scoped>

</style>