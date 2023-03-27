import { $themeColors } from '@themeConfig'

// heat chart data generator
function generateDataHeatMap(count, yrange) {
  let i = 0
  const series = []
  while (i < count) {
    const x = `w${(i + 1).toString()}`
    const y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min

    series.push({
      x,
      y,
    })
    // eslint-disable-next-line no-plusplus
    i++
  }
  return series
}

// colors
const chartColors = {
  column: {
    series1: '#826af9',
    series2: '#d2b0ff',
    bg: '#f8d3ff',
  },
  success: {
    shade_100: '#7eefc7',
    shade_200: '#06774f',
  },
  donut: {
    series1: '#ffe700',
    series2: '#00d4bd',
    series3: '#826bf8',
    series4: '#2b9bf4',
    series5: '#FFA1A1',
  },
  area: {
    // series3: '#c8befa',
    // series2: '#9582f3',
    // series1: '#aa99fa',
      series3: '#a4f8cd',
      series2: '#60f2ca',
      series1: '#2bdac7',
  },
}

export default {
  lineChartSimple: {
    series: [
      {
        data: [280, 200, 220, 180, 270, 250, 70, 90, 200, 150, 160, 100, 150, 100, 50],
      },
    ],
    chartOptions: {
      chart: {
        zoom: {
          enabled: false,
        },
        toolbar: {
          show: false,
        },
      },
      markers: {
        strokeWidth: 7,
        strokeOpacity: 1,
        strokeColors: [$themeColors.light],
        colors: [$themeColors.warning],
      },
      colors: [$themeColors.warning],
      dataLabels: {
        enabled: false,
      },
      stroke: {
        curve: 'straight',
      },
      grid: {
        xaxis: {
          lines: {
            show: true,
          },
        },
      },
      tooltip: {
        custom(data) {
          return `${'<div class="px-1 py-50"><span>'}${
            data.series[data.seriesIndex][data.dataPointIndex]
          }%</span></div>`
        },
      },
      xaxis: {
        categories: [
          '7/12',
          '8/12',
          '9/12',
          '10/12',
          '11/12',
          '12/12',
          '13/12',
          '14/12',
          '15/12',
          '16/12',
          '17/12',
          '18/12',
          '19/12',
          '20/12',
          '21/12',
        ],
      },
      yaxis: {
        // opposite: isRtl,
      },
    },
  },

  lineAreaChartSpline: {
    series: [
      {
        name: 'Visits',
        data: [100, 120, 90, 170, 130, 160, 140, 240, 220, 180, 270, 280, 375],
      },
      {
        name: 'Clicks',
        data: [60, 80, 70, 110, 80, 100, 90, 180, 160, 140, 200, 220, 275],
      },
      {
        name: 'Sales',
        data: [20, 40, 30, 70, 40, 60, 50, 140, 120, 100, 140, 180, 220],
      },
    ],
    chartOptions: {
      chart: {
        toolbar: {
          show: false,
        },
      },
      dataLabels: {
        enabled: false,
      },
      stroke: {
        show: false,
        curve: 'straight',
      },
      legend: {
        show: true,
        position: 'top',
        horizontalAlign: 'left',
        fontSize: '14px',
        fontFamily: 'Montserrat',
      },
      grid: {
        xaxis: {
          lines: {
            show: true,
          },
        },
      },
      xaxis: {
        categories: [
          '7/12',
          '8/12',
          '9/12',
          '10/12',
          '11/12',
          '12/12',
          '13/12',
          '14/12',
          '15/12',
          '16/12',
          '17/12',
          '18/12',
          '19/12',
          '20/12',
        ],
      },
      yaxis: {
        // opposite: isRtl
      },
      fill: {
        opacity: 1,
        type: 'solid',
      },
      tooltip: {
        shared: false,
      },
      colors: [chartColors.area.series3, chartColors.area.series2, chartColors.area.series1],
    },
  },

  columnChart: {
    series: [
      {
        name: 'Apple',
        data: [90, 120, 55, 100, 80, 125, 175, 70, 88, 180],
      },
      {
        name: 'Samsung',
        data: [85, 100, 30, 40, 95, 90, 30, 110, 62, 20],
      },
    ],
    chartOptions: {
      chart: {
        stacked: true,
        toolbar: {
          show: false,
        },
      },
      colors: [chartColors.column.series1, chartColors.column.series2],
      plotOptions: {
        bar: {
          columnWidth: '15%',
          colors: {
            backgroundBarColors: [
              chartColors.column.bg,
              chartColors.column.bg,
              chartColors.column.bg,
              chartColors.column.bg,
              chartColors.column.bg,
            ],
            backgroundBarRadius: 10,
          },
        },
      },
      dataLabels: {
        enabled: false,
      },
      legend: {
        show: true,
        position: 'top',
        fontSize: '14px',
        fontFamily: 'Montserrat',
        horizontalAlign: 'left',
      },
      stroke: {
        show: true,
        colors: ['transparent'],
      },
      grid: {
        xaxis: {
          lines: {
            show: true,
          },
        },
      },
      xaxis: {
        categories: ['7/12', '8/12', '9/12', '10/12', '11/12', '12/12', '13/12', '14/12', '15/12', '16/12'],
      },
      yaxis: {
        // opposite: isRtl,
      },
      fill: {
        opacity: 1,
      },
    },
  },





}
