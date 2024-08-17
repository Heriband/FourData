import axios from 'axios';
import { Entreprise } from './model/Entreprise';
import tokenJson from './assets/token.json';

const API_URL = 'https://api.insee.fr/entreprises/sirene/V3.11/siret/';

interface TokenData {
  token: string;
}

export async function getToken(): Promise<string> {
  const data: TokenData = tokenJson;
  return data.token;
}



export async function getEntrepriseInfo(siret: string) {
  try {
    const token = await getToken();
    const response = await axios.get(`${API_URL}${siret}`, {
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}` // Remplacez avec votre jeton d'accès
      }
    })
    let siren = response.data.etablissement.siren;
    let nom = response.data.etablissement.uniteLegale.denominationUniteLegale
    let adresse = response.data.etablissement.adresseEtablissement.libelleCommuneEtablissement + ", " + response.data.etablissement.adresseEtablissement.numeroVoieEtablissement + " " + response.data.etablissement.adresseEtablissement.libelleVoieEtablissement;
    let tva = "TVA";
    let ent = new Entreprise(siret, nom, adresse, tva, siren);
    return ent;
  } catch (error) {
    console.error('Erreur lors de la récupération des informations de l\'entreprise:', error);
    return null;
  }
}


