<template>
  <div>
    <multiselect
      class="multi"
      v-model="city"
      :placeholder="placeholder"
      trackBy="id"
      :id="name"
      label="name"
      :options="cities"
      :loading="isLoading"
      :internal-search="false"
      :options-limit="5"
      :show-no-results="true"
      :hide-selected="true"
      @search-change="asyncFind"
    >

      <template slot="option" slot-scope="props">
        <div class="option__desc">
          <span class="option__title">{{ props.option.name }}</span>
          <span class="option__small text-xs">{{ props.option.country }}</span>
        </div>
      </template>

      <span slot="noResult">Oops! No city found.</span>

    </multiselect>
    <input type="hidden" :name="name" :value="setInputValue">
  </div>
</template>

<script>
  import Multiselect from 'vue-multiselect'

  export default {
    components: {
      Multiselect
    },

    mounted () {
      if (this.oldValue) {
        axios.get(`/api/cities/${this.oldValue}`).then(response => {
          this.city = response.data
        })
      }
    },

    props: {
      name: {
        type: String,
        required: true
      },

      placeholder: {
        type: String,
        required: false
      },

      value: {
        type: String,
        required: true
      },

      oldValue: {
        required: false
      }
    },

    data () {
      return {
        city: null,
        cities: [],
        isLoading: false
      }
    },

    watch: {
      city: function (city) {
        this.$emit('city-changed', {city})
      }
    },

    computed: {
      setInputValue () {
        return this.city ? this.city[this.value] : ''
      }
    },

    methods: {
      asyncFind (query) {
        this.isLoading = true

        axios.get('/api/cities', {params: {keywords: query}}).then(response => {
          this.isLoading = false
          this.cities = response.data
        })
      }
    }
  }
</script>
