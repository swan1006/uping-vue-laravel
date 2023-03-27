<template>
  <div>

    <!-- Alert: No item found -->
    <b-alert
      variant="danger"
      :show="buyerTierData === undefined"
    >
      <h4 class="alert-heading">
        Error fetching buyerTier data
      </h4>
      <div class="alert-body">
        No buyerTier found with this buyerTier id. Check
        <b-link
          class="alert-link"
          :to="{ name: 'apps-buyer-tier-list'}"
        >
          BuyerTier List
        </b-link>
        for other buyerTiers.
      </div>
    </b-alert>

      <template v-if="buyerTierData">
          <!-- First Row -->
          <b-row>
              <b-col
                  cols="12"
                  xl="12"
                  lg="12"
                  md="12"
              >
                  <buyer-tier-view-user-info-card :buyer-tier-data="buyerTierData" />
              </b-col>
              <b-col
                  cols="12"
                  md="5"
                  xl="3"
                  lg="4"
              >
<!--                  <buyer-tier-view-user-plan-card :buyer-tier-data="buyerTierData"/>-->
              </b-col>
          </b-row>

          <b-row>
              <b-col
                  cols="12"
                  lg="6"
              >
                  <!--          <buyer-tier-view-buyer-timeline-card />-->
              </b-col>
              <b-col
                  cols="12"
                  lg="6"
              >
                  <!--          <buyer-tier-view-buyer-permissions-card />-->
              </b-col>
          </b-row>


          <!-- Tier invoice List -->
          <tier-invoice-list />


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
import buyerTierStoreModule from '../buyerTierStoreModule'
import BuyerTierViewUserInfoCard from './BuyerTierViewUserInfoCard.vue'
import BuyerTierViewUserPlanCard from './BuyerTierViewUserPlanCard.vue'
import BuyerTierViewUserTimelineCard from './BuyerTierViewUserTimelineCard.vue'
import BuyerTierViewUserPermissionsCard from './BuyerTierViewUserPermissionsCard.vue'
import TierInvoiceList from '@/views/apps/invoice/tier-invoice-list/TierInvoiceList.vue'

export default {
  components: {
    BRow,
    BCol,
    BAlert,
    BLink,

    // Local Components
    BuyerTierViewUserInfoCard,
    BuyerTierViewUserPlanCard,
    BuyerTierViewUserTimelineCard,
    BuyerTierViewUserPermissionsCard,

    TierInvoiceList,

  },
  setup() {
    const buyerTierData = ref(null)

    const BUYER_TIER = 'app-buyer-tier'

    // Register module
    if (!store.hasModule(BUYER_TIER)) store.registerModule(BUYER_TIER, buyerTierStoreModule)

    // UnRegister on leave
    onUnmounted(() => {
      if (store.hasModule(BUYER_TIER)) store.unregisterModule(BUYER_TIER)
    })

    store.dispatch('app-buyer-tier/fetchBuyerTier', { id: router.currentRoute.params.id })
      .then(response => { buyerTierData.value = response.data })
      .catch(error => {
        if (error.response.status === 404) {
          buyerTierData.value = undefined
        }
      })

    return {
      buyerTierData,

    }
  },
}
</script>

<style>

</style>
