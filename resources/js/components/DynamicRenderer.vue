<template>
    <div class="root">
        <component v-for="section in sections" :key="section.id" :is="section.title" :section="section" :services="services" :articles="articles" :employees="employees" :settings="settings" :pages="pages" />
    </div>
</template>

<script>
    import Header from "./Header.vue";
    import Images from "./Images.vue";
    import Wysiwyg from "./Wysiwig.vue";
    import Gallery from "./Gallery.vue";
    import Paragraph from "./Paragraph.vue";
    import Paragraphwithbluebackground from "./Paragraphwithbluebackground.vue";
    import Paragraphwithservicesright from "./Paragraphwithservicesright.vue";
    import Paragraphwithimageleft from "./Paragraphwithimageleft.vue";
    import Paragraphwithimageright from "./Paragraphwithimageright.vue";
    import Paragraphwithbuttonright from "./Paragraphwithbuttonright.vue";
    import Employees from './Employees.vue';
    import Services from './Services.vue';
    import Articles from './Articles.vue';
    import Blocks from './Blocks.vue';
    import ContactForm from "./ContactForm.vue";
    import ServiceDetail from "./ServiceDetail.vue";
    import SearchBar from "./SearchBar.vue";

    export default {
        data () {
            return {
                data: {},
                name: "DynamicRenderer",
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
            }
        },
        props: {
            sections: {
                type: Array,
            },
            services: {
                type: Array,
            },
            settings: {
                type: Object,
            },
            employees: {
                type: Array,
            },
            articles: {
                type: Array,
            },
            article: {
                type: Object,
            },
            pages: {
                type: Object,
                required: true
            },
        },
        components: {
            Blocks,
            ContactForm,
            Header,
            Images,
            Gallery,
            Wysiwyg,
            Paragraph,
            Paragraphwithimageleft,
            Paragraphwithimageright,
            Employees,
            Services,
            Articles,
            Paragraphwithbluebackground,
            Paragraphwithservicesright,
            Paragraphwithbuttonright,
            ServiceDetail,
            SearchBar,
        },
        mounted () {
            console.log(this.sections);
        },
    };
</script>

<style scoped>
    .root {
        background-color: white;
    }
</style>
