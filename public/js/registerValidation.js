//Adding event listener for form submit
const formRegister = document.querySelector('#formRegister');
formRegister.addEventListener('submit', (e) => {
    e.preventDefault();
    if (checkRegisterForm()){
        checkEmail();
    }

});

function checkRegisterForm() {

    //default true value
    var isValid = true;

    //value inputs
    const name = $('#name').val().trim();
    const surname = $('#surname').val().trim();
    const email = $('#registerEmail').val().trim();
    const password = $('#registerPassword').val();
    const passwordConfirm = $('#registerPasswordConfirm').val();
    const phone = $('#phone').val().trim();
    const address = $('#address').val().trim();

    //error inputs
    const errorName = $('#errorName').html('');
    const errorSurname = $('#errorSurname').html('');
    const errorEmail = $('#errorRegisterEmail').html('');
    const errorPassword = $('#errorRegisterPassword').html('');
    const errorPasswordConfirm = $('#errorPasswordConfirm').html('');
    const errorPhone = $('#errorPhone').html('');
    const errorAddress = $('#errorAddress').html('');

    //Clearing error CSS class
    const inputs = formRegister.querySelectorAll(".form-control");
    inputs.forEach(input => input.classList.remove('is-invalid'));


    //CHECKING INPUT, ERROR MESSAGES

    //Name must contain characters 1-30, apostrophe characters and no digits
    //Surname must contain characters 1-30, apostrophe characters and no digits
    var nameRegEx= new RegExp("^[a-zA-ZčćžšđČĆŽŠĐ ']+$");
    if (name == "" || name.length > 30  || nameRegEx.test(name) === false) {
        $('#name').addClass('is-invalid');
        errorName.html('Ime mora da sadrži 1-30 isključivo slovnih karaktera.');
        isValid = false;
    }
    if (surname == "" || surname.length > 30 || nameRegEx.test(surname) === false) {
        $('#surname').addClass('is-invalid');
        errorSurname.html('Prezime mora da sadrži 1-30 isključivo slovnih karaktera.');
        isValid = false;
    }

    //Email empty check
    if(email === ""){
        $('#registerEmail').addClass('is-invalid');
        errorEmail.html('Polje za email je prazno.');
        isValid = false;
    }

    //Password min 8 characters max 30, must contain uppercase letter, lowercase letter, special character and one number at least
    let error = "";
    let errorExists = false;

    if (password.length < 8){
        error += 'Lozinka je prekratka. <br>';
        errorExists = true;
        }
    if (password.length > 30) {
        error += 'Lozinka je predugačka. <br>';
        errorExists = true;
    }
    if (!/[a-zčćžšđ]/.test(password)) {
        error += 'Lozinka mora da sadrži barem jedno malo slovo. <br>';
        errorExists = true;
    }
    if (!/[A-ZČĆŽŠĐ]/.test(password)) {
        error += 'Lozinka mora da sadrži barem jedno veliko slovo. <br>';
        errorExists = true;
    }
    if (!/[^a-zA-Z0-9čćžšđČĆŽŠĐ]/.test(password)) {
        error += 'Lozinka mora da sadrži barem jedan specijalan karakter. <br>';
        errorExists = true;
    }
    if (!/[0-9]/.test(password)){
        error += 'Lozinka mora da sadrži barem jedan broj. <br>';
        errorExists = true;
    }

    //This check has advantage when it  comes to printing error, because error message is overwritten and not added to the last one!
    //It is = instead of +=
    if (password.length === 0) {
        error = 'Polje za lozinku je prazno.';
        errorExists = true;
    }
    if(errorExists){
        $('#registerPassword').addClass('is-invalid');
        errorPassword.html(error);
        isValid = false;
    }

    //Confirm passoword
    if(passwordConfirm !== password){
        $('#registerPasswordConfirm').addClass('is-invalid');
        errorPasswordConfirm.html('Lozinke se ne poklapaju.');
        isValid = false;
    }

    //Phone >9 <15 contains only numbers +
    if(phone.length < 9 || phone.length > 15 || /[^0-9+]/.test(phone)){
        $('#phone').addClass('is-invalid');
        errorPhone.html('Broj telefona nije ispravan.');
        isValid = false;
    }

    //Adresa
    if(address == '' || address.length > 50 ){
        $('#address').addClass('is-invalid');
        errorAddress.html('Adresa nije ispravna.');
        isValid = false;
    }

    return isValid;
}

function checkEmail(){

    let email = $('#registerEmail').val().trim();
    const errorEmail = $('#errorRegisterEmail').html('');
    //Is email address in use, in valid format or is it empty?
    if (!/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email) || email.length > 100) {
        $('#registerEmail').addClass('is-invalid');
        errorEmail.html('Email adresa nije validnog formata.');
        return false;
    }
    else {
        var formData = new FormData();
        formData.append('email', email);
        fetch('emailFreeCheck.php', {
            method: 'POST',
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                if(data.error === "0"){
                    checkBackendValidation();
                }
                else{
                    $('#registerEmail').addClass('is-invalid');
                    errorEmail.html("Email adresa je zauzeta.");
                    return false;
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                return false;
            });
    }
}

function checkBackendValidation(){
    let buttonLoad = document.querySelector("#registerButton");
    buttonLoad.innerHTML ='<img src="../public/images/loading.gif" alt="loading gif" height="20px" width="20px">';
    buttonLoad.disabled = true;
    var formData = new FormData(formRegister);
    fetch('registerValidation.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            let errorBox = $("#errorMessageRegister");
            let messageBox = $("#successSentVerification");

            //Clearovanje ukoliko je aktivna poruka
            if(errorBox.hasClass('activeMessage')){
                errorBox.removeClass("activeMessage");
            }
            if(messageBox.hasClass('activeMessage')){
                messageBox.removeClass("activeMessage");
            }
            
            if(data.error !== 0){ //Ukoliko backend vrati error
                errorBox.addClass("activeMessage");
                setTimeout(() => {
                    errorBox.removeClass("activeMessage");
                },7000)
            }
            if(data.error === 0){ //Ukoliko backend ne vrati error
                messageBox.addClass("activeMessage");
                setTimeout(() => {
                    messageBox.removeClass("activeMessage");
                },5000)
            }
            buttonLoad.innerHTML ="REGISTRUJTE SE!";
            buttonLoad.disabled = false;
        })
        .catch((error) => {
            buttonLoad.innerHTML ="REGISTRUJTE SE!";
            buttonLoad.disabled = false;
            console.error('Error:', error);
        });
}


