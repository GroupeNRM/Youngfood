<template>
    <div class="id-card mx-auto justify-content-center">
        <div class="pt-5" style="height: 245px;">
            <div class="row ml-0 mr-0">
                <div class="col-md-4">
                    <img :src="img" alt="avatar">
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <span class="card-title">Prénom : {{fields.firstname}}</span>
                    </div>
                    <div class="row pt-3">
                        <span class="card-title">Nom : {{fields.lastname}}</span>
                    </div>
                    <div class="row pt-3">
                        <span class="card-title">Sexe : {{gender}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row ml-0 mr-0 bottom-card align-items-center">
            <div class="col-md-12">
                IDMYCANTINE&#60;&#60;&#60;&#60;&#60;&#60;&#60;&#60;&#60;&#60;&#60;&#60;&#60;&#60;&#60;&#60;&#60;&#60;&#60;&#60;&#60;&#60;&#60;&#60;XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                'img': '/build/avatar-homme.svg'
            }
        },
        props: {
            fields: {
                Object,
                firstname: String,
                lastname: String,
                sex: String,
            }
        },
        computed: {
            gender: function(){
                if(this.fields.sex === 'H') {
                    return 'Homme';
                } else if(this.fields.sex === 'F') {
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