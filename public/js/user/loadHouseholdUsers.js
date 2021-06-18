function loadHouseholdUsers(){
    fetch('loadHouseholdUsers.php', {
        method: 'POST',
    })
        .then(response => response.json())
        .then(data => {
            if(data.error !== 1){
                const gridItem = document.querySelector("#usersData");
                gridItem.innerHTML = "";
                data.forEach(row => {
                    if(row.id_role === "2"){
                        gridItem.innerHTML += ` <div class="users">
                                                <img alt="profile" src="../../public/images/icons/person-circle.svg">
                                                <span class="name">${row.name} ${row.lastname}</span><img src="../../public/images/icons/x-lg.svg" class="removeUser" data-id="${row.id_user}" alt="x">
                                                </div>`;
                    }
                    else{
                        gridItem.innerHTML += ` <div class="users">
                                                <img alt="profile" src="../../public/images/icons/person-circle.svg">
                                                <span class="name">${row.name} ${row.lastname}</span>
                                                </div>`;
                    }
                });
                removeUser();
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            return false;
        });
}