<template>
    <div id="app">
        <div class="columns is-gapless">
            <div class="column is-3">
                <sidebar/>
            </div>

            <div class="column is-9">
                <header-top/>
                <router-view/>
            </div>

        </div>
    </div>
</template>

<script>
import Sidebar from '@components/Sidebar'
import HeaderTop from '@components/HeaderTop'

export default {
  components: {
    Sidebar,
    HeaderTop
  }
}
</script>

<style lang="sass">
@import "assets/sass/_init.sass"

@import "~bulma"
@import "~buefy/src/scss/buefy"

</style>
