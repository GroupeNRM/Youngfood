<template>
    <div class="child-card text-center">
        <div class="col-md-12">
            <img src="/build/IMG_CHILD.svg" alt="Image enfant" class="d-block">
        </div>

        {{this.childData.nom}}
        {{this.childData.prenom}}
    </div>
</template>

<script>
    export default {
        name: "Child",
        props: ['childData']
    }
</script>

<style scoped>

</style>