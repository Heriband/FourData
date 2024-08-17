import axios from 'axios';

const apiClient = axios.create({
  baseURL: 'http://localhost:8000/',  // URL API Symfony
  headers: {
    'Content-Type': 'application/json',
  }
});

export default {
  getIndex() {
    return apiClient.get('/entreprise/get');
  },


}
