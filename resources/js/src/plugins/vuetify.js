import { createApp } from 'vue'
import 'vuetify/dist/vuetify.min.css'
import colors from 'vuetify/lib/util/colors'

const app = createApp({});
app.mount('#app');

const opts = {}

export default new Vuetify({
    icons: {
        iconfont: 'md' || 'mdi' || 'mdiSvg' || 'md' || 'fa' || 'fa4'
    },
    theme: {
        themes: {
            light: {
                primary: '#005baa', // Blue
                secondary: #e04218, // Orange
                accent: #bcbdc0, // Grey
            },
        },
    },
})

