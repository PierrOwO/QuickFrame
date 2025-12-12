<template>
     <a class="logout" href="logout">Logout</a>
    <div class="main">
      <h1>Hello there!</h1>
      <h4 v-if="loggedIn">Your Name is {{ userFirstName }}</h4>
      <h4 v-else>You are not logged in!</h4>
    </div>
</template>

<script setup>
import {ref, onMounted} from 'vue'

import {useUser} from '../../composables/useUser';
const { userFirstName, userLastName, loading, error, fetchUser } = useUser();
const loggedIn = ref(false)

onMounted(async () => {
    await fetchUser();  
    if (!error.value) {
        loggedIn.value = true;
    }
});
</script>

<style scoped>

.main {
  background-color: white;
  width: 60%;
  height: auto;
  padding: 20px;
  margin: auto;
  margin-top: 30px;
  border-radius: 15px;
  box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
}
      
.logout {
  position: absolute;
  right: 0;
  top: 0;
  padding: 15px;
  font-size: 22px;
  font-weight: bold;
  color: #ffffff; 
  text-decoration: none;
  transition: 0.25s;
  cursor: pointer;
}
.logout:hover {
  color: #d1cfcf;
}
</style>