//Adding event listener for form submit
const formLogin = document.querySelector('#formLogin');
formLogin.addEventListener('submit', (e) => {
    e.preventDefault();
    checkLoginForm();
});

function checkLoginForm(){


    //value inputs
    const email = $('#loginEmail').val().trim();
    const password = $('#loginPassword').val();

    //error inputs
    const errorEmail = $('#errorLoginEmail').html('');
    const errorPassword = $('#errorLoginPassword').html('');


    //Clearing error CSS class
    const inputs = formLogin.querySelectorAll(".form-control");
    inputs.forEach(input => input.classList.remove('is-invalid'));


    //CHECKING INPUT, ERROR MESSAGES

    //Email RegEx
    if(!/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email) || email>100){
        $('#loginEmail').addClass('is-invalid');
        errorEmail.html('Email adresa nije valdinog formata.');
        return false;
    }

    //Password min 8 characters max 30, must contain uppercase letter, lowercase letter, special character and one number at least
    if(password === ""){
        $('#loginPassword').addClass('is-invalid');
        errorPassword.html('Password polje je prazno');
        return false;
    }

    var formData = new FormData(formLogin);
    fetch('loginValidation.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            //Treba menjati
            let errorBox = $("#errorMessageLogin");
            let messageBox = $("#notVerifiedMessage");
            let messageBoxNotRegistered = $('#errorNotRegistered');
            let messageBoxError = $('#errorForgotPassword');

            let messageBoxes = document.getElementsByClassName('activeMessage');

            for(let i=0;messageBoxes[i];i++){
                messageBoxes[i].removeClass("activeMessage");
            }
            //Clearovanje poruke ukoliko postoji
            // if(errorBox.hasClass("activeMessage")){
            //  errorBox.removeClass("activeMessage");
            //  }
            //displays message box --> user is not verified
            if(data.error === 'NIJE REGISTROVAN'){
                messageBoxNotRegistered.addClass("activeMessage");
                setTimeout(() => {
                    messageBoxNotRegistered.removeClass("activeMessage");
                },7000)
            }
            //displays message box --> user is not regostered
            if(data.error === 'NIJE VERIFIKOVAN'){
                messageBox.addClass("activeMessage");
                setTimeout(() => {
                    messageBox.removeClass("activeMessage");
                },7000)
            }
            //PDO EXCPETION
            if(data.error === 'PDO EXCEPTION'){
                messageBoxError.addClass("activeMessage");
                setTimeout(() => {
                    messageBoxError.removeClass("activeMessage");
                },7000)
            }
            //Password is not correct
            if(data.error === 'Sifra/email nije uredu'){
                errorBox.addClass("activeMessage");
                setTimeout(() => {
                    errorBox.removeClass("activeMessage");
                },7000)
            }

            //login passed...choosing correct page
            if(data.error === 0){
                window.location.replace ("user/households.php");
            }
            if(data.error === 3){
                window.location.replace ("admin/dashboard.php");
            }


        })
        .catch((error) => {
            console.error('Error:', error);
            return false;
        });
}