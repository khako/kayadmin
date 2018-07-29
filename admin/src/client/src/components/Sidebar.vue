<template>
    <nav class="panel">
        <div class="panel-heading">
            <div class="columns is-gapless">
                <div class="column is-narrow"><span class="mdi mdi-comment-account" aria-hidden="true"/></div>
                <div class="column is-narrow"><p class="is-size-6">Khalif Lahbibi</p></div>
                <div v-if="isSidebarOpen" class="column is-narrow panel-toggle" @click="toggleSidebar"><span class="mdi mdi-toggle-switch-off" aria-hidden="true"/></div>
                <div v-if="!isSidebarOpen" class="column is-narrow panel-toggle" @click="toggleSidebar"><span class="mdi mdi-toggle-switch" aria-hidden="true"/></div>
            </div>
        </div>

        <div class="panel-separator"><p><span class="mdi mdi-account-settings-variant" aria-hidden="true"/>Users</p></div>
        <router-link to="/" class="panel-block is-active">Home</router-link>
        <router-link to="/about" class="panel-block">About</router-link>

        <div class="panel-separator"><p><span class="mdi mdi-settings" aria-hidden="true"/>Settings</p></div>
        <router-link to="/" class="panel-block is-active">Home</router-link>
        <router-link to="/about" class="panel-block">About</router-link>

        <div class="panel-separator"><p><span class="mdi mdi-database" aria-hidden="true"/>Database</p></div>
        <router-link to="/" class="panel-block is-active">Home</router-link>
        <router-link to="/about" class="panel-block">About</router-link>
    </nav>
</template>

<script>
export default {

  name: 'Sidebar',

  data () {
    return {
      isSidebarOpen: true
    }
  },

  methods: {
    toggleSidebar () {
      this.isSidebarOpen = !this.isSidebarOpen
    }
  }
}
</script>

<style lang="sass" scoped>
@import "../assets/sass/_init.sass"

.panel
    min-height: 100vh
    border-right: 1px solid #dbdbdb
    &-block, &-heading
        border-right: none
    &-heading
        border-radius: 0
        min-height: 3.25rem
        span
            margin-right: 10px
        .columns
            align-items: baseline
            .column.is-narrow:last-child
                margin-left: auto
    &-toggle
        cursor: pointer
        color: $primary
    &-separator
        border-bottom: 1px solid whitesmoke
        display: block
        text-align: center
        margin-top: 20px
        margin-bottom: 10px
        p
            position: relative
            transform: translateY(50%)
            text-align: center
            background: white
            display: inline-block
            margin: auto
            padding: 0 20px
            span
                margin-right: 10px
.mdi-view-dashboard
    color: $primary
    vertical-align: middle
</style>
