<template>
    <div class="row">
        <div class="id-card mx-auto pt-5 pl-4">
            <div class="row" style="height: 245px;">
                <div class="col-md-4">
                    <img :src="img" alt="">
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <span class="card-title">Prénom : {{prenom}}</span>
                    </div>
                    <div class="row pt-3">
                        <span class="card-title">Nom : {{nom}}</span>
                    </div>
                    <div class="row pt-3">
                        <span class="card-title">Sexe : {{gender}}</span>
                    </div>
                </div>
            </div>
            <div class="row" style="height: 115px; background: #C4C4C4;">
                fezfzefze
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                'img': '/build/avatar.svg'
            }
        },
        props: {
            prenom: String,
            nom: String,
            sexe: String,
        },
        computed: {
            gender: function(){
                if(this.sexe === 'H') {
                    return 'Homme';
                } else if(this.sexe === 'F') {
                    return 'Femme';
                } else  {
                    return 'Inconnu';
                }
            }
        },
        name: "Card"
    };
</script>

<style scoped lang="scss">

</style>