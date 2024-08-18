
<template>
    <h1>Entreprise Add</h1>
    <ul class="form-list">
    <li>
        <label for="entreprise_SIRET" class="required">S i r e t</label>
        <input type="text" id="entreprise_SIRET" name="entreprise[SIRET]" required="required" maxlength="255">
    </li>
    <li  class="manual">
        <label for="entreprise_Nom" class="required">Nom</label>
        <input type="text" id="entreprise_Nom" name="entreprise[Nom]" required="required" maxlength="255">
    </li>    
    <li  class="manual">
        <label for="entreprise_Adresse" class="required">Adresse</label>
        <input type="text" id="entreprise_Adresse" name="entreprise[Adresse]" required="required" maxlength="255"></li>
    <li  class="manual">
        <label for="entreprise_SIREN" class="required">S i r e n</label>
        <input type="text" id="entreprise_SIREN" name="entreprise[SIREN]" required="required" maxlength="255"></li>
    <li  class="manual">
        <label for="entreprise_TVA" class="required">T v a</label>
        <input type="text" id="entreprise_TVA" name="entreprise[TVA]" required="required" maxlength="255">
    </li  class="manual">
    <button @click="edit()">Edit</button>

    </ul>
    <RouterView />
</template>



<script>

import { Entreprise } from '@/model/Entreprise';
import apiClient from '../client'
import router from '../router'


  export default {
    data() {
      return {
        id: null,
        entreprise : null
      };
    },
    created() {
        this.id = this.$route.params.id; //param du path (id)
        apiClient.getById(this.id).then(ent =>{
            this.entreprise = new Entreprise(ent.data[0].SIRET, ent.data[0].Nom, ent.data[0].Adresse, ent.data[0].Tva, ent.data[0].SIREN);
            console.log(this.entreprise );
            document.getElementById("entreprise_SIRET").value = this.entreprise.SIRET;
            document.getElementById("entreprise_Nom").value = this.entreprise.Nom;
            document.getElementById("entreprise_Adresse").value = this.entreprise.Adresse;
            document.getElementById("entreprise_SIREN").value = this.entreprise.SIREN;
            document.getElementById("entreprise_TVA").value = this.entreprise.Tva;
        });

    },


    methods:{

        edit(){
            var siret = document.getElementById("entreprise_SIRET").value;
            var nom = document.getElementById("entreprise_Nom").value;
            var adresse = document.getElementById("entreprise_Adresse").value;
            var siren = document.getElementById("entreprise_SIREN").value;
            var tva = document.getElementById("entreprise_TVA").value;

            console.log(this.entreprise.Nom);
            if (siret.length != 0  
            && nom.length != 0
            && siret.length != 0
            && adresse.length != 0
            && siren.length != 0
            && siret.length != 0){
                this.entreprise = new Entreprise(siret, nom, adresse, tva, siren);
                apiClient.editOne(this.id, this.entreprise);

                router.push('/list'); 
            }
            else
                alert("field not init");
        }

    }
  };
  </script>
  



 