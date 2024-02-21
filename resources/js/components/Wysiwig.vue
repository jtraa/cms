<style>

</style>

<template>
    <div
        class="flex justify-center" v-for="content in section.data.content.editors">
        <div class="container flex py-5 px-5 lg:px-0">
            <div class="w-full">
                <div v-html="content.text" />
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
            console.log(this.section.data.content.editors[0].text);
        },
    }
</script>
