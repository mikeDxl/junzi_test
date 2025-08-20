<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="organization-chart-master/css/organization-chart.min.css" rel="stylesheet"/>
    <title>Organigrama</title>
  </head>
  <body>
    <h1>Hello, world!</h1>
    <div id="advancedChartExample"></div>

    <script src="organization-chart-master/js/organization-chart.min.js"></script>
    <script>
        const advancedChart = document.getElementById('advancedChartExample');
        new OrganizationChart(advancedChart, {
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
     </script>
  </body>
</html>
