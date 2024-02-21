<style>

</style>

<template>
    <div
        class=" flex justify-center">
        <div class="lg:flex justify-center container align-items  py-5 px-5 sm:px-0">
            <div class="w-full">
                <h2 class="text-15pt text-shadow lg:text-30pt text-primary mb-5 font-bold">{{section.data.content.paragraphTitle}}</h2>
                <div class="mb-5" v-html="section.data.content.paragraphText" />
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
            console.log(this.services);
        },
    }
</script>
