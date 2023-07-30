// import '../bootstrap'
import { createApp } from 'vue'
import router from './router/index'
import axios from 'axios'
import VueAxios from 'vue-axios'
import { Quasar } from 'quasar'
// Import Quasar css
import 'quasar/dist/quasar.css'

const app = createApp({})
app.use(router)
app.use(VueAxios, axios)

app.use(Quasar, {
  plugins: {} // import Quasar plugins and add here
})

app.mount('#app')
