doughnutChart = new Chart(document.getElementById('canvas-3'), {
    type: 'doughnut',
    data: {
        labels: ['Children', 'Lactating', 'Persons with Disability', 'Pregnant', 'Senior Citizen',
            'Solo Parent'
        ],
        datasets: [{
            data: [100, 50, 80, 70, 45, 10],
            backgroundColor: ['#D7E37D', '#FFB703', '#FB8500', '#219EBC', '#5464AF', '#023047'],
            hoverBackgroundColor: ['#D7E37D', '#FFB703', '#FB8500', '#219EBC', '#5464AF', '#023047']
        }, ]
    },
    radius: 200,
    options: {
        responsive: true,
        legend: {
            display: true,
            position: "bottom",
            align: "start",
            fullwidth: true,
            maxWidth: 200,
            labels: {
                padding: 20,
            },
            title: {
                text: "Categories",
                display: true,
            }
        },
    },
    
})
// Chart.pluginService.register({
//     beforeDraw: function(chart) {
//       var width = chart.chart.width,
//           height = chart.chart.height,
//           ctx = chart.chart.ctx;
//       ctx.restore();
//       var fontSize = (height / 150).toFixed(2);
//       ctx.font = fontSize + "em sans-serif";
//       ctx.textBaseline = "middle";
//       var text = "2689",
//           textX = Math.round((width - ctx.measureText(text).width) / 2),
//           textY = height / 3.8;
//       ctx.fillText(text, textX, textY);
//       ctx.save();
//     }
//   });