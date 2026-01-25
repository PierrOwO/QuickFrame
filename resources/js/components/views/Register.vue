
<script setup>
import { ref, onMounted, nextTick } from 'vue'
import axios from 'axios'
window.axios = axios;
axios.defaults.headers.common['X-CSRF-TOKEN'] =
    document.querySelector('meta[name="csrf-token"]').getAttribute('content');
// ui
import InputText from './../ui/Input.vue'
import Button from './../ui/Button.vue'
import InputLabel from './../ui/Label.vue'
import Popup from './../ui/Popup.vue';


const firstName = ref('')
const lastName = ref('')
const email = ref('')
const password = ref('')
const password_confirmation = ref('')

const popup = ref()
const popupMessage = ref('custom message')
const popupType = ref('info');

const success = ref(false)
const loading = ref(false)
const successMsg = ref('')
const button = ref(null);


function clearErrors() {
  const errorSpans = document.querySelectorAll('.error-span')
  errorSpans.forEach(span => (span.textContent = ''))

  const inputs = document.querySelectorAll('input')
  inputs.forEach(input => input.classList.remove('input-error'))
}

async function openPopup(message, type) {
  popupMessage.value = message
  popupType.value = type;
  await nextTick()
  popup.value.openPopup()
  loading.value = false
  success.value = false
}
const registerAttempt = async () => {
  clearErrors()

  loading.value = true
  success.value = false

  const formData = {
    first_name: firstName.value,
    last_name: lastName.value,
    email: email.value,
    password: password.value,
    password_confirmation: password_confirmation.value
  }

  try {
    await axios.post('/auth/register', formData)    
    .then(response => {
      success.value = true
    loading.value = false
      successMsg.value = response.data.message;
     /* setTimeout(() => {
                let url = '/auth/login';
                window.location = url;
            }, 1000);
      */
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
    } else if (error.response && error.response.status === 419) {
      openPopup('Session expired', 'info');
    } else {
      openPopup(error.response.data.message, 'info');
    }
  }
}


onMounted(() => {
    document.addEventListener('keydown', e => {
    if (e.key === 'Enter' && e.target.tagName === 'INPUT' && success.value === false) {
      registerAttempt()
    }
  })
  

  document.querySelectorAll('.center-div div input').forEach(input => {
    if (input.value) input.classList.add('filled')

    input.addEventListener('input', () => {
      if (input.value) input.classList.add('filled')
      else input.classList.remove('filled')
    })
  })
})
</script>
<template>
<div class="center-div">
  <div>
    <a>
      Registration
    </a>
  </div>
  <div>
    <InputText 
      v-model="firstName"
      id="first_name"
      type="text"
      required 
      minlength="2" 
      maxlength="50"
      pattern="[A-Za-zÀ-ž\s'-]+"
      placeholder=""
      autofocus
    />
    <InputLabel for="first_name">First Name</InputLabel>
    <span id="error-first_name" class="error-span" role="alert"></span>
  </div>

  <div>
    <InputText 
    v-model="lastName"

      id="last_name"
      type="text"
      required 
      minlength="2" 
      maxlength="50"
      pattern="[A-Za-zÀ-ž\s'-]+"
      placeholder=""
    />
    <InputLabel for="last_name">Last Name</InputLabel>
    <span id="error-last_name" class="error-span" role="alert"></span>
  </div>

  <div>
    <InputText 
    v-model="email"

      id="email"
      type="email"
      required 
      minlength="3" 
      maxlength="50" 
      pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}"
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
      maxlength="50"
      placeholder=""
    />
    <InputLabel for="password">Password</InputLabel>
    <span id="error-password" class="error-span" role="alert"></span>
  </div>
  <div>
    <InputText 
    
      id="password_confirmation"
      type="password"
      v-model="password_confirmation"
      required 
      minlength="6"
      maxlength="50"
      placeholder=""
    />
    <InputLabel for="password_confirmation">Password confirmation</InputLabel>
    <span id="error-password_confirmation" class="error-span" role="alert"></span>
  </div>

    <Button 
    :class="{
      'no-hover-green': loading || success
    }"
    ref="button" 
    @click="registerAttempt" 
    theme="green"
  >
    <span v-if="loading">Processing...</span>
    <span v-else-if="success">{{ successMsg }}</span>
    <span v-else>Sign up</span>
  </Button>
  <span class="go-to-login">Already have an acccount? <a href="/auth/login">Sign in</a></span>
</div>
<Popup ref="popup" :type="popupType" :message="popupMessage"></Popup>
</template>


<style scoped>
.go-to-login{
  font-size: small;
  text-align: right;
  margin-top: 5px;
  margin-bottom: -10px;
}
.go-to-login a{
  text-decoration: none;
  color: #007bff;
  font-weight: 600;
}
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
  margin-bottom: 24px;

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