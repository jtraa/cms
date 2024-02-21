<style>
    .blocks {
        margin-top: -20px;
    }
</style>

<template>
    <div
        class="flex justify-center lg:pb-10">
        <div class="justify-center container align-items grid lg:flex">
            <div class="container">
                <div class="flex blocks justify-between items-start flex-wrap">
                    <div class="lg:w-47 pb-5 px-5 lg:pb-0 lg:px-0" v-for="block in section.data.content.blocks">
                        <a :href="block.blockLink">
                            <v-sheet class="w-full bg-white border border-blue-900  hover:bg-lightblue">
                                <div class="flex items-start justify-around  overflow-hidden">
                                    <div class="p-5">
                                        <div class="flex mb-4 md:mb-0">
                                            <img :src="src" class="mr-5 h-16 w-16" :alt="block.blockTitle" />
                                            <h2 class="lg:text-20pt font-bold text-15pt text-secondary">
                                                {{block.blockTitle}}
                                            </h2>
                                        </div>
                                        <p class="text-grey-darken-2">
                                            {{block.blockDescription}}
                                        </p>
                                    </div>
                                </div>
                            </v-sheet>
                        </a>
                    </div>
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
            articles: {
                type: Array,
            },
        },
        computed: {

        },
        data () {
            return {
               src: '/uploads/thumbnails/arrow.png',
            }
        },
        mounted() {
            console.log(this.section.data.content.blocks);
        },
    }
</script>
