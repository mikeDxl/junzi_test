@include('layouts.header')

<body class="text-start">
      @include('layouts.menu')
    <div class="main-content">
      <div class="breadcrumb">
        <h1>Dashboard</h1>
      </div>
      <div class="separator-breadcrumb border-top"></div>


      <div class="row">
        <div class="col-md-12">
          <div>
  
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const ctx = document.getElementById('myChart');

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Q1', 'Q2', 'Q3', 'Q4', 'Q5', 'Q6'],
      datasets: [{
        label: 'Vacantes',
        data: [12, 19, 3, 5, 2, 3],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>

        </div>
      </div>

@include('layouts.footer')
