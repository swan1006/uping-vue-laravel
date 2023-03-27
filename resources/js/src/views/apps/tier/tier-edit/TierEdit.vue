<template>
  <component :is="buyerData === undefined ? 'div' : 'b-card'">

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

    <b-tabs
      v-if="buyerData"
      pills
    >

      <!-- Tab: Account -->
      <b-tab active>
        <template #title>
          <feather-icon
            icon="BuyerIcon"
            size="16"
            class="mr-0 mr-sm-50"
          />
          <span class="d-none d-sm-inline">Account</span>
        </template>
        <buyer-edit-tab-account
          :buyer-data="buyerData"
          class="mt-2 pt-75"
        />
      </b-tab>

      <!-- Tab: Information -->
      <b-tab>
        <template #title>
          <feather-icon
            icon="InfoIcon"
            size="16"
            class="mr-0 mr-sm-50"
          />
          <span class="d-none d-sm-inline">Information</span>
        </template>
        <buyer-edit-tab-information class="mt-2 pt-75" />
      </b-tab>

      <!-- Tab: Social -->
      <b-tab>
        <template #title>
          <feather-icon
            icon="Share2Icon"
            size="16"
            class="mr-0 mr-sm-50"
          />
          <span class="d-none d-sm-inline">Social</span>
        </template>
        <buyer-edit-tab-social class="mt-2 pt-75" />
      </b-tab>
    </b-tabs>
  </component>
</template>

<script>
import {
  BTab, BTabs, BCard, BAlert, BLink,
} from 'bootstrap-vue'
import { ref, onUnmounted } from '@vue/composition-api'
import router from '@/router'
import store from '@/store'
import buyerStoreModule from '../TierStoreModule'
import BuyerEditTabAccount from './TierEditTabAccount.vue'
import BuyerEditTabInformation from './TierEditTabInformation.vue'
import BuyerEditTabSocial from './TierEditTabSocial.vue'

export default {
  components: {
    BTab,
    BTabs,
    BCard,
    BAlert,
    BLink,

    BuyerEditTabAccount,
    BuyerEditTabInformation,
    BuyerEditTabSocial,
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
