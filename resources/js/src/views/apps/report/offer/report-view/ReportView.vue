<template>
  <div>

    <!-- Alert: No item found -->
    <b-alert
      variant="danger"
      :show="buyerData === undefined"
    >
      <h4 class="alert-heading">
        Error fetching buyer data
      </h4>
      <div class="alert-body">
        No buyer found with this buyer id. Check
        <b-link
          class="alert-link"
          :to="{ name: 'apps-buyers-list'}"
        >
          Buyer List
        </b-link>
        for other buyers.
      </div>
    </b-alert>

    <template v-if="buyerData">
      <!-- First Row -->
      <b-row>
        <b-col
          cols="12"
          xl="9"
          lg="8"
          md="7"
        >
          <buyer-view-buyer-info-card :buyer-data="buyerData" />
        </b-col>
        <b-col
          cols="12"
          md="5"
          xl="3"
          lg="4"
        >
          <buyer-view-buyer-plan-card />
        </b-col>
      </b-row>

      <b-row>
        <b-col
          cols="12"
          lg="6"
        >
          <buyer-view-buyer-timeline-card />
        </b-col>
        <b-col
          cols="12"
          lg="6"
        >
          <buyer-view-buyer-permissions-card />
        </b-col>
      </b-row>

      <invoice-list />
    </template>

  </div>
</template>

<script>
import store from '@/store'
import router from '@/router'
import { ref, onUnmounted } from '@vue/composition-api'
import {
  BRow, BCol, BAlert, BLink,
} from 'bootstrap-vue'
import InvoiceList from '@/views/apps/invoice/invoice-list/InvoiceList.vue'
import buyerStoreModule from '../ReportStoreModule'
import BuyerViewBuyerInfoCard from './ReportViewUserInfoCard.vue'
import BuyerViewBuyerPlanCard from './ReportViewUserPlanCard.vue'
import BuyerViewBuyerTimelineCard from './ReportViewUserTimelineCard.vue'
import BuyerViewBuyerPermissionsCard from './ReportViewUserPermissionsCard.vue'

export default {
  components: {
    BRow,
    BCol,
    BAlert,
    BLink,

    // Local Components
    BuyerViewBuyerInfoCard,
    BuyerViewBuyerPlanCard,
    BuyerViewBuyerTimelineCard,
    BuyerViewBuyerPermissionsCard,

    InvoiceList,
  },
  setup() {
    const buyerData = ref(null)

    const BUYER_APP_STORE_MODULE_NAME = 'app-buyer'

    // Register module
    if (!store.hasModule(BUYER_APP_STORE_MODULE_NAME)) store.registerModule(BUYER_APP_STORE_MODULE_NAME, buyerStoreModule)

    // UnRegister on leave
    onUnmounted(() => {
      if (store.hasModule(BUYER_APP_STORE_MODULE_NAME)) store.unregisterModule(BUYER_APP_STORE_MODULE_NAME)
    })

    store.dispatch('app-buyer/fetchBuyer', { id: router.currentRoute.params.id })
      .then(response => { buyerData.value = response.data })
      .catch(error => {
        if (error.response.status === 404) {
          buyerData.value = undefined
        }
      })

    return {
      buyerData,
    }
  },
}
</script>

<style>

</style>
