<template>
    <Loading ref="spinner"/>
    <a class="logout" href="logout">Logout</a>
    <div class="main">
        <div>
            <InputLabel for="first_name">First Name </InputLabel>
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
            
            <Button 
                :class="{
                'no-hover-orange': loadingFirstName,
                'no-hover-green': successFirstName,
                }"
                ref="buttonForFirstName" 
                @click="saveFirstName" 
                theme="orange"
                v-show="showButtonForFirstName"
            >
            <span v-if="loadingFirstName">Processing...</span>
            <span v-else-if="successFirstName">Success</span>
            <span v-else>Save</span>
            </Button>
            <span id="error-first_name" class="error-span" role="alert">ss</span>

        </div>
        <div>
            <InputLabel for="last_name">Last Name </InputLabel>
                <InputText 
                v-model="lastName"
                id="last_name"
                type="text"
                required 
                minlength="2" 
                maxlength="50"
                pattern="[A-Za-zÀ-ž\s'-]+"
                placeholder=""
                autofocus
                />
            <Button 
                :class="{
                'no-hover-orange': loadingLastName,
                'no-hover-green': successLastName
            }"
                ref="buttonForLastName" 
                @click="saveLastName" 
                theme="orange"
                v-show="showButtonForLastName"
            >
            <span v-if="loadingLastName">Processing...</span>
            <span v-else-if="successLastName">Success</span>
            <span v-else>Save</span>
            </Button>
            <span id="error-last_name" class="error-span" role="alert"></span>

        </div>
        <div>
            <InputLabel for="email">Email</InputLabel>
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
            <Button 
                :class="{
                'no-hover-orange': loadingEmail,
                'no-hover-green': successEmail
            }"
                ref="buttonForEmail" 
                @click="saveEmail" 
                theme="orange"
                v-show="showButtonForEmail"
            >
            <span v-if="loadingEmail">Processing...</span>
            <span v-else-if="successEmail">Success</span>
            <span v-else>Save</span>
            </Button>
            <span id="error-email" class="error-span" role="alert"></span>

        </div>
        <div style="margin-top: 30px;">
            <InputLabel for="old_password">Old Password</InputLabel>
            <InputText 
            id="old_password"
            type="password"
            v-model="oldPassword"
            required 
            minlength="6"
            maxlength="50"
            placeholder=""
            />
            <span id="error-old-password" class="error-span" role="alert"></span>
        </div>
        <div>
            <InputLabel for="password">New password</InputLabel>
            <InputText 
            id="password"
            type="password"
            v-model="password"
            required 
            minlength="6"
            maxlength="50"
            placeholder=""
            />
            <span id="error-password" class="error-span" role="alert"></span>
        </div>
        <div>
            <InputLabel for="password_confirmation">Confirm password</InputLabel>
            <InputText 
            id="password_confirmation"
            type="password"
            v-model="passwordConfirmation"
            required 
            minlength="6"
            maxlength="50"
            placeholder=""
            />
            <Button 
                :class="{
                'no-hover-orange': loadingPassword,
                'no-hover-green': successPassword
            }"
                ref="buttonForPassword" 
                @click="savePassword" 
                theme="orange"
                v-show="showButtonForPassword"
            >
            <span v-if="loadingPassword">Processing...</span>
            <span v-else-if="successPassword">Success</span>
            <span v-else>Save</span>
            </Button>
            <span id="error-password_confirmation" class="error-span" role="alert"></span>
        </div>
    </div>
    <Popup 
        ref="popup" 
        :type="popupType" 
        :message="popupMessage"
        @confirm="confirmEmailChange"
        @cancel="cancelConfirm"
    >
        <div v-show="showConfirmToken" class="confirm-token-popup">
            <InputLabel for="confirm_token">Confirm change using token sent to your email</InputLabel>
            <InputText 
                id="confirm_token"
                v-model="confirmToken"
                type="text"
                minlength="8"
                maxlength="8"
                placeholder="8-digit token"
                required
            />
            <span id="error-confirm_token" class="error-span" role="alert"></span>

        </div>
    </Popup>

</template>
  
<script setup>
    import {ref, onMounted, watch, nextTick, computed} from 'vue'
    import axios from 'axios'
    window.axios = axios;
    axios.defaults.headers.common['X-CSRF-TOKEN'] =
    document.querySelector('meta[name="csrf-token"]').getAttribute('content');
// ui
    import InputText from './../ui/Input.vue'
    import Button from './../ui/Button.vue'
    import InputLabel from './../ui/Label.vue'
    import Popup from './../ui/Popup.vue';
    
    import Loading from '../ui/Loading.vue'
    import {useUser} from '../../composables/useUser';
    const { userFirstName, userLastName, userEmail, loading, error, fetchUser } = useUser();
    const firstName = ref('')
    const lastName = ref('')
    const email = ref('')
    const oldPassword = ref('')
    const password = ref('')
    const passwordConfirmation = ref('')

    const confirmToken = ref('')
    const showConfirmToken = ref(false)

    const showButtonForFirstName = ref(false);
    const showButtonForLastName = ref(false);
    const showButtonForEmail = ref(false);
    const showButtonForPassword = computed(() => {
        return (
            passwordConfirmation.value !== '' &&
            oldPassword.value !== '' &&
            password.value !== ''
        );
    });
    const buttonForFirstName = ref(null);
    const buttonForLastName = ref(null);
    const buttonForEmail = ref(null);
    const buttonForPassword = ref(null);
    
    watch(userFirstName, val => { if (val !== null) firstName.value = val  })
    watch(userLastName, val => { if (val !== null) lastName.value = val })
    watch(userEmail, val => { if (val !== null) email.value = val  })

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

    const popup = ref()
    const popupMessage = ref('custom message')
    const popupType = ref('info');

    const successFirstName = ref(false)
    const loadingFirstName = ref(false)
    const successMsgFirstName = ref('')
    
    const successLastName = ref(false)
    const loadingLastName = ref(false)
    const successMsgLastName = ref('')

    const successEmail = ref(false)
    const loadingEmail = ref(false)
    const successMsgEmail = ref('')

    const successPassword = ref(false)
    const loadingPassword = ref(false)
    const successMsgPassword = ref('')

    

    watch(firstName, val=> {
        if(val !== userFirstName.value && val !== '') showButtonForFirstName.value = true;
        else showButtonForFirstName.value = false;
    })
    watch(lastName, val=> {
        if(val !== userLastName.value && val !== '') showButtonForLastName.value = true;
        else showButtonForLastName.value = false;
    })
    watch(email, val=> {
        if(val !== userEmail.value && val !== '') showButtonForEmail.value = true;
        else showButtonForEmail.value = false;
    })
  
    


    function clearErrors() {
    const errorSpans = document.querySelectorAll('.error-span')
    errorSpans.forEach(span => (span.textContent = ''))

    const inputs = document.querySelectorAll('input')
    inputs.forEach(input => input.classList.remove('input-error'))
    }

    async function openPopup(message, type) {
    showConfirmToken.value = false
    popupMessage.value = message
    popupType.value = type;

    await nextTick()
    popup.value.openPopup()
    
    }
    async function closePopup() {
    await nextTick()
    popup.value.closePopup()
    }
    async function cancelConfirm() {
    await nextTick()
    popup.value.closePopup()
    loadingEmail.value = false
    successEmail.value = false
    }

    const saveFirstName = async () => {
        clearErrors()
        loadingFirstName.value = true
        successFirstName.value = false

        const formData = {
            first_name: firstName.value,
        }

        try {
            await axios.put('/web/user/first-name', formData)    
            .then(response => {
            successFirstName.value = true
            loadingFirstName.value = false
            successMsgFirstName.value = response.data.message;
            })

        } catch (error) {
            loadingFirstName.value = false
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
    const saveLastName = async () => {
        clearErrors()
        loadingLastName.value = true
        successLastName.value = false

        const formData = {
            last_name: lastName.value,
        }

        try {
            await axios.put('/web/user/last-name', formData)    
            .then(response => {
            successLastName.value = true
            loadingLastName.value = false
            successMsgLastName.value = response.data.message;
            })

        } catch (error) {
            loadingLastName.value = false
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
    const saveEmail = async () => {
        clearErrors()
        loadingEmail.value = true
        successEmail.value = false

        const formData = {
            email: email.value,
        }

        try {
            await axios.put('/action-code/user/new-email', formData)    
            .then(response => {            
            openPopup('', 'confirm');
            showConfirmToken.value = true
            })

        } catch (error) {
            loadingEmail.value = false
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
    const savePassword = async () => {
        clearErrors()
        loadingPassword.value = true
        successPassword.value = false

        const formData = {
            old_password: oldPassword.value,
            password: password.value,
            password_confirmation: passwordConfirmation.value,
        }

        try {
            await axios.put('/web/user/password', formData)    
            .then(response => {
            successPassword.value = true
            loadingPassword.value = false
            successMsgPassword.value = response.data.message;
            })

        } catch (error) {
            loadingPassword.value = false
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

    const confirmEmailChange = async () => {
        

        try {
            await axios.post('/action-code/confirm/' + confirmToken.value)    
            .then(response => {
            successEmail.value = true
            loadingEmail.value = false
            successMsgEmail.value = response.data.message;
            showConfirmToken.value = false
            closePopup()
            setTimeout(() => {
                openPopup(response.data.message, 'info')
            }, 500);
            })

        } catch (error) {
            loadingEmail.value = false
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
            alert('Session expired');
            } else {
            alert(error.response.data.message);
            }
        }
    }

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
  .error-span{
    font-size: 14px;
    color: red;
    display: none;
    padding: 0px;
    text-align: center;
}
.input-error{
    border: 1px solid red;
}
  .main div{
    margin-top: 5px;
  }
  .main div:first-child{
    margin-top: 0%;
  }
  .main label{
    min-width: 120px;
    max-lines: 1;
    display: inline-block;
    font-size: 14px;
  }
  .main input {
    display: inline;
    width: 50%;
    margin-right: 10px;
    height: 30px
  }
  .main button{
    display: inline;
  }

  .confirm-token-popup{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: rgb(202, 202, 202);
    flex-direction: column;
  }
  .confirm-token-popup label{
    display: block;
  }
  .confirm-token-popup input{
    font-size: 30px;
    padding: 22px 0px;
    width: 200px;
    text-align: center;
    box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
  }
  </style>