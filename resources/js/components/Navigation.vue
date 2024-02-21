<style>
    .active {
        color: #e04218;
        font-weight: 500;
    }
    .navigation .v-list-item {
        display: flex;
        padding: 0;
    }
    .navigation .v-list-item--density-default.v-list-item--one-line, .navigation .v-list-item--density-default:not(.v-list-item--nav).v-list-item--one-line {
        padding: 0;
    }
    .submenu .v-list-item--density-default.v-list-item--one-line {
        min-height: 0;
    }

     .v-list.navigation {
         padding: 0;
         margin: 0;
         height: 100%;
    }
    .navigation {
        padding: 0;
    }
    .navigation .v-list-item_content {
        width: 100%;
        height: 100%;
    }
    .navigation .v-list-item__content {
        width: 100%;
        height: 100%;
    }
    .submenu a {
        min-height: 50px;
    }

    .navigation a {
        align-items: center;
        display: flex;
        height: 100%;
        padding: 4px 16px;
        width: 100%;
    }

</style>

<template v-slot:default="{ props }">
    <div class="justify-center flex w-full bg-primary" :class="pagePaddingOrange">
        <div class="justify-center flex w-full bg-secondary" :class="pagePaddingBlue">
            <div class="w-full">
               <v-card
                    color="white"
                    flat
                    rounded="0"
                    class="justify-center flex w-full"
                >

                    <v-toolbar
                        color="white"
                        class="container"
                    >
                        <v-toolbar-title
                            class="lg:mx-0"
                        >
                            <a href="/" id="logo" class="text-darkblue" :aria-label="settings.websitename">
                                <img class="h-10" :src="'/uploads/' + settings.image_with_size" :alt="settings.websitename">
                            </a>
                        </v-toolbar-title>

                        <v-spacer></v-spacer>
                        <div class="w-3/4 h-full hidden lg:block">


                            <v-list class="navigation flex justify-end w-full hidden lg:flex" lines="one"
                                    rounded="xl" bg-color="white">
                                    <v-list-item class="hover:text-primary" v-for="(page, id) in sortedPages" :key="id">
                                            <a v-if="page.id !== 1 && page.id !== 8 && page.id !== 9" :class="{ active: page.isActive }" :href="'/' + page.slug">{{ page.title }}</a>
                                            <a v-if="page.id === 8" :class="{ active: getCurrentURL().includes(`/${page.slug}`) }" :href="'/' + page.slug">{{ page.title }}</a>
                                        <v-menu v-if="page.id === 1" class="submenu w-full" open-on-hover open-delay="05" close-delay="300">
                                            <template v-slot:activator="{ props }">
                                                    <a v-bind="props" :class="{ active: page.isActive }" :href="'/' + page.slug" class="text-darkblue">{{ page.title }} <v-icon color="primary" size="22">mdi-menu-down</v-icon></a>
                                            </template>
                                            <v-list class="navigation" bg-color="white">
                                                <v-list-item v-for="(service, id) in filteredServices" :key="id" :color="isHovering ? 'primary' : undefined">
                                                    <a :href="`/${page.slug}/${service.slug}`" :class="{ active: service.isActive }" class="hover:text-primary  hover:bg-gray-100">{{ service.title }}</a>
                                                </v-list-item>
                                            </v-list>
                                        </v-menu>
                                        <v-menu v-if="page.id === 9" class="submenu w-full" open-on-hover open-delay="05" close-delay="300">
                                            <template v-slot:activator="{ props }">
                                                <a v-bind="props" class="text-darkblue" :class="{ active: getCurrentURL().includes(`/${page.slug}`) }" :href="`/${page.slug}`">{{ page.title }} <v-icon color="primary" size="22">mdi-menu-down</v-icon></a>
                                            </template>
                                            <v-list class="navigation" bg-color="white">
                                                <v-list-item>
                                                    <a class="hover:text-primary h-full hover:bg-gray-100" :class="{ active: getCurrentURL().includes(`/${page.slug}`) }" :href="`/${page.slug}`">Medewerkers</a>
                                                </v-list-item>
                                                <v-list-item>
                                                    <a target="_blank" class="hover:text-primary  hover:bg-gray-100" href="https://esg.works/werkenbij/tech">Werken bij</a>
                                                </v-list-item>
                                            </v-list>
                                        </v-menu>
                                    </v-list-item>
                            </v-list>
                        </div>
                        <v-menu
                            class="w-full" :location="location">
                            <template v-slot:activator="{ props }" >
                                <v-app-bar-nav-icon
                                    class=""
                                    color="primary"
                                    icon="mdi-magnify"
                                    v-bind="props"
                                    aria-label="search-button"
                                ></v-app-bar-nav-icon>
                            </template>
                            <v-list class=" w-full p-0 m-0"
                                    bg-color="white" @click="stopListClose">
<!--                                <v-list-item class="w-full" @click="stopListClose">-->
                                    <Search class="p-0 m-0" @click="stopListClose" />
<!--                                </v-list-item>-->
                            </v-list>
                        </v-menu>
                        <v-menu
                        class="lg:hidden submenu w-full" :location="location">
                            <template v-slot:activator="{ props }" >
                                <v-app-bar-nav-icon
                                    class="lg:hidden"
                                    color="primary"
                                    v-bind="props"
                                    aria-label="menu-button"
                                >
                                </v-app-bar-nav-icon>
                            </template>
                            <v-list class="navigation"
                                bg-color="white">
                                <v-list-item class="" v-for="page in sortedPages">
                                    <a class="w-full h-full hover:text-primary text-center hover:bg-gray-100" :class="{ active: page.isActive }" :href="'/' + page.slug">
                                        <v-list-item-content class="w-full h-full">
                                            <v-list-item-title class="w-full h-full text-no-wrap px-5">{{ page.title }}</v-list-item-title>
                                        </v-list-item-content>
                                    </a>
                                </v-list-item>
                            </v-list>
                        </v-menu>

                    </v-toolbar>

                </v-card>
            </div>
        </div>
    </div>
</template>

<script>

import * as easings from 'vuetify/lib/services/goto/easing-patterns';
import Search from "./Search.vue";

export default {
    components: {
        Search,
    },
    data () {
        return {
            type: 'selector',
            number: 9999,
            selector: '#ontdek',
            selections: ['#first', '#second', '#third'],
            pageIds: [2, 9],
            selected: 'Button',
            elements: ['Button', 'Radio group'],
            duration: 1000,
            offset: 50,
            easing: 'easeInOutCubic',
            easings: Object.keys(easings),
            location: 'bottom',
            isHovered: false
        }
    },
    props: {
        pages: {
            type: Object,
            required: true
        },
        services: {
            type: Array,
        },
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
        settings: {
            type: Object,
        },

    },
    methods: {
        getCurrentURL() {
            return window.location.href
        },
        stopListClose(event) {
            event.stopPropagation();
        },
    },
    mounted() {
        console.log(this.settings);
    },
    computed: {
        target () {
            const value = this[this.type]
            if (!isNaN(value)) return Number(value)
            else return value
        },
        options () {
            return {
                duration: this.duration,
                offset: this.offset,
                easing: this.easing,
            }
        },
        element () {
            if (this.selected === 'Button') return this.$refs.button
            else if (this.selected === 'Radio group') return this.$refs.radio
            else return null
        },
        filteredServices() {
            const today = new Date();
            const currentURL = this.getCurrentURL();
            return this.services
                .sort((a, b) => a.order - b.order)
                .map(service => {
                    const isActive = currentURL.endsWith(`${service.slug}`);
                    return {
                        ...service,
                        isActive
                    };
                })
                .filter(service => {
                    const publishedAt = new Date(service.published_at);
                    return (
                        service.in_menu !== 0 &&
                        publishedAt <= today
                    );
                });
        },
        pagePaddingOrange() {
            const currentPage = this.getCurrentURL();
            return {

                'pb-8': !currentPage.endsWith('/home'),
            };
        },
        pagePaddingBlue() {
            const currentPage = this.getCurrentURL();
            return {
                'pb-2': !currentPage.endsWith('/home'),
            };
        },
        sortedPages() {
            const pagesArray = Object.values(this.pages);
            const currentURL = this.getCurrentURL();
            const isDienstenActive = this.filteredServices.some(service => service.isActive);

            return pagesArray
                .sort((a, b) => a.order - b.order)
                .map(page => {
                    if (page.id === 1) {
                        return {
                            ...page,
                            isActive: currentURL.endsWith(page.slug) || isDienstenActive

                        };
                    }
                    return {
                        ...page,
                        isActive: currentURL.endsWith(page.slug)
                    };
                });
        },
    },
}
</script>
