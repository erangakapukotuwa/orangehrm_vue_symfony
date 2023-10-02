import axios from "axios";
import config from "../config";

export function authHeader() {
  let user = JSON.parse(localStorage.getItem('currentUser'));
  if (user && user.token) {
      return { 'Authorization': 'Bearer '+user.token };
  } else {
      return {};
  }
}

export default {
  findOne(employeeId) {
    return axios.get(config.API_LOCATION.concat(`/employee/${employeeId}`), {headers : authHeader()});   
  }
};