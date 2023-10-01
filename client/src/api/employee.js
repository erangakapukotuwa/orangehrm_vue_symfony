import axios from "axios";
const apiEndpont = 'http://localhost:8000/api';

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
    return axios.get(apiEndpont.concat(`/employee/${employeeId}`), {headers : authHeader()});   
  }
};