
document.addEventListener("keydown", function(event) {
    if (event.key === "Enter" && event.target.tagName === "INPUT") {
        login();
    }
});

function login(){
    clearErrors();
    var name = document.getElementById('name').value;
    var password = document.getElementById('password').value;
    setMsg(3, '');

    if(password != '' && name !=''){
        setMsg(2, 'Connecting...');
        var formData = {
            name: name,
            password: password,
        }
        console.log(formData);
        axios.post('/auth/login', formData)
        .then(response => {
            setMsg(3, '');
            const msg = response.data.message;
            setMsg(3, msg);
            setTimeout(() => {
                let url = '/dashboard';
                window.location = url;
            }, 500);
        })
        .catch(error => {
            if (error.response) {
                console.log(error.response.data);    
                if (error.response.status === 419 || error.response.status === 401) {
                    setMsg(3, error.response.data.message);
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
window.login = login;
window.clearErrors = clearErrors;