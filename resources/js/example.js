// this runs in Node.js on the server.
import { createSSRApp } from 'vue'
// Vue's server-rendering API is exposed under `vue/server-renderer`.
import { renderToString } from 'vue/server-renderer'

const app = createSSRApp({

})

app.mount('#website')
app.component('Welcome', Welcome)

renderToString(app).then((html) => {
    console.log(html)
})
