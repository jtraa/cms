<style>


</style>

<template>
    <div
        class="bg-white flex justify-center">
        <div class="justify-between container items-center grid lg:flex py-5 px-5 lg:px-0">
            <div class="w-full lg:w-1/2 text-left">
                <h2 class="text-15pt text-shadow lg:text-30pt text-primary font-bold">{{section.data.content.paragraphTitle}}</h2>
                <div class="text-white mb-5" v-html="section.data.content.paragraphText" />
            </div>
            <div class="w-full lg:w-1/2 xl:w-2/5 mt-5 lg:mt-0">
                <div class="flex lg:justify-center">
                    <v-btn :href="section.data.content.paragraphButtonLink" size="x-large" class="bg-secondary text-center mt-5 text-white font-bold text-15pt no-underline max-w-full overflow-hidden whitespace-nowrap text-left text-ellipsis">{{section.data.content.paragraphButton}}</v-btn>
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
                headerImage: 'images/itraa.webp',
                imgUrl: 'storage/placeholders/placeholder.jpg',
                lazyloadImage: 'images/header-dummy.webp',
                logoImage: '',
                bannerImage: 'images/banner/banner.gif',
            }
        },
        mounted() {

        },
    }
</script>
