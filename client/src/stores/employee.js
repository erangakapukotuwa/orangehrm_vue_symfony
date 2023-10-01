import EmployeeAPI from "../api/employee";
import { mapGetters } from "vuex";

const 
  FETCHING_EMPLOYEE = "FETCHING_EMPLOYEE",
  FETCHING_EMPLOYEE_SUCCESS = "FETCHING_EMPLOYEE_SUCCESS",
  FETCHING_EMPLOYEE_ERROR = "FETCHING_EMPLOYEE_ERROR";

export default {
  namespaced: true,
  state: {
    hasEmployee: false,
    isLoading: false,
    error: null,
    employee: {}
  },
  getters: {
    isLoading(state) {
      return state.isLoading;
    },
    hasError(state) {
      return state.error !== null;
    },
    error(state) {
      return state.error;
    },
    hasEmployee(state) {
      return state.employee.firstName ? true : false;
    },
    fullName: function (state) {
      return `${state.employee.firstName} ${state.employee.lastName}`
    },
    employee(state) {
      return state.employee;
    }
  },
  mutations: {
    [FETCHING_EMPLOYEE](state) {
      state.isLoading = true;
      state.error = null;
      state.employee = {};
      state.hasEmployee = false;
    },
    [FETCHING_EMPLOYEE_SUCCESS](state, employee) {
      state.isLoading = false;
      state.error = null;
      state.employee = employee;
      state.hasEmployee = true;
    },
    [FETCHING_EMPLOYEE_ERROR](state, error) {
      state.isLoading = false;
      state.error = error;
      state.employee = {};
      state.hasEmployee = false;
    }
  },
  actions: {
    async findOne({ commit, state , rootState}) {
      commit(FETCHING_EMPLOYEE);
      
      try {
        let currentUser = JSON. parse(localStorage.getItem("currentUser"));
        let response = await EmployeeAPI.findOne(currentUser ? currentUser.employeeId : "");
        commit(FETCHING_EMPLOYEE_SUCCESS, response.data);
        return response.data;
      } catch (error) {
        commit(FETCHING_EMPLOYEE_ERROR, error);
        return null;
      }
    }
  }
};
