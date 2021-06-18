const addCost = document.querySelector("#addCost");
const modalCost = document.querySelector("#modalCost");
const closeCost = document.querySelector("#closeCost")

//Showing modal for adding cost
addCost.addEventListener("click",() => {
    modalCost.classList.add("activeModal");
    loadChooseCat2();
});
//Closing modal cost
closeCost.addEventListener("click", () => {
    modalCost.classList.remove("activeModal");
});


//Load households categories
function loadChooseCat2(){
    let chooseCat = document.querySelector("#chooseCat2");
    chooseCat.innerHTML = "";
    fetch('loadCat.php', {
        method: 'POST',
    })
        .then(response => response.json())
        .then(data => {
            data.forEach(row => {
                chooseCat.innerHTML += `<option value="${row.id_cost_category}">${row.cost_category_name}</option>`;
            });
        })
        .catch((error) => {
            console.error('Error:', error);
            return false;
        });
}


const formInsertCost = document.querySelector("#formInsertCost");
formInsertCost.addEventListener("submit", (e) => {
    e.preventDefault();
    let validationError = false;

    //Initialisation of inputs
    let costName = document.querySelector("#costName");
    let costPrice = document.querySelector("#costPrice");
    let costCategory = document.querySelector("#chooseCat2");
    let costDescription = document.querySelector("#costDescription");

    //clearing red alerts on input
    for(let i=0; document.querySelectorAll('.form-control')[i];i++)
    {
        document.querySelectorAll('.form-control')[i].classList.remove('is-invalid');
    }
    //Errors
    let errorCostName = document.querySelector('#errorCostName');
    let errorCostPrice = document.querySelector('#errorCostPrice');
    let errorCostCategory = document.querySelector('#errorCostCategory');
    let errorCostDescription = document.querySelector('#errorCostDescription');

    //clearing all errors
    for(let i=0;document.querySelectorAll('.invalid-feedback')[i];i++)
    {
        document.querySelectorAll('.invalid-feedback')[i].innerHTML= '';
    }

    if(costName.value.length < 2){
        errorCostName.innerHTML += 'Ime mora da sadrzi najmanje 2 karaktera<br>';
        costName.classList.add('is-invalid');
        validationError = true;
    }

    let nameRegEx= new RegExp("^[a-z0-9A-ZčćžšđČĆŽŠĐ ']+$");
    if(nameRegEx.test(costName.value.trim()) === false)
    {
        errorCostName.innerHTML += 'Ime moze da sadrzi samo slova i brojeve';
        costName.classList.add('is-invalid');
        validationError = true;
    }

    if(parseInt(costPrice.value) < 0){
        errorCostPrice.innerHTML += 'Cena ne može biti negativna.<br>';
        costPrice.classList.add('is-invalid');
        validationError = true;
    }
    if(costPrice.value === '')
    {
        errorCostPrice.innerHTML += 'Popuni polje za cenu <br>';
        costPrice.classList.add('is-invalid');
        validationError = true;
    }
    if(costCategory.value === '')
    {
        errorCostCategory.innerHTML += 'Popunite polje za kategoriju <br>';
        costCategory.classList.add('is-invalid');
        validationError = true;
    }

    if(costDescription.value.length<1 || costDescription.value.length>255)
    {
        errorCostDescription.innerHTML += 'Polje za kategoriju mora da sadži 1-255 karaktera.<br>';
        costDescription.classList.add('is-invalid');
        validationError = true;
    }

    if(!validationError){
        let formData = new FormData();
        formData.append("costName", costName.value.trim());
        formData.append("costPrice", costPrice.value);
        formData.append("costCategory", costCategory.value);
        formData.append("costDescription", costDescription.value);
        formData.append("categoryID", $('#chooseCat').val());

        fetch('insertCost.php', {
            method: 'POST',
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                if(data.error === 0){
                    modalCost.classList.remove("activeModal");
                    loadCosts();
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                return false;
            });
    }

});

