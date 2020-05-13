<template>
    <div class="modal-mask">
        <div class="modal-wrapper">
            <div class="modal-container" v-if="info">
                // TODO
            </div>
        </div>
    </div>
</template>

<script>
    import axios from "axios";

    export default {
        name: "FoodInfoModal",
        props: ['id'],
        mounted() {
            this.fetchInfo(this.id);
        },
        data: function() {
            return {
                info: {}
            }
        },
        methods: {
            fetchInfo: function (id) {
                axios.get(`/api/food/${id}`)
                    .then(response => this.info = response.data['hydra:member'])
                    .catch(function() {
                        console.log('Erreur dans le chargement!');
                    });
            }
        }
    }
</script>

<style scoped>

</style>