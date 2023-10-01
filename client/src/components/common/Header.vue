<template>
    <div>
        <div>
            <b-navbar toggleable="lg" type="dark" variant="dark">
                <b-navbar-brand href="#">OrangeHRM</b-navbar-brand>
                <!-- Right aligned nav items -->
                <b-navbar-nav right >
                    <b-nav-item href="#" @click="doLogout()">Sign out</b-nav-item>
                </b-navbar-nav>
            </b-navbar>
        </div>
    </div>
</template>
<style>
    .navbar {
        padding: .5rem 1rem;
    }
</style>

<script>

export default {
  name: "Header",
  components: {
    
  },
  data() {
    return {
    };
  },
  methods: {
    /** TODO : ideally the token should be deleted from back-end as well. 
    * Leaving it for now with the time limitation
    * */
    async doLogout() {
        localStorage.removeItem('currentUser');
        this.$router.push({path: "/"});
    }
  }
}
</script>