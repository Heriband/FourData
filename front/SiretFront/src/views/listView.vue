<script>
import apiClient from '../client'

import router from '../router'

export default {
  data() {
    return {
      showPopup: false, // Contrôle affichage pop-up
      items: []
    }
  },
  created() {
    apiClient.getIndex().then(response => {
      this.items = response.data;
    }).catch(error => {
      console.error('There was an error fetching data from the API:', error);
    });
  },

  methods: {
    deleteItem(id){
      apiClient.deleteById(id); // supprimer coté DB
      this.items = this.items.filter(item => item.id !== id); //supprimer en local
    }, 

    RedirectAddEntreprise(){
      router.push('/add'); 
    },


    openPopup() {
      this.showPopup = true;
    },
    closePopup() {
      this.showPopup = false;
    },
  },
}

</script>



<template>
  <h1>Entreprise index</h1>
  <ul>
        <button @click="RedirectAddEntreprise()">add Manual</button>
  </ul>

    <table class="table">
    <thead>
        <tr >
            <th class="title">Id</th>
            <th class="title">SIRET</th>
            <th class="title">Nom</th>
            <th class="title">Adresse</th>
            <th class="title">SIREN</th>
            <th class="title">TVA</th>
            <th class="title">actions</th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="item in items" :key="item.id">
            <td>{{ item.id }}</td>
            <td>{{ item.SIRET }}</td>
            <td>{{ item.Nom }}</td>
            <td>{{ item.Adresse }}</td>
            <td>{{ item.SIREN }}</td>
            <td>{{ item.Tva }}</td>
            <td>
                <!-- Boutons ou autres éléments d'action ici -->
                <button @click="editItem(item)">Edit</button>
                <button @click="deleteItem(item.id)">Delete</button>
            </td>
        </tr>
    </tbody>

    </table>
  
    <RouterView />
  </template>
  



  


  <style>
  button {
    padding: 10px 20px; /* Padding dans le bouton */
    border: none; /* Enlève la bordure par défaut */
    border-radius: 4px; /* Bordure arrondie */
    background-color: #10504d; /* Couleur de fond du bouton */
    color: #fff; /* Couleur du texte du bouton */
    cursor: pointer; /* Curseur pointer pour le bouton */
    margin: 0 5px;
  }
  
  button:hover {
    background-color: #10504d; /* Couleur du bouton au survol */
  }

  .table{
    width: 900px;
    box-sizing: border-box;
    padding: 5px;
  }

  .title{
    padding: 5px; 
    font-weight: bolder;
  }
  </style>