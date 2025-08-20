<div class="card card-stats" id="desvinculadosCard">
    <div class="card-body">
        <div class="row">
            <div class="col-5">
                <div class="info-icon text-center icon-danger">
                    <i class="tim-icons icon-single-02"></i>
                </div>
            </div>
            <div class="col-7">
                <div class="numbers">
                    <p class="card-category">Desvinculaciones</p>
                    <h3 class="card-title" id="totalDesvinculados">0</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <hr>
        <div class="stats">
            <i class="tim-icons icon-single-02"></i> Programadas <b id="totalBajas">0</b>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $.ajax({
            url: "{{ route('dashboard.cards.desvinculados') }}",
            method: "GET",
            success: function(data) {
                $('#totalDesvinculados').text(data.totalDesvinculados);
                $('#totalBajas').text(data.totalBajas);
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    });
</script>
