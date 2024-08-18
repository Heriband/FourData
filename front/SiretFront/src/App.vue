<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router'
import HelloWorld from './components/HelloWorld.vue'
</script>

<template>
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