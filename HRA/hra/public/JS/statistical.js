var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(
    ctx, 
    {type: 
        'bar',
        data: {
            labels: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
            datasets: [{
                label: 'Consommation des lampes',
                data: [12, 19, 3, 5, 2, 3, 8, 12, 4, 5, 5, 8],
                backgroundColor: [
                    'rgba(7, 37, 114, 0.8)',
                    'rgba(0, 0, 255, 0.8)',
                    'rgba(0, 103, 255, 0.8)',
                    'rgba(7, 37, 114, 0.8)',
                    'rgba(0, 0, 255, 0.8)',
                    'rgba(0, 103, 255, 0.8)',
                    'rgba(7, 37, 114, 0.8)',
                    'rgba(0, 0, 255, 0.8)',
                    'rgba(0, 103, 255, 0.8)',
                    'rgba(7, 37, 114, 0.8)',
                    'rgba(0, 0, 255, 0.8)',
                    'rgba(0, 103, 255, 0.8)'
                ],
                borderColor: [
                    'rgba(7, 37, 114, 1)',
                    'rgba(7, 37, 114, 1)',
                    'rgba(7, 37, 114, 1)',
                    'rgba(7, 37, 114, 1)',
                    'rgba(7, 37, 114, 1)',
                    'rgba(7, 37, 114, 1)',
                    'rgba(7, 37, 114, 1)',
                    'rgba(7, 37, 114, 1)',
                    'rgba(7, 37, 114, 1)',
                    'rgba(7, 37, 114, 1)',
                    'rgba(7, 37, 114, 1)',
                    'rgba(7, 37, 114, 1)'
                ],
                borderWidth: 5
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    }
);