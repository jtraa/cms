<style>
    .v-card--reveal {
        align-items: center;
        bottom: 0;
        justify-content: center;
        opacity: .9;
        position: absolute;
        width: 100%;
    }

</style>

<template>
    <div
        class="bg-white flex justify-center px-0">
        <div class="container">
            <v-breadcrumbs class="py-5 px-4 lg:px-0" :items="items"></v-breadcrumbs>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            alt: {
                type: String,
            },
            maps: {
                type: String,
            },
            telephone: {
                type: String,
            },
            tel: {
                type: String,
            },
            mail: {
                type: String,
            },
            section: {
                type: Object,
            },
            article: {
                type: Object,
            }
        },
        computed: {

        },
        data () {
            return {
                items: [
                    {
                        title: 'Nieuws',
                        disabled: false,
                        href: '/nieuws',
                    },
                    {
                        title: this.article.title,
                        disabled: true,
                    },
                ],
            }
        },
        mounted() {
            console.log(this.article.title);
        },
    }
</script>
