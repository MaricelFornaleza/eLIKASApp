

const barChart = new Chart(document.getElementById('canvas-2'), {
    type: 'bar',
    data: {
        labels: dates,
        datasets: [
            {
                label: "Evacuees",
                backgroundColor: coreui.Utils.getStyle('--secondary'),
                borderColor: coreui.Utils.getStyle('--secondary'),
                hoverBackgroundColor: coreui.Utils.getStyle('--secondary-accent'),
                data: chartData
            },
            {
                label: "Non-evacuees",
                backgroundColor: coreui.Utils.getStyle('--primary'),
                borderColor: coreui.Utils.getStyle('--primary'),
                hoverBackgroundColor: coreui.Utils.getStyle('--primary-accent'),
                data: chartData2
            },

        ]
    },
    options: {
        responsive: true,
        legend: {
            display: false
        },
        scales: {

            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    maxTicksLimit: 10,
                }
            }]

        },


    }
})