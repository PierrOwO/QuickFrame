
document.addEventListener("keydown", function(event) {
    if (event.key === "Enter" && event.target.tagName === "INPUT") {
        register();
    }
});

function register(){
    clearErrors();
    var firstName = document.getElementById('first-name').value;
    var lastName = document.getElementById('last-name').value;
    var email = document.getElementById('email').value;
    var name = document.getElementById('name').value;
    var password = document.getElementById('password').value;
    var password_confirmation = document.getElementById('password_confirmation').value;
    setMsg(3, '');

    if(password != '' && firstName !='' && lastName != '' && email !='' && name !='' && password_confirmation !=''){
        setMsg(2, 'Connecting...');
        var formData = {
            first_name: firstName,
            last_name: lastName,
            name: name,
            password_confirmation: password_confirmation,
            password: password,
            email: email,
        }
        console.log(formData);
        axios.post('/auth/register', formData)
        .then(response => {
            const msg = response.data.message;
            setMsg(1, msg);
        })
        .catch(error => {
            setMsg(3, '');
            if (error.response) {
                console.log(error.response.data);    
                if (error.response.status === 419 || error.response.status === 401) {
                    window.location.reload();
                }
                if (error.response.status === 422) {
                    const errors = error.response.data.errors;

                    for (const field in errors) {
                        const span = document.getElementById(`error-${field}`);
                        const input = document.querySelector(`input[name="${field}"]`);

                        if (input) input.classList.add('input-error');
                        if (span) {
                            span.textContent = errors[field];
                            span.style.display = 'block'; 
                        }
                    }

                } else {
                    console.error(error.message);
                }
            } else {
                console.error(error);
            }
        });
    }else{
        setMsg(3, 'Please fill in all fields!');
    }
}
function setMsg(type, message){
    var msg = document.getElementById('msg');
    if(type == 1){
        var msgColor = 'green';
    }
    if(type == 2){
        var msgColor = 'blue';
    }
    if(type == 3){
        var msgColor = 'red';
    }
    msg.style.color = msgColor;
    msg.textContent = message;
}
function clearErrors() {
    console.log('error removed');
    const errorSpans = document.querySelectorAll('.error-span');
    errorSpans.forEach(span => {
        span.textContent = '';
    });

    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => {
        input.classList.remove('input-error');
    });
}
window.setMsg = setMsg;
window.register = register;
window.clearErrors = clearErrors;