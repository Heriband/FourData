<script>
import apiClient from '../client'

import router from '../router'

export default {
  data() {
    return {
      items: [], //liste des entreprises
      sortValue: 'null' // indicatif d'ordre hiérachique des entreprises
    }
  },
  created() {
    apiClient.getIndex().then(response => {
    this.items = response.data;

    }).catch(error => {
      console.error('There was an error fetching data from the API:', error);
    });
  },

  watch: {
    sortValue(select) {
      this.updateRelatedItems(select); // update sort des entreprise
    }
  },

  methods: {
    deleteItem(id){
      apiClient.deleteById(id); // supprimer coté DB
      this.items = this.items.filter(item => item.id !== id); //supprimer en local
    }, 

    updateRelatedItems(select){
      if(select == 'nom'){
        this.items.sort(function (a, b) {return a.Nom > b.Nom;})     
      }
      if(select == 'id'){
        this.items.sort(function (a, b) {return a.id > b.id;})
      }
      if(select == 'SIRET'){
        this.items.sort(function (a, b) {return a.SIRET > b.SIRET;})
      }
      if(select == 'SIREN'){
        this.items.sort(function (a, b) {return a.SIREN > b.SIREN;})
      }
    },
  
    // REDIRECTION START

    editItem(id){
      router.push(`/${id}/edit`); 
    },

    RedirectAddEntreprise(){
      router.push('/add'); 
    },

    RedirectDoc(){
      window.location.href = 'http://127.0.0.1:8000/doc';
    }
    // REDIRECTION END

  },
}

</script>



<template>
  <h1 class="title">Entreprise index</h1>
  <ul>
        <button @click="RedirectAddEntreprise()">add new one</button>
        <button @click="RedirectDoc()">Doc</button>
      <ul id="sort">
        <label>sort by : </label>
        <select v-model="sortValue" id="sortSelect">
          <option  value="nom">nom</option>
          <option  value="id">id</option>
          <option  value="SIRET">SIRET</option>
          <option  value="SIREN">SIREN</option>

        </select>
      </ul>
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
                <!-- Boutons d'actions -->
                <button @click="editItem(item.id)">Edit</button>
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
    color: #fff; 
    cursor: pointer; /* Curseur pointer pour le bouton */
    margin: 0 5px;
  }
  
button:hover {
  background-color: #ff0000; 
  background: #ff0000;
  color: #000000; 
  margin: 0 5px;
  padding: 10px;
}

#sort{
  color: #fff; 

}

#sortSelect{
    padding: 0;
    margin: 0;
    border: 1px solid #000000;
    width: 110px;
    border-radius: 3px;
    overflow: hidden;
    background-color: #10504d;
    background: #10504d;
    position: relative;
    color: #fff; 

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