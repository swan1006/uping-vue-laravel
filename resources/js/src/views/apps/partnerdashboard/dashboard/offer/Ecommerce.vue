<template>
  <section id="dashboard-ecommerce">

      <b-row>
          <b-col
              lg="3"
              sm="6"
          >
              <statistic-card-horizontal
                  icon="NavigationIcon"
                  :statistic="data.dashboard_data.todayMetrics.original.today_metrics.clicks"
                  statistic-title="Clicks"


              />
          </b-col>
          <b-col
              lg="3"
              sm="6"
          >
              <statistic-card-horizontal
                  icon="ActivityIcon"
                  color="secondary"
                  :statistic="data.dashboard_data.todayMetrics.original.today_metrics.conversions"
                  statistic-title="Conversions"  />
          </b-col>
          <b-col
              lg="3"
              sm="6"
          >
              <statistic-card-horizontal
                  icon="DollarSignIcon"
                  color="info"
                  :statistic="data.dashboard_data.todayMetrics.original.today_metrics.revenue"
                  statistic-title="Revenue"
                  />
          </b-col>
          <b-col
              lg="3"
              sm="6"
          >
              <statistic-card-horizontal
                  icon="TrendingUpIcon"
                  color="success"
                  :statistic="data.dashboard_data.todayMetrics.original.today_metrics.profit"
                  statistic-title="Profit"
                   />
          </b-col>
      </b-row>


      <!-- Revenue Report Card -->
      <b-col lg="12">
          <apex-line-area-chart />
      </b-col>

      <!-- Affiliate Overview-->
    <b-row class="match-height">
      <b-col lg="6">
        <click-company-table :table-data="data" />
      </b-col>
        <!-- Conversion Overview-->
        <b-col lg="6">
        <conversion-company-table :table-data="data" />
        </b-col>


    </b-row>
  </section>
</template>

<script>
import { BRow, BCol } from 'bootstrap-vue'

import { getUserData } from '@/auth/utils'
import EcommerceMedal from './EcommerceMedal.vue'
import EcommerceStatistics from './EcommerceStatistics.vue'
import EcommerceRevenueReport from './EcommerceRevenueReport.vue'
import EcommerceOrderChart from './EcommerceOrderChart.vue'
import EcommerceProfitChart from './EcommerceProfitChart.vue'
import EcommerceEarningsChart from './EcommerceEarningsChart.vue'
import ClickCompanyTable from './ClickCompanyTable.vue'
import ConversionCompanyTable from './ConversionCompanyTable.vue'
import EcommerceMeetup from './EcommerceMeetup.vue'
import RedirectionTotalOverview from './RedirectionTotalOverview.vue'
import EcommerceTransactions from './EcommerceTransactions.vue'
import ApexLineAreaChart from "@/views/charts-and-maps/charts/apex-chart/ApexLineAreaChart";
import StatisticCardHorizontal from '@core/components/statistics-cards/StatisticCardHorizontal.vue'


export default {
  components: {
      ApexLineAreaChart,
    BRow,
    BCol,

    EcommerceMedal,
    EcommerceStatistics,
    EcommerceRevenueReport,
    EcommerceOrderChart,
    EcommerceProfitChart,
    EcommerceEarningsChart,
    EcommerceMeetup,
    RedirectionTotalOverview,
    EcommerceTransactions,
    StatisticCardHorizontal,

    ClickCompanyTable,
    ConversionCompanyTable,

  },
  data() {
    return {
      data: {},
    }
  },
  created() {
    // data
    this.$http.get('/partner/getDashboardOfferDataPartner/1').then(response => {
      this.data = response.data

      // ? Your API will return name of logged in user or you might just directly get name of logged in user
      // ? This is just for demo purpose
      // const userData = getUserData()
      // this.data.congratulations.name = userData.fullName.split(' ')[0] || userData.username
    })
  },
}
</script>

<style lang="scss">
@import '~@core/scss/vue/pages/dashboard-ecommerce.scss';
@import '~@core/scss/vue/libs/chart-apex.scss';
</style>
