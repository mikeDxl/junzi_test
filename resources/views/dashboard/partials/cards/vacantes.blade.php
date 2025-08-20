<div class="card card-stats" id="vacantesCard">
    <div class="card-body">
        <div class="row">
            <div class="col-5">
                <div class="info-icon text-center icon-success">
                    <i class="tim-icons icon-single-02"></i>
                </div>
            </div>
            <div class="col-7">
                <div class="numbers">
                    <p class="card-category">Vacantes</p>
                    <h3 class="card-title" id="vacantesCount"></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <hr>
        <div class="stats">
            <i class="tim-icons icon-single-02"></i> <span id="vacantesPercentage"></span>% Cubierto
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        fetchVacantesData();
    });

    function fetchVacantesData() {
        fetch("{{ route('dashboard.cards.vacantesData') }}")
            .then(response => response.json())
            .then(data => {
                document.getElementById('vacantesCount').innerText = `${data.vacantesall - data.vacantespendientesall} / ${data.vacantesall}`;
                document.getElementById('vacantesPercentage').innerText = data.porcentajeCompletadas.toFixed(2);
            })
            .catch(error => console.error('Error:', error));
    }

</script>
