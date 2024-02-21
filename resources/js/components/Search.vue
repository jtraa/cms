<style>
     .searchbar.v-text-field .v-input__details, .searchbar.v-text-field .v-messages {
        min-height: 1px;
         padding: 0;
         margin: 0;
    }
</style>

<template>
    <v-text-field @keydown.enter="handleEnter" class="searchbar mb-0 pb-0 min-w-250px" type="text" color="primary" id="searchKeyword" placeholder="Zoek naar sleutelwoord" />
    <v-btn class="py-7 rounded-0 bg-primary w-full" @click="searchWebsite()">Zoeken</v-btn>
</template>

<script>

    export default {
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
    }
</script>
