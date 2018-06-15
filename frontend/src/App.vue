<template>
  <div id="app">
    <header>
      <span>Workshop test SPA app</span>
    </header>
    <main>
      <div class="menu">
        <ul>
          <router-link tag="li" :to="'/'">Go to list</router-link>
        </ul>
      </div>
      <img src="./assets/logo.png" alt="Vue.js PWA">
      <router-view></router-view>
    </main>
  </div>
</template>

<script>
export default {
  name: 'app'
}
</script>

<style>
body {
  margin: 0;
}

#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
}

main {
  text-align: center;
  margin-top: 40px;
}

header {
  margin: 0;
  height: 56px;
  padding: 0 16px 0 24px;
  background-color: #35495E;
  color: #ffffff;
}

header span {
  display: block;
  position: relative;
  font-size: 20px;
  line-height: 1;
  letter-spacing: .02em;
  font-weight: 400;
  box-sizing: border-box;
  padding-top: 16px;
  text-align: center;
}

.menu li {
  cursor: pointer;
}

h1, h2 {
  margin-top: 50px;
  font-weight: normal;
}

ul {
  list-style-type: none;
  padding: 0;
}

li {
  display: inline-block;
  margin: 0 10px;
}

a {
  color: #35495E;
}

.error {
  padding: 20px;
  background-color: red;
  color: #fff;
  max-width: 800px;
  margin: 50px auto 0 auto;
}

.error h2{
  color: #fff;
  margin-top: 0;
}

</style>
