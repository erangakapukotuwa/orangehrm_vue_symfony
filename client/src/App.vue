<script setup>
import Header from '@/components/common/Header.vue'
</script>

<template>
  <div id="app">
    <Header />
    <b-container fluid="sm" class="page-container">
      <router-view />
    </b-container>
  </div>
</template>

<style>
 .page-container {
    padding-top: 30px;
  }
</style>

<script>
export default {
  name: "App",
  components: {
    
  },
  data() {
    return {
    };
  }
}
</script>
