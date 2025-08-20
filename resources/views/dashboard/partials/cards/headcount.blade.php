<div id="headcount-card" class="card card-stats">
    <div class="card-body">
        <div class="row">
            <div class="col-5">
                <div class="info-icon text-center icon-success">
                    <i class="tim-icons icon-molecule-40"></i>
                </div>
            </div>
            <div class="col-7">
                <div class="numbers">
                    <p class="card-category">Headcount</p>
                    <h3 class="card-title" id="porcentajeActivos">0%</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <hr>
        <div class="stats">
            <i class="tim-icons icon-molecule-40"></i>
            <span id="mesAnterior">
                <small>
                    <?php \Carbon\Carbon::setLocale('es'); ?>
                    {{ \Carbon\Carbon::now()->subMonth()->formatLocalized('%B %Y') }}
                </small>
                <b id="porcentajeActivosMesAnterior">0</b>
                <span id="diferencia"></span>
            </span>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $.ajax({
            url: "{{ route('dashboard.cards.headcountData') }}",
            method: 'GET',
            success: function(data) {
                $('#porcentajeActivos').text(Math.round(data.porcentajeActivos) + '%');
                $('#porcentajeActivosMesAnterior').text(Math.round(data.porcentajeActivosMesAnterior));

                const diferencia = data.porcentajeActivosMesAnterior - data.porcentajeActivos;
                if (diferencia > 0) {
                    $('#diferencia').html(`( <i class="fa fa-plus"></i> ${Math.round(diferencia)}% )`);
                } else if (diferencia < 0) {
                    $('#diferencia').html(`( <i class="fa fa-minus"></i> ${Math.abs(Math.round(diferencia))}% )`);
                } else {
                    $('#diferencia').html(`( <i class="fa fa-equals"></i> 0% )`);
                }
            },
            error: function(xhr) {
                console.error('Error al obtener datos de headcount:', xhr);
            }
        });
    });
</script>
