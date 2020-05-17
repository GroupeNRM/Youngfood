<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Titre</th>
                            <th scope="col">Contenu</th>
                            <th scope="col">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="notification in notifications" :key="notification.id">
                            <th scope="row">{{ notification.id }}</th>
                            <th scope="row">{{ notification.notifTitle }}</th>
                            <th scope="row">{{ notification.notifText }}</th>
                            <th scope="row">{{ notification.notifDate }}</th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from "axios";

    export default {
        name: "ListNotification",
        data: function(){
            return {
                notifications: []
            }
        },
        mounted() {
            // Lorsque le composant est monté, lance un appel vers l'API pour récuperer les entrées
            this.fetchNotifications()
        },
        methods: {
            fetchNotifications: function(){
                axios.get('/api/notifications?page=1')
                    .then((response) => {
                        this.notifications = response.data['hydra:member']
                        console.log(this.notifications)
                    })
                    .catch(function () {
                        console.log('Erreur dans le chargement!');
                    })
                    .finally(function () {
                        // always executed
                    });
            }
        }
    }
</script>

<style scoped>

</style>