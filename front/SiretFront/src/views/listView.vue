<script>
import apiClient from '../client'

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
  }
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

  
    <RouterView />
  </template>
  