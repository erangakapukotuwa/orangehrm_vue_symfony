import axios from "axios";
const apiEndpont = 'http://localhost:8000/api'

export default {
  login(username, password) {
    var result = axios.post(apiEndpont.concat("/login_check"), {
      username: username,
      password: password
    });
    return result;
  }
}