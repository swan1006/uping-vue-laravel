<template>
  <b-card
    v-if="data"
    class="earnings-card"
  >
    <b-row>
<!--      <b-col cols="4">-->
<!--        <b-card-title class="mb-1">-->
<!--            £ {{ data.todayEarnings.today_revenue }}-->
<!--        </b-card-title>-->
<!--        <div class="font-small-2">-->
<!--            {{ title }}-->
<!--        </div>-->
<!--        <h5 class="mb-1">-->
<!--            {{ data.lead_count.today }} Leads-->
<!--        </h5>-->
<!--      </b-col>-->
      <b-col cols="12">
        <!-- chart -->
        <vue-apex-charts
          height="120"
          :options="earningsChart.chartOptions"
          :series="data.todayEarnings.series"
        />
      </b-col>
    </b-row>
          <b-row class="text-center mx-0">
              <b-col
                  cols="6"
                  class="border-top border-right d-flex align-items-between flex-column py-1"
              >
                  <b-card-text class="text-muted mb-0">
                     Leads
                  </b-card-text>
                  <h5 class="font-weight-bolder mb-0">
                        {{ data.lead_count.today }}
                  </h5>
              </b-col>

              <b-col
                  cols="6"
                  class="border-top d-flex align-items-between flex-column py-1"
              >
                  <b-card-text class="text-muted mb-0">
                       Commission
                  </b-card-text>
                  <h5 class="font-weight-bolder mb-0">
                      £ {{ data.todayEarnings.today_revenue }}
                  </h5>
              </b-col>
          </b-row>



  </b-card>
</template>

<script>
import {
  BCard, BRow, BCol, BCardTitle, BCardText,
} from 'bootstrap-vue'
import VueApexCharts from 'vue-apexcharts'
import { $themeColors } from '@themeConfig'

const $earningsStrokeColor2 = '#28c76f66'
const $earningsStrokeColor3 = '#28c76f33'
export default {
  components: {
    BCard,
    BRow,
    BCol,
    BCardTitle,
    BCardText,
    VueApexCharts,
  },
  props: {
    data: {
      type: Object,
      default: () => {},
    },
      title: String,
  },
  data() {
    return {
      earningsChart: {
          // series: [12, 100, 100],
        chartOptions: {
          chart: {
            type: 'donut',
            toolbar: {
              show: false,
            },
          },
          dataLabels: {
            enabled: false,
          },
          legend: { show: false },
          comparedResult: [2, -3, 8],
          labels: ['Profit', 'Cost', 'Total'],
          stroke: { width: 0 },
          colors: [$earningsStrokeColor2, $earningsStrokeColor3, $themeColors.success],
          grid: {
            padding: {
              right: -20,
              bottom: -8,
              left: -20,
            },
          },
          plotOptions: {
            pie: {
              startAngle: -10,
              donut: {
                labels: {
                  show: true,
                  name: {
                    offsetY: 15,
                  },
                  value: {
                    offsetY: -15,
                    formatter(val) {
                      // eslint-disable-next-line radix
                      return `${parseInt(val)}%`
                    },
                  },
                  total: {
                    show: true,
                    offsetY: 15,
                    label: 'Redirect',
                    formatter() {
                      return '53%'
                    },
                  },
                },
              },
            },
          },
          responsive: [
            {
              breakpoint: 1325,
              options: {
                chart: {
                  height: 125,
                },
              },
            },
            {
              breakpoint: 1200,
              options: {
                chart: {
                  height: 125,
                },
              },
            },
            {
              breakpoint: 1045,
              options: {
                chart: {
                  height: 100,
                },
              },
            },
            {
              breakpoint: 992,
              options: {
                chart: {
                  height: 75,
                },
              },
            },
          ],
        },
      },
    }
  },
}
</script>
