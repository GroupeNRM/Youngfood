<template>
    <li class="nav-item text-light center-icon passive-bell">
        <img @click="redirectListNotification" :src="bell" width="30" alt="Icone cloche">
        <span id="new-icon"></span>
    </li>
</template>

<script>
    const routes = require('../../public/js/fos_js_routes.json');
    import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';
    Routing.setRoutingData(routes);

    export default {
        name: "Notification",
        data: function() {
            return {
                'bell': '/build/bell-icon.svg'
            }
        },
        mounted() {
            // Port hardcodé, réfléchir à mieux
            const url = new URL(document.location.origin + ":1337/.well-known/mercure");
            url.searchParams.append('topic', `${document.location.origin}/api/notifications/{id}`);
            const eventSource = new EventSource(url);
            eventSource.onmessage = () => {
                document.getElementById('new-icon').classList.add('new-notification')

                let toast = this.$toasted.show("Vous avez reçu une nouvelle notification!", {
                    theme: "toasted-primary",
                    icon: "bell",
                    position: "top-right",
                    duration : 3000
                });
            };
        },
        methods: {
            redirectListNotification: function () {
                window.location.href = Routing.generate('admin.notifications');
            }
        }
    }
</script>

<style scoped>

</style>