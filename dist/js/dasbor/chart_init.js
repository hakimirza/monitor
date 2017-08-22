// PIE CHART
// STATUS KUESIONER
var ctx = document.getElementById('pie_statusKues').getContext('2d');
var donat = new Chart(ctx, {
  type: 'doughnut',
  data: {
    datasets: [{
      // data: [3350, 70, 30],
      data: dataIzin,
      backgroundColor : ['#00a65a','#f39c12','#f56954'],
      hoverBorderColor : ['green','yellow','red']
    }],
    labels: ['Bersedia','Tidak dapat ditemui','Menolak']
  },
  options: {
    pieceLabel: {
      mode: 'percentage',
      fontSize: 14,
      precision: 2
    },
    legend: {
      position: 'bottom',
      labels: {
        boxWidth: 10
      }
    },
    hover: {
            // Overrides the global setting
            mode: 'index'
          }
        }
      });
// /PIE CHART

// LINE CHART
// PROGRES HARIAN
var ctx2 = document.getElementById('line_inputHarian').getContext('2d');
$('#line_inputHarian').attr('height', 100);
var line1 = new Chart(ctx2, {
  type: 'line',
  data: {
    datasets: [{
        // data: [30, 40, 56, 88, 76, 67, 70],
        data: lineInput.count,
        fill: false,
        borderColor: '#00a65a'
      }],
      // labels: ['3-Jun', '4-Jun', '5-Jun', '6-Jun', '7-Jun', '8-Jun', '9-Jun']
      labels: lineInput.date
    },
    options: {
      legend: {
        display: false
      },
      elements: {
        line: {
                tension: 0, // disables bezier curves
              }
            },
            scales: {
              yAxes: [{
                stacked: true,
                ticks: {
                  min: 0,
                  stepSize: 1
                }
              }]
            }
          }
        });

// DURASI CACAH

var ctx3 = document.getElementById('line_durasiCacah').getContext('2d');
$('#line_durasiCacah').attr('height', 100);
var line2 = new Chart(ctx3, {
  type: 'line',
  data: {
    datasets: [{
        // data: [25, 20, 17, 22, 29, 25, 27],
        data: lineDur.dur,
        fill: false,
        borderColor: '#f39c12'
      }],
      // labels: ['3-Jun', '4-Jun', '5-Jun', '6-Jun', '7-Jun', '8-Jun', '9-Jun']
      labels: lineDur.date
    },
    options: {
      legend: {
        display: false
      },
      elements: {
        line: {
                tension: 0, // disables bezier curves
              }
            },
            scales: {
              yAxes: [{
                stacked: true,
                ticks: {
                  min: 0
                }
              }]
            }
          }
        });

// /LINE CHART