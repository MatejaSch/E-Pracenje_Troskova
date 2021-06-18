const inviteUserForm = document.querySelector("#inviteUserForm");
inviteUserForm.addEventListener("submit", (e) => {
    e.preventDefault();

    let addUser = document.querySelector("#addUser").value;
    let errorAddUser = document.querySelector("#errorAddUser");
    console.log(errorAddUser);

    //Is email address valid format
    if (!/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(addUser) || addUser.length > 100) {
        $('#addUser').addClass('is-invalid');
        errorAddUser.innerHTML = 'Email adresa nije validnog formata.';
        return false;
    }
    else {
        var formData = new FormData(inviteUserForm);
        $("#inviteUser").prop("disabled",true);
        fetch('inviteUser.php', {
            method: 'POST',
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                $("#inviteUser").prop("disabled",false);

                let messageBox = $("#successInvite");
                if(messageBox.hasClass('activeMessage')){
                    messageBox.removeClass("activeMessage");
                }
                if(data.error === 0){
                    messageBox.addClass("activeMessage");
                    $("#addUser").val('');//clear form input
                    setTimeout(() => {
                        messageBox.removeClass("activeMessage");
                    },5000)
                }
                else{
                    $('#addUser').addClass('is-invalid');
                    errorAddUser.innerHTML = "Greška prilikom pozivanja korisnika u domaćinstvo.";
                    return false;
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                return false;
            });
    }
});