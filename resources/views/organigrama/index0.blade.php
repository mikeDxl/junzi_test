<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Organigrama básico con MDB5</title>

  <!-- CSS de MDB5 -->
  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.css"
    rel="stylesheet"
  />
</head>
<body>

<div id="advancedChartExample" style="width: 100%; height: 500px;"></div>

<!-- JS de MDB5 -->
<script
  type="text/javascript"
  src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.js"
></script>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const advancedChart = document.getElementById('advancedChartExample');
    console.log(advancedChart);  // Verificación del contenedor

    if (advancedChart) {
      new mdb.OrganizationChart(advancedChart, {
        data: {
          name: 'Walter White',
          label: 'CIO',
          avatar: 'https://mdbcdn.b-cdn.net/img/new/avatars/1.webp',
          children: [
            {
              label: 'Manager',
              name: 'Jon Snow',
              avatar: 'https://mdbcdn.b-cdn.net/img/new/avatars/2.webp',
              children: [
                {
                  label: 'SE',
                  name: 'Britney Morgan',
                  avatar: 'https://mdbcdn.b-cdn.net/img/new/avatars/9.webp',
                },
              ],
            },
            {
              label: 'Director',
              name: 'Jimmy McGill',
              avatar: 'https://mdbcdn.b-cdn.net/img/new/avatars/3.webp',
              children: [
                {
                  label: 'PM',
                  name: 'Phoebe Buffay',
                  avatar: 'https://mdbcdn.b-cdn.net/img/new/avatars/7.webp',
                  children: [
                    {
                      label: 'Operations',
                      avatar: 'https://mdbcdn.b-cdn.net/img/new/avatars/4.webp',
                      name: 'Kim Wexler',
                    },
                    {
                      label: 'Development',
                      name: 'Rachel Green',
                      avatar: 'https://mdbcdn.b-cdn.net/img/new/avatars/6.webp',
                    },
                  ],
                },
              ],
            },
            {
              label: 'Manager',
              name: 'Michael Scott',
              avatar: 'https://mdbcdn.b-cdn.net/img/new/avatars/8.webp',
              children: [
                {
                  label: 'SA',
                  name: 'Pam Beasly',
                  avatar: 'https://mdbcdn.b-cdn.net/img/new/avatars/5.webp',
                },
                {
                  label: 'SP',
                  name: 'Alex Morgan',
                  avatar: 'https://mdbcdn.b-cdn.net/img/new/avatars/14.webp',
                },
              ],
            },
            {
              label: 'R&D',
              name: 'Fran Kirby',
              avatar: 'https://mdbcdn.b-cdn.net/img/new/avatars/10.webp',
            },
          ],
        },
      });
      console.log("Chart loaded");
    }
  });
</script>

</body>
</html>
