import axios from 'axios';


const access_token = localStorage.getItem('access_token');

axios.defaults.baseURL = 'http://localhost/api/v1/';
axios.defaults.headers.common['Accept'] = 'application/json';
axios.defaults.headers.common['Authorization'] = `Bearer ${access_token}`; 

