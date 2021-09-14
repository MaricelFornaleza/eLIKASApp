// eslint-disable-next-line no-unused-vars

const mainChart = new Chart(document.getElementById('main-chart'), {
  type: 'line',
  data: {
    labels: dates,
    datasets: [
      {
        label: 'Evacuees',
        backgroundColor: coreui.Utils.hexToRgba(coreui.Utils.getStyle('--info'), 10),
        borderColor: coreui.Utils.getStyle('--info'),
        pointHoverBackgroundColor: '#fff',
        borderWidth: 2,
        data: chartData,
      },
      {
        label: 'Non-evacuees',
        backgroundColor: 'transparent',
        borderColor: coreui.Utils.getStyle('--success'),
        pointHoverBackgroundColor: '#fff',
        borderWidth: 2,
        data: chartData2,
      },

    ]
  },
  options: {
    maintainAspectRatio: false,
    legend: {
      display: false
    },
    scales: {
      xAxes: [{
        gridLines: {
          drawOnChartArea: false
        }
      }],
      yAxes: [{
        ticks: {
          beginAtZero: true,
          maxTicksLimit: 5,
          stepSize: 2,

        }
      }]
    },
    elements: {
      point: {
        radius: 0,
        hitRadius: 10,
        hoverRadius: 4,
        hoverBorderWidth: 3
      }
    },
    tooltips: {
      intersect: true,
      callbacks: {
        labelColor: function (tooltipItem, chart) {
          return { backgroundColor: chart.data.datasets[tooltipItem.datasetIndex].borderColor };
        }
      }
    }
  }
})
