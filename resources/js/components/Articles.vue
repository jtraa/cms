<style>

    .section {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 4; /* number of lines to show */
        overflow: hidden;
    }

    .sheet {
        break-inside: avoid !important;
    }

</style>

<template>
    <div
        class="flex justify-center">
        <div class="w-full justify-center align-items lg:flex py-5 px-5 lg:px-0">
            <div class="container">
                <h2 class="text-15pt text-shadow lg:text-30pt text-primary mb-5 font-bold">Nieuws artikelen</h2>
                <div class="columns-1 md:columns-2 lg:columns-3 gap-5">
                    <div class="mb-5 w-full" v-for="(text, index) in filteredArticles" :key="index">
                        <div>
                            <a :href="`/nieuws/${text.slug}`">
                                <v-sheet class="sheet bg-white border border-blue-900 hover:bg-lightblue">
                                    <div class="flex items-center justify-around p-5">
                                        <div class="w-full">
                                            <h3 class="font-bold text-15pt lg:text-20pt text-secondary">{{ text.title }}</h3>
                                            <img v-if="text.image_conversion" class="w-full object-cover object-center max-h-300px py-4" :alt="text.title" :src="getImageUrl(text.image_conversion)">
                                            <div class="text-grey-darken-4 sectionService text-ellipsis max-h-100px overflow-hidden" v-html="removeStyles(getFirstSectionContent(text.sections, index))"></div>
                                        </div>
                                    </div>
                                </v-sheet>
                            </a>
                        </div>
                    </div>
                </div>
<!--                <div class="lg:min-h-690px">-->
<!--                    <div class="flex w-full gap-5 justify-start items-start flex-wrap">-->
<!--                        <div class="w-full w-30 xl:w-32" v-for="text in filteredArticles">-->
<!--                            <a :href="`/nieuws/${text.slug}`">-->
<!--                                <v-sheet class="w-full bg-white border border-blue-900  hover:bg-lightblue">-->
<!--                                    <div class="flex items-center justify-around min-h-200px">-->
<!--                                        <div class="w-10/12 h-11/12">-->
<!--                                            <h3 class="font-bold text-15pt lg:text-20pt text-secondary">{{ text.title }}</h3>-->
<!--                                                <div class="text-grey-darken-4 sectionService text-ellipsis max-h-100px overflow-hidden" v-html="removeStyles(getFirstSectionContent(text.sections, index))"></div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </v-sheet>-->
<!--                            </a>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
                <v-pagination
                    class="mt-5 lg:flex xl:mt-0"
                    v-model="currentPage"
                    :length="totalPages"
                    color="primary"
                ></v-pagination>
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
            article: {
                type: Object,
            }
        },
        computed: {
            filteredArticles() {
                const today = new Date();
                const startIndex = (this.currentPage - 1) * this.perPage;
                const endIndex = startIndex + this.perPage;
                const sortedArticles = this.articles
                    .sort((a, b) => a.order - b.order)
                    .filter((article) => {
                        const publishedAt = new Date(article.published_at);
                        const publishedUntil = article.published_until
                            ? new Date(article.published_until)
                            : null;

                        if (publishedUntil !== null) {
                            return (
                                publishedUntil > today &&
                                article.in_index === 1
                            );
                        }

                        return publishedAt <= today && article.in_index === 1;
                    });

                return sortedArticles.slice(startIndex, endIndex);
            },
            totalPages() {
                const filteredArticles = this.articles.filter(
                    (article) => article.in_index === 1
                );
                return Math.ceil(filteredArticles.length / this.perPage);
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
                return `uploads/${imageName}`;
            },
            removeStyles(section) {
                console.log('Section:', section);
                console.log('Type:', typeof section);

                if (typeof section !== 'string') {
                    return ''; // Return an empty string or handle the case when `section` is not a valid string
                }

                return section.replace(/(<([^>]+)>)/gi, ' ').replace(/ style="[^"]*"/gi, '');
            },
        },
        data () {
            return {
                currentPage: 1,
                perPage: 9,
            }
        },
        mounted() {
        },
    }
</script>
