document.addEventListener('DOMContentLoaded', function() {
    const fetchButton = document.querySelector('.btn-main');
    const dataContainer = document.querySelector('.api-data');

    fetchButton.addEventListener('click', function(event) {
        event.preventDefault();
        fetchData();
    });

    async function fetchData() {
        try {
            const response = await fetch('https://votre-api-vantage-url/api/data'); // Remplacez par l'URL de votre API
            const data = await response.json();
            displayData(data);
        } catch (error) {
            console.error('Error:', error);
            dataContainer.innerHTML = '<p>Une erreur est survenue lors de la récupération des données.</p>';
        }
    }

    function displayData(data) {
        if (data && data.length > 0) {
            const list = document.createElement('ul');
            data.forEach(item => {
                const listItem = document.createElement('li');
                listItem.textContent = `${item.key}: ${item.value}`;
                list.appendChild(listItem);
            });
            dataContainer.innerHTML = '';
            dataContainer.appendChild(list);
        } else {
            dataContainer.innerHTML = '<p>Aucune donnée disponible.</p>';
        }
    }
});
