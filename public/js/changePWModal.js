function changePWModal(){

    const modalChangePW = document.querySelector("#modalChangePW");
    modalChangePW.classList.add("activeModal"); //Display modal

    //On form submit
    const changePWForm = document.querySelector("#changePWForm");
    changePWForm.addEventListener("submit", (e) => {
        e.preventDefault();

        if(passwordValidation()){
            //INSERT code into form
            let url = location.search;
            document.querySelector("#code").value = url.split('=')[1];
            changePWForm.submit();
        }

    });

    function passwordValidation(){
        let inputPassword = document.querySelector("#newPassword").value;
        let inputConfirmPassword = document.querySelector("#confirmNewPassword").value;
        let errorPassword = document.querySelector("#errorNewPassword");
        let errorConfirmPassword = document.querySelector("#errorConfirmNewPassword");

        //Clearing error message and is-invalid before every check
        errorPassword.innerHTML = "";
        if($("#newPassword").has("is-invalid")){
            $("#newPassword").removeClass('is-invalid');
        }
        errorConfirmPassword.innerHTML = "";
        if($("#confirmNewPassword").has("is-invalid")){
            $("#confirmNewPassword").removeClass('is-invalid');
        }

        let error= false;
        let errorMessage = "";

        if (inputPassword.length < 8){
            errorMessage += 'Lozinka je prekratka. <br>';
            error = true;
        }
        if (inputPassword.length > 30) {
            errorMessage += 'Lozinka je predugačka. <br>';
            error = true;
        }
        if (!/[a-zčćžšđ]/.test(inputPassword)) {
            errorMessage += 'Lozinka mora da sadrži barem jedno malo slovo. <br>';
            error = true;
        }
        if (!/[A-ZČĆŽŠĐ]/.test(inputPassword)) {
            errorMessage += 'Lozinka mora da sadrži barem jedno veliko slovo. <br>';
            error = true;
        }
        if (!/[^a-zA-Z0-9čćžšđČĆŽŠĐ]/.test(inputPassword)) {
            errorMessage += 'Lozinka mora da sadrži barem jedan specijalan karakter. <br>';
            error = true;
        }
        if (!/[0-9]/.test(inputPassword)){
            errorMessage += 'Lozinka mora da sadrži barem jedan broj. <br>';
            error = true;
        }

        if (inputPassword.length === 0){
            errorMessage = "Polje za lozinku je prazno";
        }

        if(error){
            $("#newPassword").addClass('is-invalid');
            errorPassword.innerHTML = errorMessage;
            return false;
        }
        else{
            //If there are no errors with password check if it matches with confirmed password
            if(inputPassword !== inputConfirmPassword){
                $("#confirmNewPassword").addClass('is-invalid');
                errorConfirmPassword.innerHTML = "Lozinke se ne poklapaju";
                return false;
            }
            else{
                return true;
            }
        }
    }

    //Close modal
    const close = document.querySelector("#closeChangePWForm"); //X button
    close.addEventListener("click", closePWModal);
    modalChangePW.addEventListener("click", closePWModal);

    function closePWModal(){
        modalChangePW.classList.remove("activeModal");
    }

}

