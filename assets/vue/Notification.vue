<template>
    <li class="nav-item text-light center-icon passive-bell">
        <img :src="bell" width="30" alt="Icone cloche">
        <span id="new-icon"></span>
    </li>
</template>

<script>
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
        }
    }
</script>

<style scoped>

</style>