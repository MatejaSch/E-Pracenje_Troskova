const addHousehold = document.querySelector("#addIconHousehold"); //button
const modalAddHousehold = document.querySelector("#modalAddHousehold"); //modal div
const modalCard = document.querySelector("#modalAddHousehold").children[0]; //card>form
const close = document.querySelector("#closeModalHousehold"); //x button

//Ako klikne na karticu stop propagation
modalCard.addEventListener("click", (e) => {
    e.stopPropagation();
});

//Prikazi modal na klik
addHousehold.addEventListener("click", () => {
    modalAddHousehold.classList.add("activeModal");
});

//Ako klikne x ili sastrane ugasi ga
close.addEventListener("click", removeModal);
modalAddHousehold.addEventListener("click", removeModal);

function removeModal(){
    modalAddHousehold.classList.remove("activeModal");
}








