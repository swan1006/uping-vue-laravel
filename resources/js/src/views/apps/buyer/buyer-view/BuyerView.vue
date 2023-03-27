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
          xl="12"
          lg="12"
          md="12"
        >
          <buyer-view-user-info-card :buyer-data="buyerData" />
        </b-col>
        <b-col
          cols="12"
          md="6"
          xl="6"
          lg="6"
        >
            <buyer-company-user-info-card :buyer-data="buyerData" />

        </b-col>
          <b-col
              cols="12"
              md="6"
              xl="6"
              lg="6"
          >
              <buyer-tier-user-info-card :buyer-data="buyerData" />

          </b-col>
      </b-row>

      <b-row>
        <b-col
          cols="12"
          lg="6"
        >
<!--          <buyer-view-buyer-timeline-card />-->
        </b-col>
        <b-col
          cols="12"
          lg="6"
        >
<!--          <buyer-view-buyer-permissions-card />-->
        </b-col>
      </b-row>

      <buyer-invoice-list :buyer-data="buyerData" />
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
import BuyerInvoiceList from '@/views/apps/invoice/buyer-invoice-list/BuyerInvoiceList.vue'
import buyerStoreModule from '../buyerStoreModule'
import BuyerViewUserInfoCard from './BuyerViewUserInfoCard.vue'
import BuyerTierUserInfoCard from './BuyerTierUserInfoCard.vue'
import BuyerCompanyUserInfoCard from './BuyerCompanyUserInfoCard.vue'
import BuyerViewUserPlanCard from './BuyerViewUserPlanCard.vue'
import BuyerViewUserTimelineCard from './BuyerViewUserTimelineCard.vue'
import BuyerViewUserPermissionsCard from './BuyerViewUserPermissionsCard.vue'

export default {
  components: {
    BRow,
    BCol,
    BAlert,
    BLink,

    // Local Components
    BuyerViewUserInfoCard,
    BuyerCompanyUserInfoCard,
    BuyerTierUserInfoCard,
    BuyerViewUserPlanCard,
    BuyerViewUserTimelineCard,
    BuyerViewUserPermissionsCard,

    BuyerInvoiceList,
  },
  setup() {
    const buyerData = ref(null)

    const BUYER = 'app-buyer'

    // Register module
    if (!store.hasModule(BUYER)) store.registerModule(BUYER, buyerStoreModule)

    // UnRegister on leave
    onUnmounted(() => {
      if (store.hasModule(BUYER)) store.unregisterModule(BUYER)
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
