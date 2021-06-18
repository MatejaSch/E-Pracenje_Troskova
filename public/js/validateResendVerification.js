const resendForm = document.querySelector("#resendForm");

resendForm.addEventListener("submit", (e) => {
    e.preventDefault();
    let input = $("#resendEmail").removeClass("is-invalid");
    let resendEmail = $("#resendEmail").val().trim();
    let errorResendEmail = $("#errorResendEmail").html('');

    //Is email address valid format
    if (!/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(resendEmail) || resendEmail.length > 100) {
        $('#resendEmail').addClass('is-invalid');
        errorResendEmail.html('Email adresa nije validnog formata.');
        return false;
    }
    else {
        var formData = new FormData(resendForm);
        fetch('validateResendVerification.php', {
            method: 'POST',
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                let messageBox = $(".successMessageRegister");
                if(messageBox.hasClass('activeMessage')){
                    messageBox.removeClass("activeMessage");
                }
                if(data.error === 0){
                    messageBox.addClass("activeMessage");
                    $("#resendEmail").val('');//clear form input
                    setTimeout(() => {
                        messageBox.removeClass("activeMessage");
                    },5000)
                }
                else{
                    $('#resendEmail').addClass('is-invalid');
                    errorResendEmail.html("Korisnik sa email adresom nije registrovan ili je već verifikovan.");
                    return false;
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                return false;
            });
    }
});