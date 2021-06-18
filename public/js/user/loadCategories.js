const category = document.querySelector("#category");

window.addEventListener('DOMContentLoaded', (event) => {
    loadCategories();
    loadWishes();
    loadCosts();
});

function loadCategories(){
    category.innerHTML = "";
        fetch('loadCat.php', {
        method: 'POST',
    })
        .then(response => response.json())
        .then(data => {
            data.forEach(row => {
                category.innerHTML += `<option value="${row.id_cost_category}">${row.cost_category_name}</option>`;
            });
        })
        .catch((error) => {
            console.error('Error:', error);
            return false;
        });
}

//Create new category
const buttonAdd = document.querySelector("#addCategory");
buttonAdd.addEventListener("click", addCategory);
function addCategory(){

    //Check if category name is between 2-40 chars and if it already exists
    let newCategory = document.querySelector("#newCategory").value;
    $("#errorAddCat").html('');
    $("#newCategory").removeClass("errorCategory");

    if(newCategory.length > 1 && newCategory.length < 40){

        let formData = new FormData();
        formData.append("newCategory", newCategory);
        fetch('addCat.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                //If there is not error
                if(data.error === 0){
                    loadCategories();
                    $("#newCategory").val('');
                }
                //If category already exists
                if(data.error === 2){
                    $("#errorAddCat").html("Kategorija već postoji");
                    $("#newCategory").addClass("errorCategory");
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                return false;
            });
    }
    else{
        //If not valid input error
        $("#errorAddCat").html("Ime kategorije mora da sadrži 2-40 karaktera");
        $("#newCategory").addClass("errorCategory");
    }
}

//Remove selected category
const buttonDelete = document.querySelector("#deleteCategory");
buttonDelete.addEventListener("click",  deleteCategory);
async function deleteCategory(){
    let categoryID = document.querySelector("#category").value;

    if(categoryID === ""){ return false;}
    // dialogModal for removing category
    const modalRemoveCategory = document.querySelector("#modalDialog"); //modal
    const removeCategoryForm = document.querySelector("#dialogForm"); //form
    const hiddenInput = document.querySelector("#removeID"); //hidden input for id parameter
    const question = document.querySelector("#question"); //question

    //Don't let user delete category that is used for existing costs/wishes
    let check = await categoryUseCheck(categoryID);

    if(check){
        //Shows up the dialog window
        hiddenInput.value = categoryID //get ID of deleted item
        modalRemoveCategory.classList.add("activeModal"); //show modal
        question.innerHTML = "Da li ste sigurni da želite da obrišete kategoriju?";

        //If dialog get accepted
        removeCategoryForm.addEventListener("submit", removeCategorySubmit);
        function removeCategorySubmit(e){
            e.preventDefault();

            //Remove event listeners for dialog bog
            removeCategoryForm.removeEventListener("reset", removeCategoryReset);
            removeCategoryForm.removeEventListener("submit", removeCategorySubmit);

            let formData = new FormData();
            formData.append("categoryID", categoryID);
            fetch('deleteCat.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if(data.error === 0){
                        loadCategories();
                        //If successfully removed category remove dialog and its question (and hidden input)
                        question.innerHTML = "";
                        $('#modalDialog').removeClass("activeModal");
                        $("#removeID").val('');
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                    return false;
                });
        }

        removeCategoryForm.addEventListener("reset", removeCategoryReset);
        function removeCategoryReset(e){
            e.preventDefault();

            //Remove event listeners for dialog bog
            removeCategoryForm.removeEventListener("reset", removeCategoryReset);
            removeCategoryForm.removeEventListener("submit", removeCategorySubmit);

            modalRemoveCategory.classList.remove("activeModal");
            $("#removeID").val('');
        }

    }
}

async function categoryUseCheck(categoryID){
    $("#errorDeleteCat").html('');
    $("#category").removeClass("errorCategory");
    let formData = new FormData();
    formData.append("categoryID", categoryID);
    const response = await fetch('categoryUseCheck.php', {
        method: 'POST',
        body: formData
    });
    const data = await response.json();
    if(data.used === 1){
        $("#errorDeleteCat").html("Ne možete obrisati kategoriju koja se koristi!");
        $("#category").addClass("errorCategory");
        return false;
    }
    else{
        return true;
    }
}

