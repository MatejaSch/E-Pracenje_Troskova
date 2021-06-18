const form = document.querySelector("#formSubmit");

window.addEventListener('load', function () {
    form.click();
})

form.addEventListener("click", (e) => {
    e.preventDefault();

    const household = document.querySelector("#household").value.trim();
    //let formData = new FormData(form);

    //Clearing
    const main = document.querySelectorAll(".main")[0];
    const householdCards = document.querySelectorAll(".household-users");


    if (householdCards.length !== 0) {
        main.innerHTML = "";
    }

    let formData = new FormData();
    formData.append("household_name", document.getElementById("household").value);
    formData.append("user_name", document.getElementById("email").value);
    fetch('showHouseholds.php', {
        method: 'POST',
        body : formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.error === 1) {
                console.log("error");
            } else {
                var main = document.querySelectorAll(".main")[0];
                data.forEach(row => {
                    const householdUsers = document.createElement("div");
                    const household = document.createElement("div");
                    householdUsers.classList.add("household-users");
                    household.classList.add("household");
                    household.innerHTML = `<div class="household-name" id="${row.id_household}"><b>DOMAĆINSTVO: </b><span>${row.household_name}</span><span>ID: ${row.id_household}</span><span>PRISTUP: ${row.access}</span><span class="btn btn-primary" onclick="changeAccess(${row.id_household})">PROMENI PRISTUP</span></div>`;
                    householdUsers.appendChild(household);
                    main.appendChild(householdUsers);
                    fetchUsers(row.id_household);
                });
            }
        })
        .catch((error) => {
            console.log('error:', error);
            return false;
        });
});

function fetchUsers(p) {
    let formData = new FormData();
    formData.append("household_name", p);
    formData.append("email", document.getElementById("email").value);

    fetch('showUsers.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.error === 1) {
                console.log("error");
            } else {
              //  const email = document.querySelector("#email").value.trim();
                data.forEach(row => {
                    const container = document.getElementById(`${row.id_household}`).parentElement;
                    const fill = document.createElement("div");
                    fill.classList.add("user");
                    fill.innerHTML = `<span><img src="../../public/images/icons/person-circle.svg">  ${row.name} ${row.lastname}</span>
                                        <span>EMAIL: ${row.email}</span><span class="btn btn-primary"  onclick="openModal(${row.id_user})">PROMENI LOZINKU</span>
                                        `;
                    const span = document.createElement('span');
                    span.setAttribute('data-id',row.id_user);
                    span.setAttribute('data-banned',row.is_banned);
                    span.className = `ban ${!parseInt(row.is_banned) ? 'btn btn-danger' : 'btn btn-success'}`;
                    span.innerText = `${parseInt(row.is_banned) ? 'UNBAN' : 'BAN'}`;
                    fill.appendChild(span);
                    container.appendChild(fill);
                    banUnban(span);
                });
            }
        })
        .catch((error) => {
            console.log('error:', error);
            return false;
        });
}

//ban / unban
function banUnban(button){
    button.addEventListener('click', () => {
        let id_user = button.getAttribute("data-id");
        let banned = button.getAttribute("data-banned");
        let formData = new FormData();
        formData.append("id_user", id_user);
        formData.append("banned", banned);
        fetch('banUnban.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.error === 1) {
                    console.log("error");
                } else {
                    const buttons = document.querySelectorAll(".ban");
                    buttons.forEach(button => {
                        if(button.getAttribute("data-id") === data.id_user){
                            button.setAttribute('data-banned',data.is_banned);
                            button.setAttribute('data-id',data.id_user);
                            button.className = `ban ${!parseInt(data.is_banned) ? 'btn btn-danger' : 'btn btn-success'}`;
                            button.innerText = `${parseInt(data.is_banned) ? 'UNBAN' : 'BAN'}`;
                        }
                    });
                }
            })
            .catch((error) => {
                console.log('error:', error);
                return false;
            });
    });
}

function openModal(user_id){
    let Modal = document.getElementById("modalForgot");
    let exitButton = document.querySelector(".modal img");
    let forma = document.querySelector("#forgotForm");
    let ErrorPassword= document.getElementById('errorForgotEmail');
    let card= document.querySelector('.card');

    //Exit change password block
    Modal.classList.add('activeModal');
    exitButton.addEventListener('click',function(){
        ErrorPassword = "";
        Modal.classList.remove('activeModal');
    });
    Modal.addEventListener('click',function(){
        ErrorPassword = "";
        Modal.classList.remove('activeModal');
    });
    //Changing password
    card.addEventListener('click',(e)=>{e.stopPropagation();})
    forma.addEventListener('submit',(e)=>{
        e.preventDefault();

        let error= false;
        let errorMessage = "";
        let password = document.getElementById('forgotEmail').value;

        if (password.length < 8){
            errorMessage += 'Lozinka je prekratka. <br>';
            error = true;
        }
        if (password.length > 30) {
            errorMessage += 'Lozinka je predugačka. <br>';
            error = true;
        }
        if (!/[a-zčćžšđ]/.test(password)) {
            errorMessage += 'Lozinka mora da sadrži barem jedno malo slovo. <br>';
            error = true;
        }
        if (!/[A-ZČĆŽŠĐ]/.test(password)) {
            errorMessage += 'Lozinka mora da sadrži barem jedno veliko slovo. <br>';
            error = true;
        }
        if (!/[^a-zA-Z0-9čćžšđČĆŽŠĐ]/.test(password)) {
            errorMessage += 'Lozinka mora da sadrži barem jedan specijalan karakter. <br>';
            error = true;
        }
        if (!/[0-9]/.test(password)){
            errorMessage += 'Lozinka mora da sadrži barem jedan broj. <br>';
            error = true;
        }

        //Dadati polje za lozinku je prazno umesto += samo = message

        if(error){
            document.getElementById('forgotEmail').classList.add('is-invalid');
            ErrorPassword.innerHTML = errorMessage;
        }
        else{
            //AJAX FOR ALTERING PASSWORD
            let formData = new FormData();
            formData.append("user_id",user_id);
            formData.append("new_password",password);
            console.log(user_id+""+password);
            fetch('changePassword.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    let messageBox = $("#succesChangingPassword");
                    if(messageBox.hasClass('activeMessage')){
                        messageBox.removeClass("activeMessage");
                    }
                    if (data.error === 1) {
                        console.log("Doslo je do greske");
                    } else {
                        messageBox.addClass("activeMessage");
                        setTimeout(() => {
                            messageBox.removeClass("activeMessage");
                        },5000)
                        Modal.classList.remove('activeModal');
                        $("#forgotEmail").val('');
                        console.log("Sifra je uspesno promenjena");
                    }
                })
                .catch((error) => {
                    console.log('error:', error);
                    return false;
                });
        }
    })
}

function changeAccess(id_household){
    let householdID = id_household;
    let formData = new FormData();
    formData.append("householdID", householdID);
    fetch('changeAccess.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.error === 0) {
                form.click();
            }
            else {
                console.log("error");
            }
        })
        .catch((error) => {
            console.log('error:', error);
            return false;
        });
}
