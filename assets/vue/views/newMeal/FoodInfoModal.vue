<template>
    <div class="modal-mask">
        <div class="modal-wrapper">
            <div class="modal-container">
                <div class="modal-head border-bottom mb-2">
                    <h5>{{food.title}}</h5>
                    <span @click="hideModal" class="modal-close">&times;</span>
                </div>
                <div class="modal-main">
                    {{food.information ? food.information : "Il n'y a pas d'informations concernant cet aliment"}}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "FoodInfoModal",
        props: ['food'],
        methods: {
            hideModal() {
                this.$parent.hideInformation();
            }
        }
    }
</script>

<style scoped>

</style>