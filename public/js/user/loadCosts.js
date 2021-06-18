function loadCosts(value= "0"){
    const gridCosts = document.querySelectorAll(".grid-costs")[0];
   let formData= new FormData();
   formData.append('costSelectValue',value);
    fetch('loadCosts.php', {
        method: 'POST',
        body:formData
    })
        .then(response => response.json())
        .then(data => {
            gridCosts.innerHTML = '';
            data.forEach(row =>{
                let item = document.createElement("div");
                item.classList.add("grid-item-cost");
                item.innerHTML = `<div class="card card-household cost">
                                    <div class="card-body">
                                        <img src="../../public/images/icons/x-lg.svg" width="16px" onclick="deleteCost(${row.id_cost})" class="iconClose">
                                        <div class="card-title">${row.cost_name}</div>
                                        <div style="height: 20px"><hr></div>
                                        <div class="costRow"><b>CENA: </b>${row.cost_price} RSD</div>
                                        <div class="costRow"><b>KATEGORIJA: </b>${row.cost_category_name}</div>
                                        <div class="costRow"><b>OPIS: </b>${row.cost_description}</div>
                                        <div class="costRow"><b>DATUM KREIRANJA: </b>${row.cost_creating_date}</div>
                                        <div class="costRow"><b>KREIRAO: </b>${row.name} ${row.lastname}</div>
                                    </div>`;
                gridCosts.appendChild(item);
            });
            sumCost();
        })
        .catch((error) => {
            console.error('Error:', error);
            return false;
        });
}

let costSelect = document.getElementById('filterCat');
costSelect.addEventListener('change',(e)=> loadCosts(e.target.value));

function deleteCost(id_cost){
    let formData = new FormData();
    console.log(id_cost);
    formData.append("id_cost", id_cost);
    fetch('deleteCost.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            loadCosts();
        })
        .catch((error) => {
            console.error('Error:', error);
            return false;
        });
}