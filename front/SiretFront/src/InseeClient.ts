import axios from 'axios';
import { Entreprise } from './model/Entreprise';

const API_URL = 'https://api.insee.fr/entreprises/sirene/V3.11/siret/';

export async function getEntrepriseInfo(siret: string) {
  try {
    const response = await axios.get(`${API_URL}${siret}`, {
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer 7a82940b-05d2-358e-9242-4de6d3e1cdda` // Remplacez avec votre jeton d'accès
      }
    })
    let siren = response.data.etablissement.siren;
    let nom = response.data.etablissement.uniteLegale.denominationUniteLegale
    let adresse = response.data.etablissement.adresseEtablissement.libelleCommuneEtablissement + ", " + response.data.etablissement.adresseEtablissement.numeroVoieEtablissement + " "  + response.data.etablissement.adresseEtablissement.libelleVoieEtablissement;
    let tva = "TVA";
    let ent =  new Entreprise(siret, nom, adresse, tva, siren);
    return ent;
  } catch (error) {
    console.error('Erreur lors de la récupération des informations de l\'entreprise:', error);
    throw error;
  }
}


