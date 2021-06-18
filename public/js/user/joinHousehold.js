const joinHouseholdForm = document.querySelector("#joinHouseholdForm");
joinHouseholdForm.addEventListener("submit", (e) => {
    e.preventDefault();
    let household_code = document.querySelector("#household_code").value;
    let formData = new FormData(joinHouseholdForm);
    fetch('joinHousehold.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            let messageBox = $("#successJoin");
            if(messageBox.hasClass('activeMessage')){
                messageBox.removeClass("activeMessage");
            }
            let errorBox = $("#errorJoin");
            if(errorBox.hasClass('activeMessage')){
                errorBox.removeClass("activeMessage");
            }

            if(data.error === 0){
                messageBox.addClass("activeMessage");
                $("#household_code").val('');//clear form input
                setTimeout(() => {
                    messageBox.removeClass("activeMessage");
                },5000)
                showHouseholds();
            }
            else{
                errorBox.addClass("activeMessage");
                $("#household_code").val('');//clear form input
                setTimeout(() => {
                    errorBox.removeClass("activeMessage");
                },5000)
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            return false;
        });
});