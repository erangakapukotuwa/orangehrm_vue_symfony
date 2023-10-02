import axios from "axios";
import config from "../config";

export default {
  login(username, password) {
    var result = axios.post(config.API_LOCATION.concat("/login_check"), {
      username: username,
      password: password
    });
    return result;
  }
}