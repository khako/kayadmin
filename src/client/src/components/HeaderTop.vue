<template>
    <nav class="navbar">
        <div class="navbar-brand">
            <div class="navbar-burger burger">
                <span/>
                <span/>
                <span/>
            </div>
        </div>
        <div class="navbar-menu">
            <div class="navbar-start"/>
            <div class="navbar-end">
                <div class="navbar-item">
                    <div class="field is-grouped">
                        <p class="control">
                            <a class="button" href="https://github.com/jgthms/bulma/releases/download/0.7.1/bulma-0.7.1.zip">
                                <span>Logout</span>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
export default {

  name: 'HeaderTop',

  data () {
    return {

    }
  }
}
</script>

<style lang="sass" scoped>
@import "../assets/sass/_init.sass"

.navbar
    background:  $light
    border-bottom: 1px solid $border
</style>
