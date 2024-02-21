<style>

    .v-btn.bg-secondary:hover {
        background-color: #BF2000 !important;
    }
    .grecaptcha-badge { visibility: hidden; }

    ul.v-pagination__list li::before {
        text-decoration: none !important;
        content:"";

    }

    p a {
        text-decoration: underline !important;
    }
    p a:hover {
        text-decoration: none !important;
    }

</style>

<template>
    <v-app id="scroll-threshold-example" class=" bg-white flex flex-col min-h-screen">
        <div class="flex-1">
            <Navigation :pages="pages" :services="services" v-bind="websiteData" :isActive="true" :settings="settings" />
            <div v-if="service != null">
                <ServiceDetail :service="service" />
            </div>
            <div v-if="article != null">
                <ArticleDetail :article="article" />
            </div>
            <div v-if="employee != null">
                <EmployeeDetail :employee="employee" />
            </div>
            <DynamicRenderer
                v-bind="websiteData" :isActive="true"
                :sections="sections" :services="services"
                :employees="employees" :articles="articles"
                :settings="settings" :pages="pages"
            />
        </div>
        <Footer class="mt-auto" :pages="pages" :services="services" v-bind="websiteData" :settings="settings" :isActive="true" />
    </v-app>
</template>

<script>

import Navigation from './components/Navigation.vue';
import DynamicRenderer from "./components/DynamicRenderer.vue";
import EmployeeDetail from "./components/EmployeeDetail.vue";
import ServiceDetail from "./components/ServiceDetail.vue";
import ArticleDetail from "./components/ArticleDetail.vue";
import Footer from "./components/Footer.vue";

export default {
    data() {
        return {
            websiteData: {
                alt: 'Kettlitz Gevel- en Dakadvies',
                maps: 'https://www.google.com/maps?q=itraa+maps&um=1&ie=UTF-8&sa=X&ved=2ahUKEwjKutib8Ij9AhXggf0HHXzVBrUQ_AUoAXoECAEQAw',
                isActive: false,
            }
        }
    },
    props: {
        pages: {
            type: Object,
        },
        services: {
            type: Array,
        },
        sections: {
            type: Array,
        },
        employees: {
            type: Array,
        },
        articles: {
            type: Array,
        },
        settings: {
            type: Object,
        },
        employee: {
            type:Object,
        },
        service: {
            type:Object,
        },
        article: {
            type:Object,
        },
    },
    components: {
        Navigation,
        DynamicRenderer,
        ArticleDetail,
        EmployeeDetail,
        ServiceDetail,
        Footer,
    },
    methods: {

    },
    mounted () {

    },
}

</script>
