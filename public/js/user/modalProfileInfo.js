const profileButton = document.querySelectorAll(".profileInfo");
const modalProfileInfo = document.querySelector("#modalProfileInfo");
const closeProfileInfo = document.querySelector("#closeProfileInfo");

//Open modal
profileButton.forEach(button => {
   button.addEventListener("click", ()=>{
        modalProfileInfo.classList.add("activeModal");
        loadData();
   });
});

//Close modal
closeProfileInfo.addEventListener("click", () => {
    modalProfileInfo.classList.remove("activeModal");
});

//On submit
const profileInfoForm = document.querySelector("#formProfileInfo");
profileInfoForm.addEventListener("submit", (e) => {
    e.preventDefault();
    if(validateProfileInfo()){ //If frontend validation is good send to backend
        let formData = new FormData(profileInfoForm);
        fetch('updateProfileInfo.php', {
            method: 'POST',
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                let errorBox = $("#errorProfileDataChanged");
                let errorUpdateBox = $("#errorProfileDataAreSame");
                let messageBox = $("#successProfileDataChanged");

                //Clearovanje poruke ukoliko postoji
                if(errorBox.hasClass("activeMessage")){
                    errorBox.removeClass("activeMessage");
                }
                if(messageBox.hasClass("activeMessage")){
                    messageBox.removeClass("activeMessage");
                }

                //if there is no error(true)
                if(data.error === 0){
                    messageBox.addClass("activeMessage");
                    setTimeout(() => {
                        messageBox.removeClass("activeMessage");
                    },7000)

                }
                //Data are no distinct
                else if(data.error === 1){
                    errorUpdateBox.addClass("activeMessage");
                    setTimeout(() => {
                        errorUpdateBox.removeClass("activeMessage");
                    },7000);
                }
                //pdo exception or some other error
                else{
                    errorBox.addClass("activeMessage");
                    setTimeout(() => {
                        errorBox.removeClass("activeMessage");
                    },7000)
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                return false;
            });
    }
});

//LoadModal with data
function loadData(){
    let formData = new FormData(profileInfoForm);
    fetch('loadProfileData.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            document.querySelector("#name").value = data.name;
            document.querySelector("#lastname").value = data.lastname;
            document.querySelector("#phone").value = data.phone;
            document.querySelector("#address").value = data.address;
        })
        .catch((error) => {
            console.error('Error:', error);
            return false;
        });
}

function validateProfileInfo(){
    isValid = true;
    //value inputs
    const name = $('#name').val().trim();
    const lastname = $('#lastname').val().trim();
    const phone = $('#phone').val().trim();
    const address = $('#address').val().trim();

    //error inputs
    const errorName = $('#errorName').html('');
    const errorLastname = $('#errorLastname').html('');
    const errorPhone = $('#errorPhone').html('');
    const errorAddress = $('#errorAddress').html('');

    //Clearing error CSS class
    const inputs = profileInfoForm.querySelectorAll(".form-control");
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
    if (lastname == "" || lastname.length > 30 || nameRegEx.test(lastname) === false) {
        $('#lastname').addClass('is-invalid');
        errorLastname.html('Prezime mora da sadrži 1-30 isključivo slovnih karaktera.');
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



