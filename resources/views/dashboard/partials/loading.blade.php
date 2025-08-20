<div id="loadingMessage" style="display: none; text-align: center; padding: 20px;">
    <p>Loading...</p>
</div>
<div id="noDataMessage" style="display: block; text-align: center; padding: 20px;">
    <p>No data available</p>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const loadingMessage = document.getElementById('loadingMessage');
    const noDataMessage = document.getElementById('noDataMessage');

    // Muestra el mensaje de carga
    loadingMessage.style.display = 'block';

    // Simula una llamada de datos
    fetch('/your-data-endpoint')
        .then(response => response.json())
        .then(data => {
            // Oculta el mensaje de carga una vez que los datos se cargan
            loadingMessage.style.display = 'none';

            if (data.length === 0) {
                // Muestra el mensaje de "No data available" si no hay datos
                noDataMessage.style.display = 'block';
            } else {
                // Lógica para mostrar los datos si hay disponibles
                console.log(data);
            }
        })
        .catch(error => {
            loadingMessage.style.display = 'none';
            console.error('Error fetching data:', error);
        });
});

</script>