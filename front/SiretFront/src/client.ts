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
  // recuperer liste de toutes les entreprises
  getIndex() {
    return apiClient.get('/entreprise');
  },

  //recuperer une entreprise ciblé par ID
  getById(id: number) {
    return apiClient.get(`/entreprise/${id}`);
  },

  //suprrimer une entreprise
  deleteById(id: number){
    return apiClient.post(`/entreprise/${id}`)
  },

  // ajouter une entreprise cote DB
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

  //modifier une entreprsie coté back
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
