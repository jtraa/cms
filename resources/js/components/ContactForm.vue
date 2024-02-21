<style>
    .grecaptcha-badge { visibility: visible !important; }

    .bgimagewithcolor {
        background-blend-mode: multiply;
        width: 100vw;
        background-size: cover;
        background-position: center;
        background-image: url(https://gevelsendaken.nl/wp-content/uploads/2021/04/Gevelengineering-en-ontwerpbegeleiding01.jpg)!important;
    }

    .v-field__field, .v-field__outline {
        padding-left: 10px;
    }

    .v-field__field {
        background-color: rgba(255, 255, 255, 0.65);
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }
    .v-field__field, .v-text-field label, .v-field__outline label {
        color: #000000;
        opacity: 1 !important;
        font-weight: 400;
    }
    .v-field--error label {
        font-weight: 700;
    }
    .v-messages__message {
        color: white;
        font-weight: 900;
    }

</style>

<template>
    <div
        class="bgimagewithcolor py-10 lg:py-24 bg-primary flex justify-center px-5 px-lg-0">
        <div class="container">
            <h2 v-if="submitted" class="text-15pt text-white text-center">Bedankt voor uw bericht.</h2>
            <v-form v-if="!submitted" @submit.prevent="submitForm">
                <v-row>
                    <v-col
                        cols="6"
                        md="2"

                    >
                        <v-text-field
                            class="br-0"
                            v-model="firstname"
                            color="secondary"
                            variant="underlined"
                            label="Voornaam"
                        ></v-text-field>
                        <span v-if="errors.firstname" class="error">{{ getErrorMessage(errors.firstname[0]) }}</span>
                    </v-col>
                    <v-col
                        cols="6"
                        md="2"

                    >
                        <v-text-field
                            class="br-0"
                            v-model="lastname"
                            color="secondary"
                            variant="underlined"
                            label="Achternaam"
                        ></v-text-field>
                        <span v-if="errors.lastname" class="error">{{ getErrorMessage(errors.lastname[0]) }}</span>
                    </v-col>
                    <v-col
                        cols="12"
                        md="2"

                    >
                        <v-text-field
                            class="br-0"
                            v-model="companyname"
                            color="secondary"
                            variant="underlined"
                            label="Bedrijfsnaam"
                        ></v-text-field>
                        <span v-if="errors.companyname" class="error">{{ getErrorMessage(errors.companyname[0]) }}</span>
                    </v-col>
                    <v-col
                        cols="12"
                        md="3"
                    >
                        <v-text-field
                            v-model="email"
                            variant="underlined"
                            color="secondary"
                            label="Email"
                        ></v-text-field>
                        <span v-if="errors.email" class="error">{{ getErrorMessage(errors.email[0]) }}</span>
                    </v-col>
                    <v-col
                        cols="12"
                        md="3"
                    >
                        <v-text-field
                            v-model="phone"
                            variant="underlined"
                            color="secondary"
                            label="Telefoonnummer"
                        ></v-text-field>
                        <span v-if="errors.phone" class="error">{{ getErrorMessage(errors.phone[0]) }}</span>
                    </v-col>
                    <v-col
                        cols="8"

                        md="2"
                    >
                        <v-text-field
                            v-model="streetname"
                            variant="underlined"
                            color="secondary"
                            label="Straatnaam"
                        ></v-text-field>
                        <span v-if="errors.streetname" class="error">{{ getErrorMessage(errors.streetname[0]) }}</span>
                    </v-col>
                    <v-col
                        cols="4"
                        md="2"
                        xl="1"
                    >
                        <v-text-field
                            v-model="housenumber"
                            variant="underlined"
                            color="secondary"
                            label="Huisnr"
                        ></v-text-field>
                        <span v-if="errors.housenumber" class="error">{{ getErrorMessage(errors.housenumber[0]) }}</span>
                    </v-col>
                    <v-col
                        cols="6"
                        md="2"
                        xl="3"
                    >
                        <v-text-field
                            v-model="postalcode"
                            color="secondary"
                            variant="underlined"
                            label="Postcode"
                        ></v-text-field>
                        <span v-if="errors.postalcode" class="error">{{ getErrorMessage(errors.postalcode[0]) }}</span>
                    </v-col>
                    <v-col
                        cols="6"
                        md="3"
                    >
                        <v-text-field
                            v-model="city"
                            color="secondary"
                            variant="underlined"
                            label="Woonplaats"
                        ></v-text-field>
                        <span v-if="errors.city" class="error">{{ getErrorMessage(errors.city[0]) }}</span>
                    </v-col>
                    <v-col
                        cols="12"
                        md="3"
                    >
                        <v-text-field
                            v-model="country"
                            color="secondary"
                            variant="underlined"
                            label="Land"
                        ></v-text-field>
                        <span v-if="errors.country" class="error">{{ getErrorMessage(errors.country[0]) }}</span>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col
                        cols="12"
                        md="12"
                    >
                        <v-textarea
                            v-model="text"
                            color="secondary"
                            variant="underlined"
                            label="Uw bericht"
                        ></v-textarea>
                        <span v-if="errors.text" class="error">{{ getErrorMessage(errors.text[0]) }}</span>
                    </v-col>
                </v-row>
                <div class="md:flex justify-between items-center">

                    <v-checkbox v-model="agreeChecked" class="md:pt-5" :label="`<p>Ik ga akkoord met de <a href='/privacy-en-cookie-policy'>privacy voorwaarden</a>.</p>`">
                        <template v-slot:label="{ label }">
                            <span v-html="label"></span>
                        </template>
                    </v-checkbox>

                    <google-re-captcha-v3
                        v-model="form.gRecaptchaResponse"
                        ref="captcha"
                        :site-key="mySiteKeyVariable"
                        id="contact_us_id"
                        class="hidden md:flex"
                        inline
                        action="contact_us"
                    ></google-re-captcha-v3>
                </div>
                <div v-if="checkbox" class="mb-5 md:mb-0">
                    <span class="error">Graag aanvinken als u akkoord met onze privacy voorwaarden.</span>
                </div>
                <v-btn type="submit" :loading="loading" block size="x-large" class="submit-btn bg-secondary text-center md:mt-5 text-white font-bold text-15pt no-underline max-w-full overflow-hidden whitespace-nowrap text-left text-ellipsis">Submit</v-btn>
            </v-form>
        </div>
    </div>
</template>

<script>
    import GoogleReCaptchaV3 from './GoogleReCaptchaV3.vue';

    export default {
        components: {
            GoogleReCaptchaV3
        },
        props: {
            settings: {
                type: Object,
            },
        },
        methods: {
            getErrorMessage(error) {
                switch (error) {
                    case 'Veld moet nog ingevuld worden.':
                        return 'Dit veld is verplicht.';
                    case 'The name field is required.':
                        return 'Het naamveld is verplicht.';
                    case 'The email field is required.':
                        return 'E-mailadres is verplicht.';
                    case 'The phone field is required.':
                        return 'Telefoonnummer is verplicht.';
                    case 'The streetname field is required.':
                        return 'Straatnaam is verplicht.';
                    case 'The housenumber field is required.':
                        return 'Huisnummer is verplicht.';
                    case 'The postalcode field is required.':
                        return 'Postcode is verplicht.';
                    case 'The city field is required.':
                        return 'Woonplaats is verplicht.';
                    case 'The country field is required.':
                        return 'Land is verplicht.';
                    case 'The text field is required.':
                        return 'Het berichtveld is verplicht.';
                    case 'The firstname field is required.':
                        return 'Voornaam is verplicht.';
                    case 'The lastname field is required.':
                        return 'Achternaam is verplicht.';
                    default:
                        return error;
                }
            },
            submitForm() {
                this.loading = true;
                if (!this.agreeChecked) {
                    this.checkbox = true;
                }

                const formData = {
                    firstname: this.firstname,
                    lastname: this.lastname,
                    companyname: this.companyname,
                    email: this.email,
                    phone: this.phone,
                    streetname: this.streetname,
                    housenumber: this.housenumber,
                    postalcode: this.postalcode,
                    city: this.city,
                    country: this.country,
                    text: this.text,
                    errors: {},
                };

                axios.post("/send-mail", formData)
                    .then((response) => {
                        this.$refs.captcha.execute();
                        console.log(response);
                        this.loading = false;
                        this.submitted = true;
                    })
                    .catch((error) => {
                        this.$refs.captcha.execute();
                        this.loading = false;
                        if (error.response && error.response.data && error.response.data.errors) {
                            this.errors = error.response.data.errors;
                            console.log(error.response.data.errors);
                        }
                    });
            },
            async checkApi (name) {
                return new Promise(resolve => {
                    clearTimeout(this.timeout)
                    this.timeout = setTimeout(() => {

                        return resolve(true)
                    }, 1000)
                })
            },
        },
        data () {
            return {
                loading: false,
                submitted: false,
                checkbox: false,
                errors: {},
                firstname: '',
                lastname: '',
                companyname: '',
                email: '',
                phone: '',
                streetname: '',
                housenumber: '',
                postalcode: '',
                city: '',
                country: '',
                text: '',
                agreeChecked: false,
                timeout: null,
                form: {
                    gRecaptchaResponse: null
                },
                mySiteKeyVariable: this.settings.recaptchakey,
            }
        },
        mounted() {
        },
    }
</script>
