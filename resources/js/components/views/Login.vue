
<script setup>
import { ref, onMounted, nextTick } from 'vue'
import axios from 'axios'
window.axios = axios;
axios.defaults.headers.common['X-CSRF-TOKEN'] =
document.querySelector('meta[name="csrf-token"]').getAttribute('content');

import InputText from './../ui/Input.vue';
import Button from './../ui/Button.vue';
import InputLabel from './../ui/Label.vue';
import Popup from './../ui/Popup.vue';


onMounted(() => {
  document.querySelectorAll('.center-div div input').forEach(input => {
    if (input.value) {
      input.classList.add('filled')
    }

    input.addEventListener('input', () => {
      if (input.value) {
        input.classList.add('filled')
      } else {
        input.classList.remove('filled')
      }
    })
  })

})

const email = ref()
const password = ref()

const popup = ref()
const popupMessage = ref('custom message')
const popupType = ref('info');

const success = ref(false)
const loading = ref(false)
const successMsg = ref('')
const button = ref(null);

async function openPopup(message, type) {
  popupMessage.value = message
  popupType.value = type;
  await nextTick()
  popup.value.openPopup()
  loading.value = false
  success.value = false
}
function clearErrors() {
  const errorSpans = document.querySelectorAll('.error-span')
  errorSpans.forEach(span => (span.textContent = ''))

  const inputs = document.querySelectorAll('input')
  inputs.forEach(input => input.classList.remove('input-error'))
}

const loginAttempt = async () => {
  clearErrors()

  if (
    !email.value ||
    !password.value
  ) {
    openPopup("Please fill up all inputs", 'info')
    return
  }

  loading.value = true
  success.value = false

  const formData = {
      email: email.value,
      password: password.value,
    }

  try {
    await axios.post('/auth/login', formData)    
    .then(response => {
      success.value = true
      loading.value = false
      successMsg.value = response.data.message;
      setTimeout(() => {
                let url = '/dashboard';
                window.location = url;
            }, 1000);
    })

  } catch (error) {
    loading.value = false
    console.error(error)

    if (error.response && error.response.status === 422) {
      const errors = error.response.data.errors

      for (const field in errors) {
        const span = document.getElementById(`error-${field}`)
        const input = document.getElementById(field)

        if (input) input.classList.add('input-error')
        if (span) {
          span.textContent = errors[field]
          span.style.display = 'block'; 
        }
      }
    } else {
      openPopup(error.response.data.message, 'info');
    }
  }
}
</script> 
<template>
<div class="center-div">
  <div>
    <a>
      Login
    </a>
  </div>
  <div>
    <InputText 
      id="email"
      type="email"
      v-model="email"
      required 
      minlength="3" 
      maxlength="50" 
      pattern="[A-Za-z0-9_-]+" 
      placeholder=""
    />
    <InputLabel for="email">Email</InputLabel>
    <span id="error-email" class="error-span" role="alert"></span>
  </div>
  <div>
    <InputText 
      id="password"
      type="password"
      v-model="password"
      required 
      minlength="6"  
      placeholder=""
    />
    <InputLabel for="password">Password</InputLabel>
    <span id="error-password" class="error-span" role="alert"></span>
  </div>


  <Button 
    :class="{
      'no-hover-green': loading || success
    }"
    ref="button" 
    @click="loginAttempt" 
    theme="green"
  >
    <span v-if="loading">Connecting...</span>
    <span v-else-if="success">{{ successMsg }}</span>
    <span v-else>Sign in</span>
  </Button>
  
</div>
<Popup ref="popup" :type="popupType" :message="popupMessage"></Popup>
</template>
<style scoped>
.error-span{
    font-size: 14px;
    color: red;
    display: none;
    padding: 0px;
}
.input-error{
    border: 1px solid red;
}
.center-div{
  display: flex;
  flex-direction: column;
  width: 350px;
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: #fff;
  box-sizing: border-box;
  padding: 35px;
  border-radius: 10px;
  max-height: 400px; 
  overflow: hidden;
  transition: max-height 0.3s ease;
  box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
}
.center-div div{
  width: 100%;
  box-sizing: border-box; 
  margin-bottom: 24px;
  position: relative;
}
.center-div div:nth-child(1){
  padding: 15px;
  text-align: center;
  font-size: 30px;
  font-weight: 600;
}

.center-div div:nth-child(4){
  margin-bottom: 10px;

}
.center-div div input {
  width: 100%;
  padding: 20px 10px;
  font-size: 18px;
  box-sizing: border-box;
}

.center-div div label {
  position: absolute;
  left: 8px;
  top: 10px;
  font-size: 18px;
  color: #666;
  pointer-events: none; 
  transition: 0.3s ease all;
}

.center-div div input:focus + label,
.center-div div input.filled + label,
.center-div div input:-webkit-autofill + label {
  top: -20px;
  left: 0px;
  font-size: 15px;
  color: #333;
  padding: 0 4px;
}
.center-div button{
  margin: auto; 
  width: 100%;
  padding: 13px;
}
</style>