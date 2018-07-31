import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import Buefy from 'buefy'

Vue.use(Buefy)

Vue.config.productionTip = false

new Vue({
  router,
  store,
  async created () {
    await this.$store.dispatch('database/fetch')
    console.log(this.$store)
  },
  render: h => h(App)
}).$mount('#app')
