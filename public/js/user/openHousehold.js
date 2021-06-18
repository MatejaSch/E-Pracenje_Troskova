function getHouseholds(){
    let householdCards = document.querySelectorAll(".exists");
    householdCards.forEach(household => {
    household.addEventListener("click", (e) => {
        let id = household.children[0].children[1].innerHTML;
        location.href="householdSession.php?id="+id;
        });
    });
}

