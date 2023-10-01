import UserAPI from "../api/user";

const AUTHENTICATING = "AUTHENTICATING",
  AUTHENTICATING_SUCCESS = "AUTHENTICATING_SUCCESS",
  AUTHENTICATING_ERROR = "AUTHENTICATING_ERROR";

export default {
  namespaced: true,
  state: {
    isLoading: false,
    error: null,
    isAuthenticated: false,
    user: null,
    authToken: ""
  },
  reactive : {
    authToken: ""
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
    isAuthenticated(state) {
      return state.isAuthenticated;
    },
    hasRole(state) {
      return role => {
        return state.user.roles.indexOf(role) !== -1;
      }
    }
  },
  mutations: {
    [AUTHENTICATING](state) {
      state.isLoading = true;
      state.error = null;
      state.isAuthenticated = false;
      state.user = null;
    },
    [AUTHENTICATING_SUCCESS](state, user) {
      state.isLoading = false;
      state.error = null;
      state.isAuthenticated = true;
      state.user = user;
    },
    [AUTHENTICATING_ERROR](state, error) {
      state.isLoading = false;
      state.error = error;
      state.isAuthenticated = false;
      state.user = null;
    }
  },
  actions: {
    async login({commit}, payload) {
      commit(AUTHENTICATING);
      try {
        let response = await UserAPI.login(payload.username, payload.password);
        commit(AUTHENTICATING_SUCCESS, response.data);
        return response.data;
      } catch (error) {
        commit(AUTHENTICATING_ERROR, error);
        return null;
      }
    }
  }
}