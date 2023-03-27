<template>
  <section id="dashboard-ecommerce">

     <!--Stat Cards-->
    <b-row class="match-height">
      <b-col
        xl="3"
        md="3"
      >
          <ecommerce-earnings-chart :data="data.dashboard_data.todayMetrics" title="Today" />
      </b-col>
      <b-col
        xl="3"
        md="3"
      >
          <ecommerce-earnings-chart :data="data.dashboard_data.todayMetrics" title="Week" />
      </b-col>
        <b-col
            xl="3"
            md="3"
        >
            <ecommerce-earnings-chart :data="data.dashboard_data.todayMetrics" title="Month" />
        </b-col>
        <b-col
            xl="3"
            md="3"
        >
            <ecommerce-earnings-chart :data="data.dashboard_data.todayMetrics" title="Redirection" />
        </b-col>
    </b-row>

      <!-- Revenue Report Card -->
      <b-col lg="12">
          <apex-line-area-chart />
      </b-col>

      <!-- Affiliate Overview-->
    <b-row class="match-height">
      <b-col lg="12">
        <company-table :table-data="data.dashboard_data.affiliate_table_data" />
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
import CompanyTable from './CompanyTable.vue'
import LenderCompanyTable from './LenderCompanyTable.vue'
import EcommerceMeetup from './EcommerceMeetup.vue'
import AffiliateRedirectRates from './AffiliateRedirectRates.vue'
import LenderRedirectRates from './LenderRedirectRates.vue'
import RedirectionTotalOverview from './RedirectionTotalOverview.vue'
import EcommerceTransactions from './EcommerceTransactions.vue'
import ApexLineAreaChart from "@/views/charts-and-maps/charts/apex-chart/ApexLineAreaChart";

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
    CompanyTable,
    LenderCompanyTable,
    EcommerceMeetup,
    AffiliateRedirectRates,
    LenderRedirectRates,
      RedirectionTotalOverview,
    EcommerceTransactions,
  },
  data() {
    return {
      data: {},
        userData: {
          id: 1
        }
    }
  },
  created() {
    // data
    this.$http.get('/partner/getDashboardLeadDataPartner/1' ).then(response => {
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
