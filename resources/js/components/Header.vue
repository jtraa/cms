<style>

    .swiper-pagination-bullet.swiper-pagination-bullet-active{
        background-color: #e04318 !important;
    }

    .swiper-pagination-bullet{
        width: 7px !important;
        height: 7px !important;
        opacity: 1  !important;
    }

    .swiper-pagination-bullet {
        background: none repeat scroll 0 0 #869791;
        border-radius: 20px;
        height: 12px;
        margin: 5px 7px;
        opacity: 1;
        width: 12px;
        outline: 0 !important;
    }
    .fill {
        position: relative;
    }

    .fill .background-image {
        width: 100%;
        height: 50vh;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        position: relative;
    }

    .fill .content {
        position: relative;
    }

    .fill .background-image::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.35);
    }

    .v-btn__content {
        justify-content: start;
        word-wrap: break-word;
        white-space: nowrap !important;
        text-overflow: ellipsis;
        overflow: hidden;
        display: inline-block;
    }

    .v-btn {
        word-wrap: break-word;
    }

    .open-on-hover { transition: all .0001s ease-in-out !important; }


</style>

<template>
    <swiper
        :loop="true"
        :slides-per-view="1"
        :per-page="1"
        :rewind="true"
        :pagination="{
            clickable: true,
        }"
        :modules="modules"
        :autoplay="{
          delay: 5000,
          disableOnInteraction: false,
        }"
        class="w-full">
            <swiper-slide v-for="(slider, index) in this.section.data.content.sliders" :key="index">
                <div class="item w-full flex justify-center items-center">
                    <div class="fill w-full bg-dark">
                        <div :style="{ backgroundImage: 'url(/uploads/' + (isSmallerThan750px ? slider.imageWithSize : slider.imageConverted) + ')' }" class="background-image flex justify-center items-center max-h-300px lg:max-h-500px" :alt="slider.sliderTitle">
                            <div class="container content px-5 lg:px-0">
                                <h2 class="lg:mb-4 text-2xl leading-none text-shadow lg:text-30pt xl:text-40pt text-white font-bold">{{ slider.sliderTitle }}</h2>
                                <div class="text-12pt lg:text-16pt hidden lg:block text-shadow text-white" v-html="slider.sliderContent"></div>
                                <v-btn
                                    value="Save Task"
                                    type="submit"
                                    :href="slider.sliderButtonLink"
                                    size="x-large"
                                    class="bg-secondary text-center mt-5 text-white font-bold text-15pt no-underline max-w-full overflow-hidden whitespace-nowrap text-left text-ellipsis"
                                >
                                    {{ slider.sliderButton }}
                                </v-btn>
                            </div>
                        </div>
                    </div>
                </div>
            </swiper-slide>
        </swiper>
</template>

<script>
    import { Swiper, SwiperSlide } from 'vue-awesome-swiper';
    import 'swiper/css';
    import 'swiper/css/pagination';
    import { Autoplay, Pagination, Navigation } from 'swiper';

    export default {
    components: {
        Swiper,
        SwiperSlide,
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
        }
    },
    data () {
        return {
            swiperOptions: {
                autoplay: {
                    delay: 5000,
                },
            },
        }
    },
    setup() {

        return {
            modules: [Autoplay, Pagination, Navigation],
        };
    },
    computed: {
        sliderMediaArray() {
            return this.section.data.content.sliders.map((slider, index) => {
                return {
                    slider: slider,
                    media: this.section.media[index].original_url,
                };
            });
        },
        isSmallerThan750px() {
            return window.innerWidth < 750;
        }
    },
    mounted() {
        console.log(this.section);
    },

}
</script>
