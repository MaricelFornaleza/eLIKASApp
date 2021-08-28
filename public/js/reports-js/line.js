

const random = () => Math.round(Math.random() * 100)

lineChart = new Chart(document.getElementById('canvas-1'), {
    type: 'line',
    data: {
      labels : ['August 1', 'August 2', 'August 3', 'August 4', 'August 5', 'August 6', 'August 7'],
      datasets : [
        {
          label: 'Clothes',
          backgroundColor: "transparent",
          borderColor : '#D7E37D',
          pointBackgroundColor : '#D7E37D',
          pointBorderColor : '#fff',
          data : [random(), random(), random(), random(), random(), random(), random()]
        },
        {
          label: 'ESA',
          backgroundColor: "transparent",
          borderColor : '#FFB703',
          pointBackgroundColor : '#FFB703',
          pointBorderColor : '#fff',
          data : [random(), random(), random(), random(), random(), random(), random()]
        },
        {
        label: 'Food Packs',
        backgroundColor: "transparent",
        borderColor : '#FB8500',
        pointBackgroundColor : '#FB8500',
        pointBorderColor : '#fff',
        data : [random(), random(), random(), random(), random(), random(), random()]
        },
        {
        label: 'Hygiene Kit',
        backgroundColor: "transparent",
        borderColor : '#219EBC',
        pointBackgroundColor : '#219EBC',
        pointBorderColor : '#fff',
        data : [random(), random(), random(), random(), random(), random(), random()]
        },
        {
        label: 'Medicine',
        backgroundColor: "transparent",
        borderColor : '#5464AF',
        pointBackgroundColor : '#5464AF',
        pointBorderColor : '#fff',
        data : [random(), random(), random(), random(), random(), random(), random()]
        },
        {
        label: 'Water',
        backgroundColor: "transparent",
        borderColor : '#023047',
        pointBackgroundColor : '#023047',
        pointBorderColor : '#fff',
        data : [random(), random(), random(), random(), random(), random(), random()]
        },
      ]
    },
    options: {
      responsive: true,
      legend:{
          display:true,
          position: "right",
      },
      elements: {
        line: {
            tension: 0,
            borderWidth:2,
        }
    }
    }
  })