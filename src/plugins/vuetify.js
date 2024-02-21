// Styles
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'

// Vuetify
import { createVuetify } from 'vuetify'

const customDarkTheme = {
    colors: {
        background: "#ddd",
        surface: "#bcbdc0",
        primary: "#005baa",
        secondary: "#e04218",
        error: "#e04218",
    },
};

export default createVuetify({
    theme: {
        defaultTheme: "customDarkTheme",
        themes: {
            customDarkTheme,
        },
    },
});
