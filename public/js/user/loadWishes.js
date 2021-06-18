function loadWishes(){
    const gridWishes = document.querySelectorAll(".grid-wishes")[0];
    fetch('loadWishes.php', {
        method: 'POST'
    })
        .then(response => response.json())
        .then(data => {
            gridWishes.innerHTML = '';
            data.forEach(row =>{
                let item = document.createElement("div");
                item.classList.add("grid-item-wish");
                item.innerHTML = `<div class="card card-household wish">
                                    <div class="card-body">
                                        <img src="../../public/images/icons/x-lg.svg" width="16px" onclick="deleteWish(${row.id_wish})" class="iconClose">
                                        <div class="card-title">${row.wish_name}</div>
                                        <div style="height: 20px"><hr></div>
                                        <div class="wishRow"><b>CENA: </b>${row.wish_price} RSD</div>
                                        <div class="wishRow"><b>ŽELJENI DATUM OSTVARENJA: </b>${row.wish_expectation}</div>
                                        <div class="wishRow"><b>DATUM KREIRANJA: </b>${row.wish_creating_date}</div>
                                        <div class="wishRow"><b>KREIRAO: </b>${row.name} ${row.lastname}</div>
                                    </div>`;
                gridWishes.appendChild(item);
            });
        })
        .catch((error) => {
            console.error('Error:', error);
            return false;
        });
}

function deleteWish(id_wish){
    let formData = new FormData();
    formData.append("id_wish", id_wish);
    fetch('deleteWish.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            loadWishes();
        })
        .catch((error) => {
            console.error('Error:', error);
            return false;
        });
}