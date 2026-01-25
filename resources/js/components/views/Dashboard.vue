<template>
  <Loading ref="spinner"/>
     <a class="logout" href="logout">Logout</a>
    <div class="main">
      <h1 v-if="loggedIn">Hey {{ userFirstName }}!</h1>
      <h4 v-if="loggedIn">You can change your data here: <a href="/user/data">change my data</a></h4>
      <h4 v-else>You are not logged in!</h4>
    </div>
</template>

<script setup>
import {ref, onMounted} from 'vue'

import Loading from '../ui/Loading.vue'
import {useUser} from '../../composables/useUser';
const { userFirstName, userLastName, loading, error, fetchUser } = useUser();

const spinner = ref();
const loggedIn = ref(false)

onMounted(async () => {
  spinner.value.startLoading();
  await fetchUser();  
  if (!error.value) {
      loggedIn.value = true; 
  }
  spinner.value.stopLoading();
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
.main a{
  color: black;
}
.main a:hover{
  color: green;
}
</style>