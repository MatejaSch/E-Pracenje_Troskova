window.addEventListener("DOMContentLoaded", showHouseholds);

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
                    getHouseholds(); //poziva funckiju koja daje event listenere ovim karticama
                });
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            return false;
        });
}