import '../bootstrap'
import { createApp } from 'vue'
import router from './router/index'
import axios from 'axios'
import VueAxios from 'vue-axios'

const app = createApp({})
app.use(router)
app.use(VueAxios, axios)

app.mount('#app')
