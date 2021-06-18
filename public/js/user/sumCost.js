window.addEventListener('DOMContentLoaded', (event) => {
    sumCost();
});

function sumCost(){
    const sum = document.querySelector("#sum");
    const thisMonth = document.querySelector("#thisMonth");
    sum.innerHTML = '';
    thisMonth.innerHTML = '';

    fetch('sumCost.php', {
        method: 'POST'
    })
        .then(response => response.json())
        .then(data => {
            sum.innerHTML = data.sum;
            thisMonth.innerHTML = data.thisMonth;
        })
        .catch((error) => {
            console.error('Error:', error);
            return false;
        });
}