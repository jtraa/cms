
<template>
    <div
        class="flex justify-center md:px-0 px-5">
        <div class="justify-center align-items grid lg:flex py-5">
            <div class="container">
                <div v-for="item in section.data.content.images" :key="item.id">
                    <img :src="`/uploads/${item.imageConverted}`" class="w-screen" :alt="settings.websitename"/>
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
            },
            settings: {
                type: Array,
            }
        },
        data () {
            return {

            }
        },
        mounted() {
            console.log(this.section)
        },
    }
</script>
