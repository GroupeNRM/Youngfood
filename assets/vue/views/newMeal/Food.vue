<template>
    <div class="col-md-3 food-card">
        <div class="img-thumb">
            <img class="img-fluid" v-bind:src="path + data.picture" v-bind:alt="data.title" :class="{'selected': this.$parent.activeChoice === data.id}" @click="setActive(data.id, data.title, data.picture)">
            <span @click="showInformation(data.id)"><i class="fas fa-info"></i></span>
            <FoodInfoModal :id="data.id" v-if="showModal === true"/>
        </div>
        <h5>{{data.title}}</h5>
    </div>
</template>

<script>
    import FoodInfoModal from "./FoodInfoModal";
    export default {
        name: "Food",
        components: {FoodInfoModal},
        props: {
            data: Object,
            path: String,
        },
        data: function() {
            return {
                showModal: false
            }
        },
        methods: {
            showInformation: function () {
                this.showModal = true;
            },
            setActive(index, title, picture) {
                // Appel le composant parent, nous avons besoin que l'aliment selectionné soit lié au nouveau repas, pas à lui même
                this.$parent.setActive(index);
                this.$parent.setTemporaryData(title, picture);
            }
        }
    }
</script>

<style scoped>

</style>