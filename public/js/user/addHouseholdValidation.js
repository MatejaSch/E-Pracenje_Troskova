const formAddHousehold = document.querySelector("#addHousehold");

formAddHousehold.addEventListener("submit", (e) => {
    e.preventDefault();

    const householdName = $('#householdName').val().trim();
    $('#householdName').removeClass('is-invalid');
    const errorHouseholdName = $('#errorHouseholdName').html('');


    if(householdName === "" || householdName.length > 50){
        $('#householdName').addClass('is-invalid');
        errorHouseholdName.html('Polje za ime domaćistva mora da sadrži od 1-50 karaktera!');
    }
    else{
        var formData = new FormData(formAddHousehold);
        fetch("addHousehold.php", {
            method: 'POST',
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                if(data.error === 1){
                   $("#errorMessageHousehold").addClass("activeMessage");
                    setTimeout(() => {
                        $("#errorMessageHousehold").removeClass("activeMessage");
                    },7000)
                }
                if(data.error === 0){
                    $("#successMessageHousehold").addClass("activeMessage");
                    setTimeout(() => {
                        $("#successMessageHousehold").removeClass("activeMessage");
                    },7000)
                    showHouseholds();
                    $("#modalAddHousehold").removeClass("activeModal");
                    $("#householdName").val('');
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                return false;
            });
    }
});