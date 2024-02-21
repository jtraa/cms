<style>
    .v-card--reveal {
        align-items: center;
        bottom: 0;
        justify-content: center;
        opacity: .9;
        position: absolute;
        width: 100%;
    }
    .v-breadcrumbs-item--link:hover {
        color: #005ba9;
        text-decoration: none;
    }
     .v-breadcrumbs-item {
        padding: 0;
     }

</style>

<template>
    <div
        class="bg-white flex justify-center">
        <div class=" justify-center container align-items grid lg:flex py-5 lg:py-24 px-5 lg:px-0">
            <div class="container">
                <v-breadcrumbs class="pb-10 px-0" :items="items"></v-breadcrumbs>
                <div class="flex gap-10 justify-between flex-wrap">
                    <div class="w-full md:w-3/12 flex justify-left order-1 order-2">
                        <img :alt="employee.first_name +' '+ employee.last_name"  :src="getImageUrl(employee.image_with_size)" class="w-full" style="min-height:500px; min-width:333px; max-height:500px; max-width:333px;"/>
                    </div>
                    <div class="md:w-8/12 mb-5 md:mb-0 lg:order-2  order-1">
                        <h2 class="text-15pt text-shadow lg:text-30pt text-primary font-bold">{{employee.first_name}} {{employee.last_name}}</h2>
                        <div v-html="employee.about" />
                        <v-btn
                            value="Save Task"
                            type="submit"
                            v-if="employee.telephone !== undefined"
                            :href="`tel:${employee.telephone}`"
                            size="x-large"
                            class="bg-secondary text-center mt-5 text-white font-bold text-15pt no-underline max-w-full lg:max-w-600px overflow-hidden whitespace-nowrap text-left text-ellipsis"
                        >
                            Bel mij direct!
                        </v-btn>
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
            employee: {
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
                        title: 'Team',
                        disabled: false,
                        href: '/team',
                    },
                    {
                        title: this.employee.first_name + ' ' + this.employee.last_name,
                        disabled: true,
                    },
                ],
            }
        },
        methods: {
            getImageUrl(imageName) {
                return `/uploads/${imageName}`;
            },
        },
        mounted() {
            console.log(this.employee);
        },
    }
</script>
