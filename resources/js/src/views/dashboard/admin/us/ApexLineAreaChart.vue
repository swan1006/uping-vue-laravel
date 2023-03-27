<template>
  <b-card no-body>
<!--    <b-card-header>-->
<!--      &lt;!&ndash; title and subtitle &ndash;&gt;-->
<!--      <div>-->
<!--        <b-card-title class="mb-1">-->
<!--          Revenue Report-->
<!--        </b-card-title>-->
<!--        <b-card-sub-title>CLeads submissions</b-card-sub-title>-->
<!--      </div>-->
<!--      &lt;!&ndash;/ title and subtitle &ndash;&gt;-->

<!--      &lt;!&ndash; datepicker &ndash;&gt;-->
<!--      <div class="d-flex align-items-center">-->
<!--        <feather-icon-->
<!--          icon="CalendarIcon"-->
<!--          size="16"-->
<!--        />-->
<!--        <flat-pickr-->
<!--          v-model="rangePicker"-->
<!--          :config="{ mode: 'range'}"-->
<!--          class="form-control flat-picker bg-transparent border-0 shadow-none"-->
<!--          placeholder="YYYY-MM-DD"-->
<!--        />-->
<!--      </div>-->
<!--      &lt;!&ndash; datepicker &ndash;&gt;-->
<!--    </b-card-header>-->

    <b-card-body>
      <vue-apex-charts
        type="area"
        height="400"
        :options="apexChatData.lineAreaChartSpline.chartOptions"
        :series="apexChatData.lineAreaChartSpline.series"

      />
<!--        :series="lineAreaChartSpline.series"-->
    </b-card-body>
  </b-card>
</template>

<script>
import {
  BCard, BCardHeader, BCardBody, BCardTitle, BCardSubTitle,
} from 'bootstrap-vue'
import VueApexCharts from 'vue-apexcharts'
import flatPickr from 'vue-flatpickr-component'
import apexChatData from './apexChartData'
import axios from 'axios'
// import rangePicker

export default {
  components: {
    BCard,
    VueApexCharts,
    BCardHeader,
    BCardBody,
    BCardTitle,
    BCardSubTitle,
    flatPickr,
  },
  data() {
    return {
      apexChatData,
      rangePicker: ['2019-05-01', '2019-05-10'],
         chartData: {},
          // dates: this.chartData.dates,
          // accepted: this.chartData.accepted,
          // pending: this.chartData.pending,
          // rejected: this.chartData.rejected,
        // lineAreaChartSpline: {
        //     series: [
        //         {
        //             name: 'Visits',
        //             data: this.chartData.accepted,
        //         },
        //         {
        //             name: 'Clicks',
        //             data: this.chartData.accepted,
        //         },
        //         {
        //             name: 'Sales',
        //             data: this.chartData.accepted,
        //         },
        //     ],
        // },
    }
  },
    created () {
        this.fetchChartData();
    },
    methods: {
        fetchChartData () {
            axios.get('/api/admin/revenueChartData')
                .then(response => {
                    this.chartData = response.data
                })
                .catch(error => console.log(error))
        },
    }

}
</script>
