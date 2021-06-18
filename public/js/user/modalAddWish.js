const addWish = document.querySelector("#addWish");
const modalWish = document.querySelector("#modalWish");
const closeWish = document.querySelector("#closeWish")

addWish.addEventListener("click",() => {
    modalWish.classList.add("activeModal");
    loadChooseCat();
});

closeWish.addEventListener("click", () => {
    modalWish.classList.remove("activeModal");
});



function loadChooseCat(){
    let chooseCat = document.querySelector("#chooseCat");
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


const formInsertWish = document.querySelector("#formInsertWish");
formInsertWish.addEventListener("submit", (e) => {
    e.preventDefault();
    let ValidationError = false;

    //Initialisation of inputs
    let wishName = document.querySelector("#wishName");
    let wishPrice = document.querySelector("#wishPrice");
    let wishCategory = document.querySelector("#chooseCat");
    let wishExpDate = document.querySelector("#date-real");
    //crearing red alerts on input
    for(let i=0;document.querySelectorAll('.form-control')[i];i++)
    {
        document.querySelectorAll('.form-control')[i].classList.remove('is-invalid');
    }
    //Errors
    let wishNameError = document.querySelector('#errorWishName');
    let wishPriceError = document.querySelector('#errorWishPrice');
    let wishCategoryError = document.querySelector('#errorWishCategory');
    let wishDateError = document.querySelector('#errorWishDate');
    //clearing all errors
    for(let i=0;document.querySelectorAll('.invalid-feedback')[i];i++)
    {
        document.querySelectorAll('.invalid-feedback')[i].innerHTML= '';
    }

    if(wishName.value.length < 2){
        wishNameError.innerHTML += 'Ime mora da sadrzi najmanje 2 karaktera<br>';
        wishName.classList.add('is-invalid');
        ValidationError = true;
    }

    let nameRegEx= new RegExp("^[a-z0-9A-ZčćžšđČĆŽŠĐ ']+$");
    if(nameRegEx.test(wishName.value.trim()) === false)
    {
        wishNameError.innerHTML += 'Ime moze da sadrzi samo slova i brojeve';
        wishName.classList.add('is-invalid');
        ValidationError = true;
    }

    if(parseInt(wishPrice.value) < 0){
        wishPriceError.innerHTML += 'Cena ne moze biti negativna <br>';
        wishPrice.classList.add('is-invalid');
        ValidationError = true;
    }
    if(wishPrice.value === '')
    {
        wishPriceError.innerHTML += 'Popuni polje za cenu <br>';
        wishPrice.classList.add('is-invalid');
        ValidationError = true;
    }
    if(wishCategory.value === '')
    {
        wishCategoryError.innerHTML += 'Popunite polje za kategoriju <br>';
        wishCategory.classList.add('is-invalid');
        ValidationError = true;
    }
    //CHecks if date is from the future
    if(parseInt(Date.parse(wishExpDate.value))-parseInt(Date.now())<0)
    {
        wishDateError.innerHTML += 'Datum mora biti najmanje sutrasnji<br>';
        wishExpDate.classList.add('is-invalid');
        ValidationError = true;
    }
    if(wishExpDate.value === '')
    {
        wishDateError.innerHTML += 'Popunite plje za datum<br>';
        wishExpDate.classList.add('is-invalid');
        ValidationError = true;
    };

    if(!ValidationError){
        let formData = new FormData();
        formData.append("wishName", wishName.value.trim());
        formData.append("wishPrice", wishPrice.value);
        formData.append("wishCategory", wishCategory.value);
        formData.append("dateExp", wishExpDate.value);
        formData.append("categoryID", $('#chooseCat').val());
        fetch('insertWish.php', {
            method: 'POST',
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                if(data.error === 0){
                    modalWish.classList.remove("activeModal");
                    loadWishes();
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                return false;
            });
    }

});

