// import '../bootstrap'
import { createApp } from 'vue'
import router from './router/index'
import axios from 'axios'
import VueAxios from 'vue-axios'
import { Quasar } from 'quasar'
// Import Quasar css
import 'quasar/dist/quasar.css'
// Import icon libraries
import '@quasar/extras/material-icons/material-icons.css'
import '@quasar/extras/material-icons-outlined/material-icons-outlined.css'

const app = createApp({})
app.use(router)
app.use(VueAxios, axios)

app.use(Quasar, {
  plugins: {}
})

app.mount('#app')
