const  editName = document.querySelectorAll(".editName")[0];
const  modalChangeHouseholdName = document.getElementById('modalChangeHouseholdName'); //Block
const  changeHouseholdName = document.getElementById('ChangeHouseholdName'); //form
const  close = document.querySelector("#closeModalChangeHouseholdName"); //x button

//close modal
document.getElementById('ChangeHouseholdNamePropagation').addEventListener('click',(e)=>{
    e.stopPropagation();
});
close.addEventListener('click',closeModal);
modalChangeHouseholdName.addEventListener('click',closeModal);

editName.addEventListener("click", () => {
    //show ChangeName modal
    modalChangeHouseholdName.classList.add('activeModal');
});

changeHouseholdName.addEventListener('submit',(e)=>{
    e.preventDefault();

    let  newNameInput =  document.getElementById('NewHouseholdName');
    let  newNameError =  document.getElementById('errorNewHouseholdName');

    //clearing validations
    newNameInput.classList.remove('is-invalid');

    //clearing errors
    newNameError.innerHTML="";
    console.log(newNameInput.value.trim());
    if(newNameInput.value.trim() === "" || newNameInput.value.trim().length > 30){
        newNameInput.classList.add('is-invalid');
        newNameError.innerHTML='Polje za ime domaćistva mora da sadrži od 1-30 karaktera!';
    }
    else{
        console.log('ulazi u fetch');
        var formData = new FormData(changeHouseholdName);
        fetch("changeHouseholdName.php", {
            method: 'POST',
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                if(data.error === 1){
                    newNameInput.classList.add('is-invalid');
                    newNameError.innerHTML='Uneli ste staro sadašnje ime domaćinstva';
                }
                if(data.error === 0){
                    location.href='household.php';
                    /*
                    $("#successMessageHousehold").addClass("activeMessage");
                    setTimeout(() => {
                        $("#successMessageHousehold").removeClass("activeMessage");
                    },7000)
                    showHouseholds();
                    $("#modalAddHousehold").removeClass("activeModal");
                    $("#householdName").val('');
                     */
                }
                if(data.error === 'PDO EXCEPTION'){
                    console.log('exception');
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                return false;
            });
    }
})

function closeModal(){
    modalChangeHouseholdName.classList.remove('activeModal');
}