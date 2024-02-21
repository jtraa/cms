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
        class="bg-white flex justify-center">
        <div class="container">
            <v-breadcrumbs class="py-5 px-4 lg:px-0" :items="items"></v-breadcrumbs>
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
            service: {
                type: Object,
            }
        },
        computed: {
            filteredServices() {
                const today = new Date();
                return this.services
                    .sort((a, b) => a.order - b.order)
                    .filter(service => {
                        const publishedAt = new Date(service.published_at);
                        const publishedUntil = new Date(service.published_until);
                        return (
                            service.in_menu !== 0 &&
                            publishedUntil > today &&
                            publishedAt <= today
                        );
                    });
            },
        },
        data () {
            return {
                items: [
                    {
                        title: 'Diensten',
                        disabled: false,
                        href: '/diensten',
                    },
                    {
                        title: this.service.title,
                        disabled: true,
                    },
                ],
            }
        },
        mounted() {
            console.log(this.service.title);
        },
    }
</script>
