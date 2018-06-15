<template>
  <div class="front">
    <h1>Frontpage</h1>

    <div class="view" v-if="communicationError === ''">
      <h2>Drupal nodes:</h2>
      <ul>
        <router-link v-for="(link, index) in viewData" tag="li" :key="index" :to="'/node/' + link.nid">{{ link.title }}</router-link>
      </ul>

      <h3>RAW Data:</h3>
      {{ viewData }}
    </div>

    <div class="error" v-if="communicationError !== ''">
      <h2>Communication Error</h2>
      {{ communicationError }}
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      viewData: {},
      communicationError: ''
    }
  },
  methods: {
    fetchData () {
      let url = 'http://headless_drupal.docker.localhost:8000/api/rest/articles'
      let options = {
        url: url,
        method: 'GET'
      }
      this.$http(options).then(response => {
        this.viewData = response.body
        this.afterSucessfullFetch()
      }, response => {
        this.communicationError = response
      })
    },
    afterSucessfullFetch () {
      console.log('View data fetched')
    }
  },
  created: function (done) {
    this.fetchData()
  },
  watch: {
    '$route' () {
      this.fetchData()
    }
  }
}
</script>

<style scopped>
  .view{
    max-width: 800px;
    margin: 30px auto;
  }
  .view li{
    margin: 5px 0;
    display: block;
    font-size: 20px;
    font-weight: bold;
    cursor: pointer;
  }
  h3 {
    margin-top: 50px;
  }
</style>
