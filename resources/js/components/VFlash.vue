<template>
  <div :class="classes"
       role="alert"
       v-show="show"
       v-text="body"
  ></div>
</template>

<script>
  export default {
    name: 'VFlash',

    props: ['message'],

    data () {
      return {
        body: this.message ? JSON.parse(this.message).message : '',
        level: this.message ? JSON.parse(this.message).level : '',
        show: false
      }
    },

    computed: {
      classes () {
        let defaults = ['mb-1', 'p-4', 'border', 'text-brand-lightest']

        if (this.level === 'success') defaults.push('bg-green', 'border-green-dark')
        if (this.level === 'warning') defaults.push('bg-yellow', 'border-yellow-dark')
        if (this.level === 'danger') defaults.push('bg-red', 'border-red-dark')
        if (this.level === 'info') defaults.push('bg-blue', 'border-blue-dark')

        return defaults
      }
    },

    created () {
      if (this.message) {
        this.flash()
      }

      window.events.$on(
        'flash', data => this.flash(data)
      )
    },

    methods: {
      flash (data) {
        if (data) {
          this.body = data.message
          this.level = data.level
        }

        this.show = true

        this.hide()
      },

      hide () {
        setTimeout(() => {
          this.show = false
        }, 3000)
      }
    }
  }
</script>
