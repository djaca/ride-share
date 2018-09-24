<template>
  <div>
    <multiselect
      v-model="city"
      :placeholder="placeholder"
      :id="name"
      :options="options"
      :loading="isLoading"
      trackBy="id"
      label="name"
      :internal-search="false"
      :options-limit="5"
      :show-no-results="true"
      :hide-selected="true"
      :multiple="multiple"
      @search-change="asyncFind"
      @select="updateHiddenInput"
      @remove="removeOption"
    >
      <span slot="noResult">Oops! No city found.</span>
    </multiselect>

    <input type="hidden" :name="name" v-for="city in selectedCities" :value="city.id">
  </div>
</template>

<script>
  import Multiselect from 'vue-multiselect'

  export default {
    name: 'EnrouteCities',

    components: {Multiselect},

    mounted () {
      if (this.old) {
        this.old.forEach(id => {
          axios.get(`/api/cities/${id}`)
            .then(response => {
              this.city.push(response.data)
              this.selectedCities.push(response.data)
            })
        })
        // axios.get(`/api/cities/${this.old}`).then(response => {
        //   this.city.push(response.data)
        // })
      }
    },

    props: {
      multiple: {
        type: Boolean,
        default: false
      },

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
        required: false
      },

      oldValue: {
        required: false
      }
    },

    data () {
      return {
        city: [],
        options: [],
        selectedCities: [],
        isLoading: false
      }
    },

    computed: {
      old () {
        return JSON.parse(this.oldValue)
      }
    },

    methods: {
      asyncFind (query) {
        this.isLoading = true

        axios.get('/api/cities', {params: {keywords: query}})
          .then(response => {
            this.isLoading = false

            this.options = response.data.map(city => {
              return {
                id: city.id,
                name: city.name,
              }
            })
          })
      },

      updateHiddenInput (value) {
        this.multiple ? this.selectedCities.push(value) : this.selectedCities = [value]
      },

      removeOption (removedOption) {
        this.selectedCities.splice(this.selectedCities.findIndex(c => c.id === removedOption.id), 1)
      }
    }
  }
</script>

<style scoped>

</style>
