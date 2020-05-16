<template>
    <Datepicker :language="fr"></Datepicker>
</template>

<script>
    import axios from "axios";
    import Datepicker from "vuejs-datepicker"

    export default {
        name: "NewBooking",
        components: {
            Datepicker
        },
        data: function() {
          return {
              meals: {}
          }
        },
        methods: {
            loadEntree: function () {
                this.isLoading = true;
                axios.get('/api/meals?page=1')
                    .then(response => this.meals = response.data['hydra:member'])
                    .catch(function() {
                        console.log('Erreur dans le chargement!');
                    })
                    .finally(() => {
                        this.isLoading = false;
                    });
            },
        }
    }
</script>

<style scoped>

</style>