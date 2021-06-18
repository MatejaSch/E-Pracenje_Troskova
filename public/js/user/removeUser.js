function removeUser(){
    const removeUser = document.querySelectorAll(".removeUser"); //remove button

    // dialogModal for removing user from household
    const modalRemoveUser = document.querySelector("#modalDialog"); //modal
    const removeUserForm = document.querySelector("#dialogForm"); //form
    const hiddenInput = document.querySelector("#removeID"); //hidden input for id parameter
    const question = document.querySelector("#question"); //question

    removeUser.forEach(button => {
        button.addEventListener("click", (e) => {
            hiddenInput.value = e.target.getAttribute("data-id"); //get ID of deleted item
            modalRemoveUser.classList.add("activeModal");
            question.innerHTML = "Da li ste sigurni da želite da obrišete korisnika iz domaćinstva?";
        });
    });




    //If dialog gets rejected
    removeUserForm.addEventListener("reset", removeUserReset);
    function removeUserReset(e){
        e.preventDefault();

        //Remove event listeners for dialog bog
        removeUserForm.removeEventListener("reset", removeUserReset);
        removeUserForm.removeEventListener("submit", removeUserSubmit);

        modalRemoveUser.classList.remove("activeModal");
        $('#removeID').val('');
    }



    //If dialog gets accepted
    removeUserForm.addEventListener("submit", removeUserSubmit);
    function removeUserSubmit(e){
        e.preventDefault();

        //Remove event listeners for dialog bog
        removeUserForm.removeEventListener("reset", removeUserReset);
        removeUserForm.removeEventListener("submit", removeUserSubmit);

        let formData = new FormData(removeUserForm);
        fetch('removeUser.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if(data.error === 0){
                    loadHouseholdUsers();
                    //If successfully removed user remove dialog and its question (and hidden input)
                    question.innerHTML = "";
                    $('#modalDialog').removeClass("activeModal");
                    $('#dialogForm').trigger("reset");
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                return false;
            });
    }
}