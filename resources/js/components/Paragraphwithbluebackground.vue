<style>

</style>

<template>
    <div
    class="bg-primary flex justify-center">
        <div class="justify-between container align-items grid lg:flex py-10 px-5 lg:px-0">
            <div class="lg:w-1/2 text-left order-2 lg:order-1">
                <h2 class="text-15pt text-shadow lg:text-30pt text-white font-bold">{{section.data.content.paragraphTitle}}</h2>
                <div class="text-white mb-5" v-html="section.data.content.paragraphText" />
                <v-btn :href="section.data.content.paragraphButtonLink" size="x-large" class="bg-secondary text-center mt-5 text-white font-bold text-15pt no-underline max-w-full overflow-hidden whitespace-nowrap text-left text-ellipsis">{{section.data.content.paragraphButton}}</v-btn>
            </div>
            <div class="lg:w-1/2 xl:w-2/5 order-1 lg:order-2 mb-5">
                <div class=" container">
                    <img :src="getImageUrl(section.data.content.imageConverted)" class="h-100"  :alt="section.data.content.paragraphTitle"/>
                </div>
            </div>
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
            services: {
                type: Array,
            }
        },
        data () {
            return {

            }
        },
        mounted() {
        },
        methods: {
            getImageUrl(imageName) {
                return `/uploads/${imageName}`;
            }
        }
    }
</script>
