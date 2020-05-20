<template>
    <div class="container-fluid">
        <div class="row" v-if="step === 0">
            
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
                daysAvailable: []
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

                while(this.daysAvailable.length < 5) {
                    if(tomorrow.getDay() !== 6 && tomorrow.getDay() !== 0) {
                        let temp = new Date(tomorrow);
                        this.daysAvailable.push(temp);
                    }
                    tomorrow.setDate(tomorrow.getDate() + 1);
                }
            }
        }
    }
</script>

<style scoped>

</style>