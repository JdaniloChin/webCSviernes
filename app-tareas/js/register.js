document.addEventListener('DOMContentLoaded', function(){
    const registerForm = document.getElementById('register-form');
    const registerError = document.getElementById('register-error');

    registerForm.addEventListener('submit', function(e){
        e.preventDefault();

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm-password').value;

        if(password !== confirmPassword){
            registerError.innerHTML = `<div class="alert alert-danger fade show" role="alert">
            <strong>Error:</strong> Password and confirmation don't match
            </div>`;
            return;
        }else  {
            registerError.innerHTML = `<div class="alert alert-success fade show" role="alert">
            <strong>Success:</strong> Email: ${email} successfully registered.
            </div>`;
            setTimeout(function(){
                registerError.innerHTML = "";
                window.location.href = "index.html";
            }, 5000)

         
        }



    })

});