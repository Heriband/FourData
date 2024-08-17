<script>
import apiClient from '../client'
import router from '../router'

export default {
  data() {
    return {
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
    }
  },
}

</script>



<template>
  <h1>Entreprise index</h1>

    <table class="table">
    <thead>
        <tr>
            <th>Id</th>
            <th>SIRET</th>
            <th>Nom</th>
            <th>Adresse</th>
            <th>SIREN</th>
            <th>TVA</th>
            <th>actions</th>
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
    <button @click="RedirectAddEntreprise()">add One</button>

  
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
  }
  
  button:hover {
    background-color: #10504d; /* Couleur du bouton au survol */
  }
  </style>