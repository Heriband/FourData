

<script>
import { Entreprise } from '../model/Entreprise';
import apiClient from '../client'
import router from '../router'
import { getEntrepriseInfo } from '../InseeClient'

export default {
    data() {
    return {
      isManual: false, // Contrôle l'affichage 
    };
  },
  methods: {
    changeManual(){
        this.manual = !this.manual;
    },

    save() { 
        var siret = document.getElementById("entreprise_SIRET").value;

        if (this.isManual)
        {
            var nom = document.getElementById("entreprise_Nom").value;
            var adresse = document.getElementById("entreprise_Adresse").value;
            var siren = document.getElementById("entreprise_SIREN").value;
            var tva = document.getElementById("entreprise_TVA").value;
            if (siret.length != 0  
            && nom.length != 0
            && siret.length != 0
            && adresse.length != 0
            && siren.length != 0
            && siret.length != 0){
                this.entreprise = new Entreprise(siret, nom, adresse, tva, siren);
                apiClient.newOne(this.entreprise);

                document.getElementById("entreprise_SIRET").value = "";
                document.getElementById("entreprise_Nom").value = "";
                document.getElementById("entreprise_Adresse").value = "";
                document.getElementById("entreprise_SIREN").value = "";
                document.getElementById("entreprise_TVA").value = "";

                router.push('/list'); 
        }
        else
            alert("field not init");
        }

        else{
            if (siret.length != 0 ){
                getEntrepriseInfo(siret).then(ent => {
                    if (ent == null){
                        alert("Siret does not exist");
                        return
                    }

                    let txt = "ajout entreprise :\n"+
                        `nom : ${ent.Nom}\n`+
                        `adresse : ${ent.Adresse}\n`+
                        `siren : ${ent.SIREN}\n`+
                        `tva : ${ent.Tva}`
                    if (confirm(txt)){
                        console.log("q");
                        apiClient.newOne(ent);
                        document.getElementById("entreprise_SIRET").value = "";
                        router.push('/list'); 

                    }
                });
            }
            else{
                alert("field Siret not init");
                
            }

        }
    }
  }
}
</script>



<template>
    <h1>Entreprise Add</h1>
    <ul class="form-list">
    <li>
        <label for="entreprise_SIRET" class="required">S i r e t</label>
        <input type="text" id="entreprise_SIRET" name="entreprise[SIRET]" required="required" maxlength="255">
    </li>
    <li v-if="isManual" class="manual">
        <label for="entreprise_Nom" class="required">Nom</label>
        <input type="text" id="entreprise_Nom" name="entreprise[Nom]" required="required" maxlength="255">
    </li>    
    <li v-if="isManual" class="manual">
        <label for="entreprise_Adresse" class="required">Adresse</label>
        <input type="text" id="entreprise_Adresse" name="entreprise[Adresse]" required="required" maxlength="255"></li>
    <li v-if="isManual" class="manual">
        <label for="entreprise_SIREN" class="required">S i r e n</label>
        <input type="text" id="entreprise_SIREN" name="entreprise[SIREN]" required="required" maxlength="255"></li>
    <li v-if="isManual" class="manual">
        <label for="entreprise_TVA" class="required">T v a</label>
        <input type="text" id="entreprise_TVA" name="entreprise[TVA]" required="required" maxlength="255">
    </li v-if="isManual" class="manual">
    <button @click="save()">Save</button>
    <label>
      <input type="checkbox" v-model="isManual" />
      manual add
    </label>
</ul>
    <RouterView />
    </template>
    




    <style>
    .form-container {
      max-width: 600px; /* Ajuste la largeur maximale du formulaire */
      margin: 0 auto; /* Centre le formulaire horizontalement */
      padding: 20px; /* Ajoute du padding autour du formulaire */
      border: 1px solid #ddd; /* Bordure autour du formulaire */
      border-radius: 8px; /* Bordure arrondie */
      background-color: #f9f9f9; /* Couleur de fond */
    }
    
    .form-list {
      list-style: none; /* Enlève les puces de la liste */
      padding: 0; /* Enlève le padding */
    }
    
    .form-list li {
      margin-bottom: 15px; /* Espace entre les éléments de la liste */
      display: flex; /* Utilisation de Flexbox pour l'alignement */
      align-items: center; /* Aligne les éléments verticalement */
    }
    
    .form-list label {
      flex: 0 0 150px; /* Largeur fixe pour les labels */
      margin-right: 10px; /* Espace entre le label et le champ */
      text-align: right; /* Aligne le texte du label à droite */
    }
    
    .form-list input {
      flex: 1; /* Les champs de formulaire prennent le reste de l'espace */
      padding: 8px; /* Padding dans les champs de formulaire */
      border: 1px solid #ccc; /* Bordure des champs de formulaire */
      border-radius: 4px; /* Bordure arrondie des champs */
    }
    
    button {
      padding: 10px 20px; /* Padding dans le bouton */
      border: none; /* Enlève la bordure par défaut */
      border-radius: 4px; /* Bordure arrondie */
      background-color: #10504d; /* Couleur de fond du bouton */
      color: #fff; /* Couleur du texte du bouton */
      cursor: pointer; /* Curseur pointer pour le bouton */
    }
    
    button:hover {
      background-color: #10504d; /* Couleur du bouton au survol */
    }
    </style>