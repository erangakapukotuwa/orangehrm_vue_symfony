<template>
  <div>
    <Loading :isLoading="isLoading" />
    <ResponseError v-if="error"  :hasError="hasError" :error="error" />
    <b-row class="justify-content-md-center">
      <h2>Login Form</h2>  
        <div>
          <form>
            <div class="form-row">
              <div class="form-group">
                <input
                  v-model="username"
                  type="text"
                  class="form-control"
                  placeholder="Username"
                >
              </div>
              <div class="form-group">
                <input
                  v-model="password"
                  type="password"
                  class="form-control"
                  placeholder="Password"
                >
              </div>
              <div class="form-group">
                <button
                  :disabled="username.length === 0 || password.length === 0 || isLoading"
                  type="button"
                  class="btn btn-primary"
                  @click="doLogin()">
                  Login
                </button>
              </div>
            </div>
          </form>
        </div>
    </b-row>
  </div>
  
</template>
<style>
h2 {
    margin-bottom: 30px;
}
.form-group {
    margin-bottom: 30px;
}
</style>

<script>
import { mapMutations } from "vuex";
import Loading from '../common/Loading.vue'
import ResponseError from '../common/ResponseError.vue'

export default {
  name: "LoginForm",
  components: {
    Loading,
    ResponseError
  },
  data() {
    return {
      username: "",
      password: "",
      show: true
    };
  },
  computed: {
    isLoading() {
      return this.$store.getters["user/isLoading"];
    },
    hasError() {
      return this.$store.getters["user/hasError"];
    },
    error() {
      return this.$store.getters["user/error"];
    }
  },
  created() {
    let redirect = this.$route.query.redirect;
    if (this.$store.getters["user/isAuthenticated"]) {
      if (typeof redirect !== "undefined") {
        this.$router.push({path: redirect});
      } else {
        this.$router.push({path: "/"});
      }
    }
  },
  methods: {
    async doLogin() {
      let payload = {username: this.$data.username, password: this.$data.password};
      // redirect = this.$route.query.redirect;

      var result = await this.$store.dispatch("user/login", payload);
      const { token, employeeId } =  result;
      if (!this.$store.getters["user/hasError"]) {
        localStorage.setItem("currentUser", JSON.stringify({
          "token" : token,
          "employeeId": employeeId
        }));
        if (typeof redirect !== "undefined") {
          this.$router.push({path: redirect});
        } else {
          this.$router.push({path: "/employee"});
        }
      }
    }
  }
}
</script>