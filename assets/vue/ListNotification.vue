<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-1 text-center">
                ID
            </div>
            <div class="col-md-4 text-center">
                Titre
            </div>
            <div class="col-md-4 text-center">
                Contenu de la notification
            </div>
            <div class="col-md-2 text-center">
                Date d'émission
            </div>
            <div class="col-md-1 text-center">
                Actions
            </div>
        </div>
        <div class="row notification-wrapper mb-2" v-for="notification in notifications" :key="notification.id">
            <div class="col-md-1 text-center">
                {{ notification.id }}
            </div>
            <div class="col-md-4 text-center">
                <span class="title-notification">{{ notification.notifTitle }}</span>
            </div>
            <div class="col-md-4 text-center overflow-hidden">
                {{ notification.notifText }}
            </div>
            <div class="col-md-2 text-center overflow-hidden">
                {{ notification.notifDate }}
            </div>
            <div class="col-md-1 text-center">
                <i class="fas fa-trash" v-on:click="removeElement(notification)"></i>
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
                    })
                    .catch(function () {
                        console.log('Erreur dans le chargement!')
                    });
            },
            removeElement: function(notification){
                axios.delete(`/api/notifications/${notification.id}`)
                    .then(() => {
                        this.notifications.splice(this.notifications.indexOf(notification), 1);
                    })
                    .catch(function () {
                        console.log('Erreur : Notification non supprimée !');
                    });
            }
        }
    }
</script>

<style scoped>

</style>