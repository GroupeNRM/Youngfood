<template>
    <div id="select-entree" class="row">
        <div class="col-md-3 food-card" v-for="aliment in aliments">
            <img class="img-fluid" v-bind:src="path + aliment.picture" v-bind:alt="aliment.title">
            <p>{{aliment.title}}</p>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Food",
        props: ['data']
    }
</script>

<style scoped>

</style>