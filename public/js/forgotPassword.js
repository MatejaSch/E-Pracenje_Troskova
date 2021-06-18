const forgotForm = document.querySelector("#forgotForm");

forgotForm.addEventListener("submit", (e) => {
    e.preventDefault();

    $("#forgotEmail").removeClass("is-invalid");
    let forgotEmail = $("#forgotEmail").val().trim();
    let errorForgotEmail = $("#errorForgotEmail").html('');

    //Is email address valid format
    if (!/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(forgotEmail) || forgotEmail.length > 100) {
        $('#forgotEmail').addClass('is-invalid');
        errorForgotEmail.html('Email adresa nije validnog formata.');
        return false;
    }
    else {
        var formData = new FormData(forgotForm);
        $('#forgotPasswordSubmitButton').html('<img src="../public/images/loading.gif" alt="loading gif" height="20px" width="20px">');
        $('#forgotPasswordSubmitButton').prop( "disabled", true )
        fetch('forgotPassword.php', {
            method: 'POST',
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                let messageBox = $("#successForgotPassword");
                let errorBox = $("#errorForgotPassword");

                if(messageBox.hasClass('activeMessage')){
                    messageBox.removeClass("activeMessage");
                }
                if(errorBox.hasClass('activeMessage')){
                    errorBox.removeClass("activeMessage");
                }

                if(data.error === 0){
                    messageBox.addClass("activeMessage");
                    $("#forgotEmail").val('');//clear form input
                    setTimeout(() => {
                        messageBox.removeClass("activeMessage");
                    },5000);
                    $('#modalForgot').removeClass('activeModal');
                }
                if(data.error === 1){
                    errorBox.addClass("activeMessage");
                    $("#forgotEmail").val('');//clear form input
                    setTimeout(() => {
                        errorBox.removeClass("activeMessage");
                    },5000);
                }
                if(data.error === 2){
                    $('#forgotEmail').addClass('is-invalid');
                    errorForgotEmail.html("Korisnik sa email adresom nije registrovan");
                }
                $('#forgotPasswordSubmitButton').html('Zatraži promenu šifre!');
                $('#forgotPasswordSubmitButton').prop( "disabled", false )
            })
            .catch((error) => {
                console.error('Error:', error);
                $('#forgotPasswordSubmitButton').html('Zatraži promenu šifre!');
                $('#forgotPasswordSubmitButton').prop( "disabled", false )
                return false;
            });
    }
});