<style>
    .blocks {
        margin-top: -20px;
    }
</style>

<template>
    <div
        class="bg-primary flex justify-center pt-2">
        <v-footer class="bg-secondary">
            <v-row justify="center" no-gutters>
                <v-btn
                    v-for="page in sortedPages"
                    :key="page.slug"
                    :href="'/' + page.slug"
                    color="white"
                    variant="text"
                    class="mx-2 underline hover:no-underline"
                    rounded="xl"
                >
                    {{ page.title }}
                </v-btn>
                <v-col class="text-center mt-4" cols="12">
                    <div class="text-white" v-html="settings.footertext" />
                </v-col>
            </v-row>
        </v-footer>
    </div>
</template>

<script>
    export default {
        props: {
            pages: {
                type: Object,
                required: true
            },
            services: {
                type: Array,
            },
            alt: {
                type: String,
            },
            settings: {
                type: Object,
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
        },
        computed: {

        },
        data () {
            return {

            }
        },
        computed: {
            sortedPages() {
                const pagesArray = Object.values(this.pages);
                console.log(this.pages);
                return pagesArray.sort((a, b) => a.order - b.order);
            },
        },
        mounted() {
            console.log();
        },
    }
</script>
