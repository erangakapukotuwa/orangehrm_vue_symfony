import Vue from "vue";
import Vuex from "vuex";
import EmployeeModule from "./employee";
import UserModule from "./user";


Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    employee: EmployeeModule,
    user: UserModule
  }
});