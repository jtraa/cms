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

    .v-btn__content { width: 100%; white-space: normal; }

</style>

<template>
        <div class=" flex justify-center">
            <div class="justify-between container gap-5 align-items grid lg:flex py-5 px-5 lg:px-0">
                <div class="lg:w-45 text-left">
                    <h2 class="mb-4 text-15pt text-shadow lg:text-30pt text-primary font-bold">{{section.data.content.paragraphTitle}}</h2>
                    <div v-html="section.data.content.paragraphText" />
                    <v-btn :href="section.data.content.paragraphButtonLink" size="x-large" class="bg-secondary text-center mt-5 text-white font-bold text-15pt no-underline max-w-full overflow-hidden whitespace-nowrap text-left text-ellipsis">{{section.data.content.paragraphButton}}</v-btn>
                </div>
                <div class="lg:w-1/2 xl:w-50">
                    <div class="container flex justify-end gap-5 flex-wrap">
                        <div class="w-full xl:w-47" v-for="service in filteredServices">
                            <a :href="getPageUrl(service)">
                                <v-sheet class="w-full bg-white border border-blue-900  hover:bg-lightblue p-2">
                                    <div class="flex items-center justify-around min-h-150px">
                                        <div class="w-3/12 flex justify-center">
                                            <img :src="getImageUrl(service.image_with_size)"  class="h-16 w-16" :alt="service.title">
                                        </div>
                                        <div class="w-7/12">
                                            <h3 class="font-bold">{{ service.title }}</h3>
                                            <div class="text-grey-darken-4 sectionService text-ellipsis max-h-100px overflow-hidden" v-html="getFirstSectionContent(service.sections, index)"></div>
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
            services: {
                type: Array,
            },
            pages: {
                type: Object,
                required: true
            },
        },
        data () {
            return {

            }
        },
        mounted() {
            console.log(this.pages);
        },
        computed: {
            filteredServices() {
                const today = new Date();
                let serviceIds = this.section.data.content.services.toString().split(',').map(id => id.trim());
                return this.services
                    .sort((a, b) => a.order - b.order)
                    .filter(service => {
                            const publishedAt = new Date(service.published_at);
                            const publishedUntil = service.published_until ? new Date(service.published_until) : null;

                            if (publishedUntil !== null) {
                                return publishedUntil > today && service.in_index === 1;
                            }

                        return publishedAt <= today && service.in_index === 1;
                    })
                    .map(service => {
                        return {
                            ...service,
                            id: service.id.toString(), // convert id to string
                        };
                    })
                    .filter(service => {
                        let isIncluded = false;
                        serviceIds.forEach(id => {
                            if (service.id === id) {
                                isIncluded = true;
                            }
                        });
                        return isIncluded;
                    });
            },
        },
        methods: {
            getFirstSectionContent(section) {
                const firstSection = section[0];
                if (firstSection && firstSection.data && firstSection.data.content && firstSection.data.content.paragraphText) {
                    return this.removeStyles(firstSection.data.content.paragraphText);
                }

                return '';
            },
            getImageUrl(imageName) {
                return `/uploads/${imageName}`;
            },
            removeStyles(section) {
                return section.replace(/(<([^>]+)>)/gi, ' ').replace(/ style="[^"]*"/gi, '');
            },
            getPageUrl(service) {
                const pageId = 1;
                const pagesArray = Object.values(this.pages); // Convert object to an array
                const page = pagesArray.find((page) => page.id === pageId);

                if (page) {
                    return `/${page.slug}/${service.slug}`;
                }

                return '#';
            },
        },
    }
</script>
