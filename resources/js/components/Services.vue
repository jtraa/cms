<style>

    .sectionService {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2; /* number of lines to show */
        overflow: hidden;
    }
    .bg-lightblue {
        background-color: #f3f9fe;
    }

</style>

<template>

    <div class="flex justify-center">
        <div class="justify-center container align-items grid lg:flex py-5 px-5 lg:px-0">
            <div class="container">
                <h2 class="text-15pt text-shadow lg:text-30pt text-primary mb-5 font-bold">Diensten</h2>
                <div class="flex justify-start items-center gap-5 flex-wrap">
                    <div class="w-full lg:w-49 " v-for="service in filteredServices" :key="service.id">
                        <a :href="getPageUrl(service)">
                            <v-sheet class="w-full bg-white border border-blue-900 hover:bg-lightblue">
                                <div class="flex items-center justify-around min-h-150px pl-0 p-5">
                                    <div class="w-2/12 flex justify-center">
                                        <img :src="getImageUrl(service.image_conversion)" :alt="service.title"  class="h-10 w-10">
                                    </div>
                                    <div class="w-8/12">
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
        computed: {
            filteredServices() {
                const today = new Date();

                return this.services
                    .sort((a, b) => a.order - b.order)
                    .filter(service => {
                        const publishedAt = new Date(service.published_at);
                        const publishedUntil = service.published_until ? new Date(service.published_until) : null;

                        if (publishedUntil !== null) {
                            return publishedUntil > today && service.in_index === 1;
                        }

                        return publishedAt <= today && service.in_index === 1;
                    });
            }
        },
        methods: {
            getFirstSectionContent(section) {
                const firstSection = section[0];
                if (firstSection && firstSection.data && firstSection.data.content && firstSection.data.content.paragraphText) {
                    return this.removeStyles(firstSection.data.content.paragraphText);
                }

                return '';
            },
            getCurrentURL() {
                return window.location.href
            },
            removeStyles(section) {
                console.log(section);
                return section.replace(/(<([^>]+)>)/gi, ' ').replace(/ style="[^"]*"/gi, '');
            },
            getImageUrl(imageName) {
                return `uploads/${imageName}`;
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
