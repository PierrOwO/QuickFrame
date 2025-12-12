<template>
  <div class="header">
    <div v-if="!loggedIn" class="login-register">
      <a href="/auth/register">Register</a>
      <a href="/auth/login">Login</a>
    </div>
    <div v-else class="login-register">
      <a href="/dashboard">Go to Dashboard</a>
    </div>
    <h1>{{props.title}}</h1>
    <Nav />
  </div>
  
</template>

<script setup>
import {ref, onMounted} from 'vue'
import Nav from './Nav.vue';
const props = defineProps({
  title:{
    type: String,
    default: "QuickFrame title",
  }
})
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
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem 0;
  background-color: #007bff;
  color: white;
  flex-direction: column;
  }
  .login-register{
  position: absolute;
  top:0;
  right: 0;
  padding: 15px;
}
.login-register a{
  text-decoration: none;
  color: white;
  font-weight: 600;
  transition: 0.25s;
}
.login-register a:hover{
  color: #0056b3;
}
.login-register a:last-child{
  margin-left: 15px;
}
</style>