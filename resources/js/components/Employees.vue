<style>
    .v-card--reveal {
        align-items: center;
        bottom: 0;
        justify-content: center;
        opacity: .9;
        position: absolute;
        width: 100%;
    }

</style>

<template>
    <div
        class=" flex justify-center">
        <div class="w-full justify-center container align-items lg:flex py-5 px-5 lg:px-0">
            <div class="container">
                <h2 class="text-15pt text-shadow lg:text-30pt text-primary mb-5 font-bold">Team Kettlitz Gevel en Dakadvies</h2>
                <div class="flex gap-5 justify-center md:justify-start flex-wrap">
                    <div class="" v-for="employee in filteredEmployees">
                        <a :href="`/team/${employee.slug}`">
                        <v-hover v-slot="{ isHovering, props }">
                            <v-card
                                class="mx-auto"
                                color="grey-lighten-4"

                                v-bind="props"
                            >

                                <v-img
                                    cover
                                    :aspect-ratio="18/18"
                                    :alt="employee.first_name +' '+ employee.last_name"
                                    :src="getImageUrl(employee.image_with_size)"
                                    min-width="333px"
                                    min-height="500px"
                                    >
                                    <v-expand-transition>
                                        <div
                                            v-if="isHovering"
                                            class="d-flex transition-fast-in-fast-out bg-secondary v-card--reveal text-center"
                                            style="height: 100%;"
                                        >
                                            <div>
                                                <h2 class="text-15pt text-shadow lg:text-24pt font-bold mb-0 text-white">{{employee.first_name}} {{employee.last_name}}</h2>
                                                <p class="text-10pt text-shadow lg:text-15pt text-white">{{employee.email}}</p>
                                            </div>
                                        </div>
                                    </v-expand-transition>
                                </v-img>
                            </v-card>
                        </v-hover>
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
            employees: {
                type: Array,
            }
        },
        computed: {
            filteredEmployees() {
                const today = new Date();
                return this.employees
                    .sort((a, b) => a.order - b.order)
                    .filter(employee => {
                        const publishedAt = new Date(employee.published_at);
                        const publishedUntil = employee.published_until ? new Date(employee.published_until) : null;

                        if (publishedUntil !== null) {
                            return publishedUntil > today && employee.in_index === 1;
                        }

                        return publishedAt <= today && employee.in_index === 1;
                    });
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
            console.log(this.employees);
        },
        methods: {
            getImageUrl(imageName) {
                return `uploads/${imageName}`;
            },
        }
    }
</script>
