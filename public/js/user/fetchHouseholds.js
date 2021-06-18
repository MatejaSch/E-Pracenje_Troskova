window.addEventListener("DOMContentLoaded", showHouseholds); //Show households on page load

function showHouseholds(){
    const grid = document.querySelectorAll(".grid")[0];
    fetch('showUserHouseholds.php', {
        method: 'POST',
    })
        .then(response => response.json())
        .then(data => {
            if(data.error === 1){
                console.error("ERROR pri ucitavanju");
            }
            else{
                grid.innerHTML = "";
                data.forEach(row => {
                    if(row.id_role === "1"){ //Show delete option if user is administrator of household
                        const gridItem = document.createElement("div");
                        gridItem.classList.add("grid-item");
                        gridItem.innerHTML = `<div class="card card-household exists">
                                            <div class="card-body">
                                                <div class="card-title">${row.household_name}</div>
                                                <div class="household-id">${row.household_id}</div>
                                                <div><img src="../../public/images/icons/door-open.svg"></div>
                                            </div>
                                         </div> `;
                        let closeButton = document.createElement("img");
                        closeButton.src = "../../public/images/icons/x-lg.svg";
                        closeButton.classList.add("iconClose");
                        closeButton.setAttribute("data-id", row.household_id);
                        closeButton.addEventListener("click", deleteHousehold);
                        gridItem.firstChild.appendChild(closeButton);
                        grid.append(gridItem);
                    }
                    else{
                        const gridItem = document.createElement("div");
                        gridItem.classList.add("grid-item");
                        gridItem.innerHTML = `<div class="card card-household exists">
                                            <div class="card-body">
                                                <div class="card-title">${row.household_name}</div>
                                                <div class="household-id">${row.household_id}</div>
                                                <div><img src="../../public/images/icons/door-open.svg"></div>
                                            </div>
                                         </div> `;
                        grid.append(gridItem);
                    }
                    getHouseholds(); //calls function that gives add  event listeners to these ("cards" div) elements
                });
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            return false;
        });
}

function deleteHousehold(e){
    e.stopPropagation();

    let householdID = e.target.getAttribute("data-id");

    // dialogModal for deleting household
    const modalDeleteHousehold = document.querySelector("#modalDialog"); //modal
    const deleteHouseholdForm = document.querySelector("#dialogForm"); //form
    const hiddenInput = document.querySelector("#removeID"); //hidden input for id parameter
    const question = document.querySelector("#question"); //question

    hiddenInput.value = householdID; //get ID of deleted item
    modalDeleteHousehold.classList.add("activeModal");
    question.innerHTML = "Da li ste sigurni da želite da obrišete domaćinstvo?";

    //If user accepts dialog
    deleteHouseholdForm.addEventListener("submit", deleteSubmit);
    function deleteSubmit(e){
            e.preventDefault();

            //Remove event listeners for dialog bog
            deleteHouseholdForm.removeEventListener("reset", deleteReset);
            deleteHouseholdForm.removeEventListener("submit", deleteSubmit);

            let formData = new FormData();
            formData.append("householdID", householdID);
            fetch('deleteHousehold.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if(data.error === 0){
                        showHouseholds();
                        modalDeleteHousehold.classList.remove("activeModal");
                        $("#removeID").val('');
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                    return false;
                });
    }

    //If dialog rejected
    deleteHouseholdForm.addEventListener("reset", deleteReset);
    function deleteReset(e){
            e.preventDefault();

            //Remove event listeners for dialog bog
            deleteHouseholdForm.removeEventListener("reset", deleteReset);
            deleteHouseholdForm.removeEventListener("submit", deleteSubmit);

            modalDeleteHousehold.classList.remove("activeModal");
            $("#removeID").val('');
    }


}
