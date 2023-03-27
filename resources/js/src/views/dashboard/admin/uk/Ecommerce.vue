<template>
  <section id="dashboard-ecommerce">

     <!--Stat Cards-->
    <b-row class="match-height">
      <b-col
        xl="3"
        md="3"
      >
          <earnings-today :data="data.dashboard_data" title="Today"/>
      </b-col>
      <b-col
        xl="3"
        md="3"
      >
          <earnings-week :data="data.dashboard_data" title="Week"/>
      </b-col>
        <b-col
            xl="3"
            md="3"
        >
            <earnings-month :data="data.dashboard_data" title="Month"/>
        </b-col>
        <b-col
            xl="3"
            md="3"
        >
            <earnings-profit :data="data.dashboard_data" title="Profit"/>
        </b-col>
    </b-row>

      <!-- Revenue Report Card -->
      <b-col lg="12">
          <apex-line-area-chart />
      </b-col>

      <!-- Affiliate Overview-->
    <b-row class="match-height">
      <b-col lg="6">
        <affiliate-company-table :table-data="data" title="Affiliate" />
      </b-col>
        <!-- Lender Overview-->
        <b-col lg="6">
        <lender-company-table :table-data="data" title="Lender" />
        </b-col>




      <!-- Lender Redirection Overview -->
      <b-col
        lg="4"
        md="4"
      >
        <affiliate-redirect-rates :redirect-data="data.dashboard_data"/>
      </b-col>

        <b-col
            lg="4"
            md="4"
        >
            <lender-redirect-rates :redirect-data="data.dashboard_data" />
        </b-col>
      <!-- Redirection ALL -->
      <b-col
        lg="4"
        md="4"
      >
          <ecommerce-browser-states />
      </b-col>



    </b-row>
  </section>
</template>

<script>
import { BRow, BCol } from 'bootstrap-vue'

// import { getUserData } from '@/auth/utils'
import EcommerceMedal from './EcommerceMedal.vue'
import EcommerceStatistics from './EcommerceStatistics.vue'
import EcommerceRevenueReport from './EcommerceRevenueReport.vue'
import EcommerceOrderChart from './EcommerceOrderChart.vue'
import EcommerceProfitChart from './EcommerceProfitChart.vue'
import EcommerceEarningsChart from './EcommerceEarningsChart.vue'
import EcommerceBrowserStates from './EcommerceBrowserStates.vue'
import AffiliateCompanyTable from './AffiliateCompanyTable.vue'
import CompanyTable from './CompanyTable.vue'
import LenderCompanyTable from './LenderCompanyTable.vue'
import EcommerceMeetup from './EcommerceMeetup.vue'
import AffiliateRedirectRates from './AffiliateRedirectRates.vue'
import LenderRedirectRates from './LenderRedirectRates.vue'
import EarningsToday from './EarningsToday.vue'
import EarningsWeek from './EarningsWeek.vue'
import EarningsMonth from './EarningsMonth.vue'
import EarningsProfit from './EarningsProfit.vue'
import ApexLineAreaChart from "./ApexLineAreaChart.vue";

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
    EcommerceBrowserStates,
    AffiliateCompanyTable,
    LenderCompanyTable,
    CompanyTable,
    EcommerceMeetup,
    AffiliateRedirectRates,
    LenderRedirectRates,
      EarningsToday,
      EarningsWeek,
      EarningsMonth,
      EarningsProfit,
  },
  data() {
    return {
      data: {},
    }
  },

  created() {
        this.$http.get('/admin/getDashboardDataUK').then(response => {
            this.data = response.data
    })
  },
}
</script>

<style lang="scss">
@import '~@core/scss/vue/pages/dashboard-ecommerce.scss';
@import '~@core/scss/vue/libs/chart-apex.scss';
</style>
