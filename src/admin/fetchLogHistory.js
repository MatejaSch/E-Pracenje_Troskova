const LogHistoryBlock = document.getElementById('logHistoryBlock');

window.addEventListener('load', function () {

    fetch('showLogHistory.php', {
        method: 'POST',
    })
        .then(response => response.json())
        .then(data => {
            if (data.error === 1) {
                console.log("error");
            } else {
                let table = document.querySelector('#LogHistoryTable tbody');
                data.forEach(row => {
                    table.innerHTML += `
                        <tr>
                            <td >${row.id_user}</td>
                            <td >${row.user_ip_address}</td>
                            <td >${row.web_browser}</td>
                            <td >${row.log_date}</td>
                        </tr> 
                    `;



                });

            }
        })
        .catch((error) => {
            console.log('error:', error);
            return false;
        });
})