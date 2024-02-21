<style>


</style>

<template>
        <div class=" flex justify-center">
            <div class="justify-between container align-items grid lg:flex py-5 px-5 lg:px-0">
                <div class="lg:w-1/2 xl:w-2/5 order-1 lg:order-1 mb-5">
                    <div class=" container flex justify-start flex-wrap">
                        <img :src="getImageUrl(section.data.content.imageConverted)"  class="h-100" :alt="section.data.content.paragraphTitle"/>
                    </div>
                </div>
                <div class="lg:w-1/2 text-left order-2 lg:order-2">
                    <h2 class="mb-4 text-15pt text-shadow lg:text-30pt text-primary font-bold">{{section.data.content.paragraphTitle}}</h2>
                    <div v-html="section.data.content.paragraphText" />
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
            console.log(this.section);
        },
        computed: {

        },
        methods: {
            getImageUrl(imageName) {
                return `/uploads/${imageName}`;
            }
        },
    }
</script>
