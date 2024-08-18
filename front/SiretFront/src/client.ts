import axios from 'axios';
import { Entreprise } from './model/Entreprise';
import qs from 'qs';

const apiClient = axios.create({
  baseURL: 'http://localhost:8000/',  // URL API Symfony
  headers: {
    'Content-Type': 'application/x-www-form-urlencoded',
  }
});

export default {
  getIndex() {
    return apiClient.get('/entreprise');
  },


  getById(id: number) {
    return apiClient.get(`/entreprise/${id}`);
  },

  deleteById(id: number){
    return apiClient.post(`/entreprise/${id}`)
  },

  newOne(entreprise: Entreprise){
    const encodedData = qs.stringify({
      'entreprise[SIRET]': entreprise.SIRET,
      'entreprise[Nom]': entreprise.Nom,
      'entreprise[Adresse]': entreprise.Adresse,
      'entreprise[SIREN]': entreprise.SIREN,
      'entreprise[TVA]': entreprise.Tva
    });
    console.log('Données encodées:', encodedData);
    return apiClient.post('/entreprise/new', encodedData);
  },

  editOne(id: number, entreprise: Entreprise){
    const encodedData = qs.stringify({
      'entreprise[SIRET]': entreprise.SIRET,
      'entreprise[Nom]': entreprise.Nom,
      'entreprise[Adresse]': entreprise.Adresse,
      'entreprise[SIREN]': entreprise.SIREN,
      'entreprise[TVA]': entreprise.Tva
    });
    console.log('Données encodées:', encodedData);
    return apiClient.post(`/entreprise/${id}/edit`, encodedData);
  },

}
