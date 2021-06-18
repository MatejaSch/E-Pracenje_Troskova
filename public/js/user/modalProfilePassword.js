//On submit
const formChangePassword = document.querySelector("#formChangePassword");
formChangePassword.addEventListener("submit", (e) => {
    e.preventDefault();
    if(validateProfilePassword()){ //If frontend validation is good send to backend
        let formData = new FormData(formChangePassword);
        fetch('changePassword.php', {
            method: 'POST',
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                $("#formChangePassword").trigger("reset");
                $("#oldPassword").val('');
                $("#newPassword").val('');
                $("#newPasswordConfirm").val('');
                if(data.error === 0){
                    alert("Uspesno promenjena lozinka!");
                    $("#formChangePassword").trigger("reset");
                    $("#oldPassword").val('');
                    $("#newPassword").val('');
                    $("#newPasswordConfirm").val('');
                }
                if(data.error === 2)
                {
                    $('#oldPassword').addClass('is-invalid');
                    $('#errorOldPassword').html("Lozinka nije dobra.");
                }
                if(data.error === 1)
                {
                    alert('Doslo je do greske');
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                $("#formChangePassword").trigger("reset");
                return false;
            });
    }
});


function validateProfilePassword(){

    isValid=true;

    const oldPassword = $('#oldPassword').val();
    const newPassword = $('#newPassword').val();
    const newPasswordConfirm = $('#newPasswordConfirm').val();


    //error inputs
    const errorOldPassword = $('#errorOldPassword').html('');
    const errorNewPassword = $('#errorNewPassword').html('');
    const errorNewPasswordConfirm = $('#errorNewPasswordConfirm').html('');

    //Clearing error CSS class
    const inputs = formChangePassword.querySelectorAll(".form-control");
    inputs.forEach(input => input.classList.remove('is-invalid'));


    //Password min 8 characters max 30, must contain uppercase letter, lowercase letter, special character and one number at least
    let error = "";
    let errorExists = false;

    if (newPassword.length < 8){
        error += 'Lozinka je prekratka. <br>';
        errorExists = true;
    }
    if (newPassword.length > 30) {
        error += 'Lozinka je predugačka. <br>';
        errorExists = true;
    }
    if (!/[a-zčćžšđ]/.test(newPassword)) {
        error += 'Lozinka mora da sadrži barem jedno malo slovo. <br>';
        errorExists = true;
    }
    if (!/[A-ZČĆŽŠĐ]/.test(newPassword)) {
        error += 'Lozinka mora da sadrži barem jedno veliko slovo. <br>';
        errorExists = true;
    }
    if (!/[^a-zA-Z0-9čćžšđČĆŽŠĐ]/.test(newPassword)) {
        error += 'Lozinka mora da sadrži barem jedan specijalan karakter. <br>';
        errorExists = true;
    }
    if (!/[0-9]/.test(newPassword)){
        error += 'Lozinka mora da sadrži barem jedan broj. <br>';
        errorExists = true;
    }

    //This check has advantage when it  comes to printing error, because error message is overwritten and not added to the last one!
    //It is = instead of +=
    if (newPassword.length === 0) {
        error = 'Polje za lozinku je prazno.';
        errorExists = true;
    }
    if(errorExists){
        $('#newPassword').addClass('is-invalid');
        errorNewPassword.html(error);
        isValid = false;
    }

    //Confirm passowords
    if(newPassword !== newPasswordConfirm){
        $('#newPasswordConfirm').addClass('is-invalid');
        errorNewPasswordConfirm.html('Lozinke se ne poklapaju.');
        isValid = false;
    }

    //Old password
    if(oldPassword.length === 0){
        $('#oldPassword').addClass('is-invalid');
        errorOldPassword.html('Polje ne sme biti prazno.');
        isValid = false;
    }


    return isValid;
}



