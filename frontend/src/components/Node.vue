<template>
  <div class="drupal-node">
    <h1>Drupal Node</h1>
    <p v-if="Number(parseFloat(nid)) != nid || nid == 0">Check url :)</p>
    <template v-else>
      <div class="node" v-if="communicationError === ''">
        <h2 v-if="nodeData.title && nodeData.title[0]" v-html="nodeData.title[0].value"></h2>
        <p v-if="nodeData.body && nodeData.body[0]" v-html="nodeData.body[0].value"></p>
        <img v-if="nodeData.field_image && nodeData.field_image[0]" :src="nodeData.field_image[0].url" :alt="nodeData.field_image[0].alt">
        <h3>RAW Data:</h3>
        {{ nodeData }}
      </div>
    </template>

    <div class="error" v-if="communicationError !== ''">
      <h2>Communication Error</h2>
      {{ communicationError }}
    </div>
  </div>
</template>

<script>
export default {
  props: {
    nid: {
      type: String
    }
  },
  data () {
    return {
      nodeData: {},
      communicationError: ''
    }
  },
  methods: {
    fetchData () {
      let url = 'http://headless_drupal.docker.localhost:8000/node/' + this.$props.nid + '?_format=json'
      let options = {
        url: url,
        method: 'GET'
      }
      this.$http(options).then(response => {
        this.nodeData = response.body
        this.afterSucessfullFetch()
      }, response => {
        this.communicationError = response
      })
    },
    afterSucessfullFetch () {
      console.log('Node data fetched')
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

<style scoped>
  .node{
    max-width: 800px;
    margin: 30px auto;
  }
  .node img{
    max-width: 100%;
    height: auto;
  }
</style>
