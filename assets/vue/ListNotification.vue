<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col" class="text-center">Titre</th>
                            <th scope="col" class="text-center">Contenu</th>
                            <th scope="col" class="text-center">Date</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="notification in notifications" :key="notification.id">
                            <th scope="row">{{ notification.id }}</th>
                            <th scope="row" class="text-center">{{ notification.notifTitle }}</th>
                            <th scope="row" class="text-center">{{ notification.notifText }}</th>
                            <th scope="row" class="text-center">{{ notification.notifDate }}</th>
                            <th scope="row" class="text-center"><i class="fas fa-trash" v-on:click="removeElement(notification)"></i></th>
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
                        console.log('Erreur dans le chargement!')
                    })
                    .finally(function () {
                        // always executed
                    });
            },
            removeElement: function(notification){
                axios.delete(`/api/notifications/${notification.id}`)
                    .then(() => {
                        this.notifications.splice(this.notifications.indexOf(notification), 1)
                        console.log('Notification Supprimée !')
                    })
                    .catch(function () {
                        console.log('Erreur : Notification non supprimée !')
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