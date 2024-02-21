<style>

</style>

<template>
    <div class="justify-center pt-8 hidden lg:flex">
        <div class="container flex items-center justify-end">
            <div class="w-full lg:w-1/2">
                <div class="flex items-center justify-end">
                    <div class="w-full px-5 md:px-0 xl:w-47">
                        <div class="flex justify-end w-full border-blue-900">
                            <SearchForHome />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import SearchForHome from "./SearchForHome.vue";

    export default {
        components: {
            SearchForHome,
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
            articles: {
                type: Array,
            },
        },
        computed: {

        },
        data () {
            return {

            }
        },
        methods: {
            searchWebsite() {
                var searchKeyword= document.getElementById("searchKeyword").value.toLowerCase();
                var domain = window.location.href;
                var lastSlashIndex = domain.lastIndexOf("/");
                var extractedURL = domain.substring(0, lastSlashIndex)
                console.log(extractedURL);
                var searchUrl = "https://www.google.com/search?q=site:" + extractedURL + " " + encodeURIComponent(searchKeyword);
                window.open(searchUrl);
            },
            handleEnter() {
                this.searchWebsite();
            },
        },
        mounted() {
        },
    }
</script>
