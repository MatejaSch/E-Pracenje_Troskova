window.addEventListener('DOMContentLoaded', (event) => {
    fetchCostsByCategory();
});

const byCategory = document.querySelector("#topThree").getContext('2d');
let categories = [];
let sumsByCategory = [];
let colors = [];

var dynamicColors = function() {
    var r = Math.floor(Math.random() * 255);
    var g = Math.floor(Math.random() * 255);
    var b = Math.floor(Math.random() * 255);
    return "rgb(" + r + "," + g + "," + b + ")";
};

const costByCategory = new Chart(byCategory, {
    type: 'pie',
    data: {
        labels: categories,
        datasets: [{
            data: sumsByCategory,
            backgroundColor: colors
        }],
    },
    options:{
        plugins: {
            title: {
                display: true,
                text: 'Top tri kategorije',
                font: {
                    size: "30",
                    color: "#000"
                }
            }
        }
    }
});

function fetchCostsByCategory(){
    fetch('costByCategory.php', {
        method: 'POST',
    })
        .then(response => response.json())
        .then(data => {
            data.forEach(row => {
                colors.push(dynamicColors());
                categories.push(row.cost_category_name);
                sumsByCategory.push(row.suma);
            });
            costByCategory.update();
            categories = [];
            sumsByCategory = [];
            colors = [];
        })
        .catch((error) => {
            console.error('Error:', error);
            return false;
        });
}



