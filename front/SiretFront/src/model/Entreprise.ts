export class Entreprise {
    SIRET: string;
    Nom: string;
    Adresse: string;
    Tva: string;
    SIREN: string;
  
    constructor(SIRET: string, Nom: string, Adresse: string, Tva: string, SIREN: string) {
      this.SIRET = SIRET;
      this.Nom = Nom;
      this.Adresse = Adresse;
      this.Tva = Tva;
      this.SIREN = SIREN;
    }
  
  }