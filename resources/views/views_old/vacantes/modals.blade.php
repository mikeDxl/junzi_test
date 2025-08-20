<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12 text-right">
              <iframe src="/storage/app/public/{{ buscarperfildePuesto($vacante->puesto_id) }}" width="100%" height="650"></iframe>
            </div>
          </div>
        </div>
      </div>
  </div>
</div>

<div class="modal fade" id="exampleAltaCandidato" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">

      <div class="modal-content">

        <div class="modal-body">
          <div class="row">
            <div class="col-md-12 text-center">
              <h3>Alta de candidato</h3>
              <form onkeydown="return event.key != 'Enter';" class="" action="{{ route('alta_candidato_rh') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="vacante_id" value="{{ $vacante_id }}">
                <div class="form-group">
                  <label for="">Nombre</label>
                  <input type="text" class="form-control" name="nombre" placeholder="Nombre" value=""> <br>
                </div>
                <div class="form-group">
                  <label for="">Apellido Paterno</label>
                  <input type="text" class="form-control" name="apellido_paterno" placeholder="Apellido Paterno" value=""> <br>
                </div>
                <div class="form-group">
                  <label for="">Apellido Materno</label>
                  <input type="text" class="form-control" name="apellido_materno" placeholder="Apellido Materno" value=""> <br>
                </div>
                <div class="input-group">
                  <label for="">Curriculum</label>
                  <br>
                  <input type="file" class="" name="curriculum" value="">
                </div>
                <div class="form-group">
                  <label for="">Comentarios</label>
                  <textarea name="comentarios" class="form-control" style="resize:none;"></textarea>
                  <br>
                </div>
                <div class="form-group">
                  <label for="">Fuente de prospección</label>
                  <select class="form-control" name="fuente">
                    <option value="">Selecciona una opción</option>
                    <option value="Redes sociales">Redes sociales</option>
                    <option value="Plataformas Web">Plataformas Web</option>
                    <option value="Referencias">Referencias</option>
                    <option value="Periódico">Periódico</option>
                    <option value="Directo en planta">Directo en planta</option>
                  </select>
                  <br>
                </div>
                <div class="text-center">
                  <br>
                  <button type="submit" class="btn btn-info"> Subir candidato </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script type="text/javascript">
  function mostrarDivFile(btnId , divId){
    document.getElementById(btnId).style.display='none';
    document.getElementById(divId).style.display='block';
  }
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const questions = document.querySelectorAll('.stars');

  questions.forEach(question => {
    for (let i = 1; i <= 5; i++) {
      const star = document.createElement('span');
      star.classList.add('star');
      star.textContent = '★';
      star.dataset.value = i;
      star.addEventListener('click', rateQuestion);
      question.appendChild(star);
    }
  });
});

function rateQuestion(event) {
  const clickedStar = event.target;
  const questionStars = clickedStar.parentElement.querySelectorAll('.star');
  const questionId = clickedStar.parentElement.id;
  const ratingInput = document.getElementById(questionId.replace('Stars', 'Rating')); // Corregido

  const value = parseInt(clickedStar.dataset.value);

  questionStars.forEach(star => {
    const starValue = parseInt(star.dataset.value);
    if (starValue <= value) {
      star.classList.add('active');
    } else {
      star.classList.remove('active');
    }
  });

  ratingInput.value = value;
}

</script>





<script>
    function radioOption(clickedId) {
        // Obtén el checkbox asociado al elemento que se hizo clic
        var checkbox = document.getElementById(clickedId.replace('label_', 'radio_'));

        // Verifica y actualiza el estado del checkbox
        checkbox.checked = !checkbox.checked;

        // Actualiza la clase 'active' en el elemento que se hizo clic
        var clickedOption = document.getElementById(clickedId);
        clickedOption.classList.toggle('active', checkbox.checked);
    }
</script>
