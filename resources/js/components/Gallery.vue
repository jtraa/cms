<style>
    @import 'lightgallery/css/lightgallery.css';
    @import 'lightgallery/css/lg-thumbnail.css';
    @import 'lightgallery/css/lg-zoom.css';

    button.lg-prev, button.lg-next {
        color: #e04218;
        font-size: 2em;
        font-weight: 600;
        content: '';
    }

    .image-box {
        position: relative;
        width: 100%;
        height: 0;
        overflow:hidden;
        padding-bottom: 75%; /* Adjust the aspect ratio as needed */
        background-color: #f2f2f2; /* Background color of the box */
    }

    .image-preview {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        object-fit: cover;
    }

</style>

<template>
    <div class="flex justify-center pb-5 px-5 lg:px-0">
        <div class="container flex justify-center">
            <div class="w-full flex flex-wrap">
                <div class="w-full">
                    <lightgallery
                        :settings="{ speed: 500, plugins: plugins }"
                        :onInit="onInit"
                        :onBeforeSlide="onBeforeSlide"
                        class="flex flex-wrap gap-5"
                    >
                        <a
                            v-for="(item, index) in section.data.content.gallery" :key="index"
                            class="gallery-item cursor-pointer 2xl:w-23 xl:w-32 lg:w-31 sm:w-30 w-47"
                            :data-src="`/uploads/${item.imageConverted}`"
                        >
                            <div class="image-box">
                                <img class="image-preview" :src="`/uploads/${item.imageWithSize}`" :alt="item.imageDescription || settings.websitename" />
                            </div>
                            <p v-if="item.imageDescription" class="text-center pt-5">{{item.imageDescription}}</p>
                        </a>
                    </lightgallery>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Lightgallery from 'lightgallery/vue';
    import lgThumbnail from 'lightgallery/plugins/thumbnail';
    import lgZoom from 'lightgallery/plugins/zoom';

    export default {
        components: {
            Lightgallery
        },
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
            settings: {
                type: Array,
            }
        },
        data () {
            return {
                plugins: [lgZoom],
                headerImage: 'images/itraa.webp',
                imgUrl: 'storage/placeholders/placeholder.jpg',
                lazyloadImage: 'images/header-dummy.webp',
                logoImage: '',
                bannerImage: 'images/banner/banner.gif',
            }
        },
        setup() {
            return {

            };
        },
        methods: {
            onInit: (detail) => {
                lightGallery = detail.instance;
            },
            onBeforeSlide: () => {
                console.log('calling before slide');
            },
        },
        computed: {

        },
        watch: {
            items(newVal, oldVal) {
                this.$nextTick(() => {
                    lightGallery.refresh();
                });
            },
        },
        mounted() {
            console.log(this.imageMediaArray);
            console.log(this.section.data.content.gallery);
        },

    }
</script>
